<?php
declare(strict_types=1);

namespace TildBJ\Abo\Service;

use TYPO3\CMS\Core\Mail\MailMessage;

/**
 * Class MailService
 */
class MailService
{
    /**
     * @var MailMessage
     */
    private $mailMessage;

    /**
     * MailService constructor.
     * @param MailMessage $mailMessage
     */
    public function __construct(MailMessage $mailMessage)
    {
        $this->mailMessage = $mailMessage;
    }

    /**
     * @param array $receiver
     * @param array $sender
     * @param string $subject
     * @param string $body
     */
    public function send(array $receiver, array $sender, string $subject, string $body)
    {
        $this->mailMessage->setContentType('text/html')
            ->setTo($receiver)
            ->setFrom($sender)
            ->setSubject($subject)
            ->setBody($body)
            ->send();
    }
}
