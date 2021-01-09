<?php
namespace App\Services;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use App\Mail\GlobalMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Acme\Email\EmailParser;

/**
 * Description of EmailService
 *
 * @author debut30
 */
class EmailService
{    

    /* _sendEmail
     * send mail using send grid api
     */

    public static function _sendEmail($to, array $substitution, $subject, $attachments = null)
    {
        $self = new static();

        if ($self->isSendGrid) {
            $templateId = $self->getSendGirdTemplate($template);            
            return $self->bySendGrid($to, $substitution, $subject, $templateId, $attachments,$template);
        }

        return $self->bySmtp($to, $substitution, $subject, $template, $attachments);
    }

    public function bySendGrid($to, array $substitution, $subject, $attachments = null,$template_id)
    {
        //create mail object
        $mail = new \SendGrid\Mail\Mail();
        //setting debug
        $mail_settings = new \SendGrid\Mail\MailSettings();       
        $sandbox_mode = new \SendGrid\Mail\SandBoxMode();
        $sandbox_mode->setEnable(true);
        $mail_settings->setSandboxMode($sandbox_mode);        
        //$mail->setMailSettings($mail_settings);
        //$mail->setSubject($subject);
        
        //Removing colons from keys in subsitutions
        $substitution_without_colon = array();
        array_walk_recursive($substitution, function($value, $key) use (&$substitution_without_colon)
        {
            $substitution_without_colon[substr($key, 1)] = $value.'';
        });

        $mail->addSubstitutions($substitution_without_colon);

        //set from
        $mail->setFrom(env('MAIL_SENDER_EMAIL'),env('MAIL_SENDER_NAME'));
        $mail->addTo($to['email'],$to['name']);
       // $mail->setTemplateId($template);
        $email_template = EmailTemplate::find($this->templates[$template_id]);

        $mail->setSubject($email_template->subject);
        $html_content = $this->buildEmailContent($substitution,$email_template->description);

       // Log::info($html_content);

       $mail->addContent('text/html',$html_content);
        if (!empty($attachments)) {
            //set attachment
            $attachment = new \SendGrid\Mail\Attachment();
            $attachment->setContent($attachments);
            $attachment->setType('application/pdf');
            $attachment->setDisposition('attachment');
            $attachment->setFilename('Invoice.pdf');
            //course certificate 
            if($template_id=='100000020'){
                $attachment->setFilename('Certificate.pdf');
            }

            $mail->addAttachment($attachment);
        }
        //send email
        $sg = new \SendGrid(env('SENDGRID_API_KEY'));
        $request_body = $mail;
        $response = $sg->client->mail()->send()->post($request_body);     
        Log::error($response->statusCode());
        return $response->statusCode();
    }

    public function bySmtp($to, array $substitution, $subject, $templateId, $attachments = null)
    {
        if (isset($this->templates[$templateId])) {
            $template = EmailTemplate::find($this->templates[$templateId]);
            return Mail::to($to['email'])->send(new GlobalMail($substitution, $template, $attachments));
        }
    }

    // return html from blade
    public function buildEmailContent($parameters,$template_content)
    {
        $content = EmailParser::parse($parameters, $template_content);        
        $html = view('emails.email_template', compact('content'))->render();
        return $html;
    }
}

