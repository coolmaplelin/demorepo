<?php

namespace Mapes\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
//use Symfony\Component\Validator\Constraints\Length;
use Mapes\UserBundle\Entity\Member;

class MemberRegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('first_name', null, array('attr' => array('class' => 'form-control'), 'required' => true))
			->add('last_name', null, array('attr' => array('class' => 'form-control'), 'required' => true))
			->add('username', null, array('attr' => array('class' => 'form-control')))
			->add('email', 'email', array('attr' => array('class' => 'form-control'), 'required' => true))
			//->add('plain_password', 'password', array('label' => 'Password'))
			->add('plain_password', 'repeated', array(
					'type' => 'password',
					'invalid_message' => 'The password fields must match.',
					'options' => array('attr' => array('class' => 'form-control')),
					'required' => true,
					'first_options'  => array('label' => 'Password'),
					'second_options' => array('label' => 'Confirm Password'),
					//'constraints' => array(new Length(array('min' => 8, 'minMessage' => 'Password must be at least 8 characters long.' ))    )
			))
        ;


    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
                'data_class' => 'Mapes\UserBundle\Entity\Member',
                'csrf_protection' => true,
                'csrf_field_name' => '_token',
                'validation_groups' => function(FormInterface $form){
                    /*
                     * You can return different validation group base on the value of the form data
                     * $data = $form->getData();
                    if($data->getUseShipping() == true)
                        return array('Default', 'separateShipping');
                    else
                        return array('Default');
                     * 
                     */
            
                     return array('Default', 'Registration');
                }
            ));        
    }

    public function getName()
    {
        return 'mapes_userbundle_memberregistertype';
    }
}
