<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use SendGrid\Mail\Mail;
use SendGrid\Mail\TemplateId;
use SendGrid\SendGrid;

class NewsletterVarification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = new Mail();

        // Set the sender (From) information
        $email->setFrom("salam@gmail.com", "Some guy");

        // Set the recipient (To) information
        $email->addTo(new To("imran.skylinxtech@gmail.com", "Another guy"));

        // Set the template ID
        $email->setTemplateId("d-9c8e85a4e7e144df80d4b725d4e55634");

        // === Here comes the dynamic template data! ===
        $email->addDynamicTemplateDatas([]);

        // Initialize the SendGrid API key
        $sendgrid = new \SendGrid('YOUR_SENDGRID_API_KEY');

        // Send the email using the send() method
        $response = $sendgrid->send($email);
    }
}
