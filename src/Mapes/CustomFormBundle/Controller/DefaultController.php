<?php

namespace Mapes\CustomFormBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Mapes\CMSBundle\Utils\pageCache as myPageCacheUtils;
use Mapes\CMSBundle\Utils\mailUtlis as myMailUtils;
use Mapes\CustomFormBundle\Entity\CustomFormEntry as CustomFormEntry;

class DefaultController extends Controller
{
    public function indexAction($slug,Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $custom_form = $em->getRepository('MapesCustomFormBundle:CustomForm')->getLiveFormBySlug($slug);
        if(!$custom_form)
            $custom_form = $em->getRepository('MapesCustomFormBundle:CustomForm')->find(1);
        
        
        if (!$custom_form) {
            throw $this->createNotFoundException('Unable to find Custom Form entity.');
        }

        $orgiFormFields = $custom_form->getFormFields();
        $orgiFormFields = json_decode($orgiFormFields);

        $formFields = array();
        
        foreach($orgiFormFields as $field)
        {
                $title = $field->title;
                $type = $field->type;
                
                $options = explode("\n", $field->options);
                $option_values = array();
                foreach($options as $option) {
                    $option_values[$option] = myPageCacheUtils::makeSlug("", strtolower(trim($option)));
                }
                
                $isMand = 'isMan=false';
                $manda = $field->manda;
                if($manda == "1")
	            $isMand = 'isMan=true';
                
                $help = $field->help; 
                
                $formFields[] = array(
                    'title' => $title,
                    'slug' => myPageCacheUtils::makeSlug("", strtolower(trim($title))),
                    'type' => $type,
                    'options' => $option_values,
                    'is_mandatory' => $isMand,
                    'help' => $help
                );
        }
        
        
        //Set session varible
        $session = $this->get('session');
        if($custom_form->getMetaTitle()){
            $session->set('meta_title', $custom_form->getMetaTitle());
        }
        if($custom_form->getMetaDescription()){
            $session->set('meta_description', $custom_form->getMetaDescription());
        }        
        
        
        //$request = $this->get('request');
        if($request->getMethod() == 'POST') {
            //var_dump($request->request->all());die();
            $postParameters = $request->request->all();
            
            $formFields = json_decode($custom_form->getFormFields());
            foreach($formFields as $key => $field){
                
                    $title = $field->title;
                    $slug = myPageCacheUtils::makeSlug("", strtolower(trim($title)));
                    $type = $field->type;
                    if(isset($postParameters['customform'][$slug])){
                        
                            $postval = $postParameters['customform'][$slug];
                            if($type == 'checkbox'){
                                $formFields[$key]->value = implode("\n",$postval);
                            }else{
                                $formFields[$key]->value = $postval;
                            }
                    }
                    
            }            
            
            $CustomFormEntry = new CustomFormEntry();
            $CustomFormEntry->setCustomForm($custom_form);
            $CustomFormEntry->setFormFields(json_encode($formFields));
            $CustomFormEntry->setIsActioned(0);
            
            $em->persist($CustomFormEntry);
            $em->flush();            
            
			$this->get('mail_helper')->notifiyAdminForFormEntry($custom_form->getTitle(), $CustomFormEntry->getFormFieldsValues());
			
            return $this->redirect($this->generateUrl('custom_form_thankyoupage', array('slug' => $custom_form->getSlug())));
        }        
        
        return $this->render('MapesCustomFormBundle:Default:index.html.twig', array(
            'custom_form' => $custom_form,
            'form_fields' => $formFields,
         ));
    }
    
    public function thankyouAction($slug,Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $custom_form = $em->getRepository('MapesCustomFormBundle:CustomForm')->getLiveFormBySlug($slug);
        if(!$custom_form)
            $custom_form = $em->getRepository('MapesCustomFormBundle:CustomForm')->find(1);
        
        
        if (!$custom_form) {
            throw $this->createNotFoundException('Unable to find Custom Form entity.');
        }
        
        //Set session varible
        $session = $this->get('session');
        if($custom_form->getMetaTitle()){
            $session->set('meta_title', $custom_form->getMetaTitle());
        }
        if($custom_form->getMetaDescription()){
            $session->set('meta_description', $custom_form->getMetaDescription());
        }        
        $session->set('canonical', 'http://'.$_SERVER['HTTP_HOST'].$custom_form->getFullUrl());
            
        
        return $this->render('MapesCustomFormBundle:Default:thankyou.html.twig', array(
            'custom_form' => $custom_form,
         ));
    }    
}
