<?php 

namespace App\Util;


use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class Email
{
    private $mailer;
    
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;   
    }
    
    public function sendEmail($products)
    {
        $email = (new TemplatedEmail())
            ->from('email')
            ->to('email')
            ->subject('Mise a jour du prix des produits en solde')
            ->htmlTemplate('emails/updateProducts.html.twig')
            ->context([
                'products' => $products,
            ])
            ;
        
        $this->mailer->send($email);
    }
}