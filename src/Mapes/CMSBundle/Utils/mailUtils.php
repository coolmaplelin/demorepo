<?php

namespace Mapes\CMSBundle\Utils;

use Mapes\CMSBundle\Utils\stringUtils;
use Mapes\UserBundle\Entity\Member;

class mailUtils {

    protected $mailer;
    protected $em;
    protected $templating;
    private $sender = "maple_lin2004@hotmail.com";
    private $site_name = "Demo";

    public function __construct(\Swift_Mailer $mailer, $em, $templating) {
        $this->mailer = $mailer;
        $this->em = $em;
        $this->templating = $templating;


        $repository = $this->em->getRepository('MapesCMSBundle:SiteSetting');
        $this->site_name = $repository->findOneBy(array('name' => 'site_name'))->getValue();
        $this->sender = $repository->findOneBy(array('name' => 'system-no-reply-email'))->getValue();
    }

    public function sendEmail($to, $subject, $body, $from = '') {
        if ($from == "")
            $from = $this->sender;

        $message = $this->mailer->createMessage()
                ->setSubject($subject)
                ->setFrom($from)
                ->setSender($from)
                ->setCharset('utf-8')
                ->setContentType('text/html')
                ->setTo($to)
                ->setBody($body);
        $this->mailer->send($message, $failedRecipients);
		//var_dump($failedRecipients);
        /* $fh = fopen('e:\\email.log', 'a') or die("can't open file ".$myFile);
          fwrite($fh, $message);
          fclose($fh); */
    }

    public function notifiyAdminForFormEntry($formTitle, $formFieldsValues) {
        $subject = "[" . $this->site_name . " Form] " . (string) $formTitle;
        $message = "A form has been submitted from the " . $this->site_name . " website.<br>";
        $message .= "This was sent at " . date("r") . "<br><br>";
        $message .= "----------------------------------------------------------------------------------------------------<br>";

        foreach ($formFieldsValues as $formFieldsValue) {

            $message .= str_pad($formFieldsValue['label'] . ":", 50) . $formFieldsValue['value'] . "<br>";
        }

        $message .= "----------------------------------------------------------------------------------------------------<br>";

        $emailBody = $this->templating->renderResponse('MapesCMSBundle:Emails:basic.html.twig', array(
                'first_name' => 'Admin',
                'email_body' => $message,
                'site_name' => $this->site_name
        ))->getContent();

        $adminEmails = stringUtils::parseEmails($this->em->getRepository('MapesCMSBundle:SiteSetting')->findOneBy(array('name' => 'admin_email'))->getValue());

        foreach ($adminEmails as $adminEmail) {
            $this->sendEmail($adminEmail, $subject, $emailBody);
        }
    }
	
	public function retrievePassword(Member $member, $newPassword) 
	{
		$subject = $this->site_name." :: Retrieve password request";
		$message = "You have requested a new password for ".$this->site_name.". <br /> ";
		$message .= "Your new password is: ".$newPassword."<br />";
		$message .= "You can now log in at http://".$_SERVER['SERVER_NAME']."/user/login. Once you log in, please change your password."."<br />";
        $emailBody = $this->templating->renderResponse('MapesCMSBundle:Emails:basic.html.twig', array(
                'first_name' => $member->getFirstName(),
                'email_body' => $message,
                'site_name' => $this->site_name
        ))->getContent();
		$this->sendEmail($member->getEmail(), $subject, $emailBody);
	}

}

?>