<?php

/**
 * CodeMommy MailPHP
 * @author Candison November <www.kandisheng.com>
 */

namespace CodeMommy\MailPHP;

use Swift_SmtpTransport;
use Swift_Plugins_Loggers_EchoLogger;
use Swift_Plugins_LoggerPlugin;
use Swift_Message;
use Swift_Encoding;
use Swift_Mailer;

/**
 * Class Mail
 * @package CodeMommy\MailPHP
 */
class Mail
{

    private $smtp = null;
    private $port = null;
    private $username = null;
    private $password = null;

    /**
     * Mail constructor.
     *
     * @param $smtp
     * @param $port
     * @param $username
     * @param $password
     */
    public function __construct($smtp, $port, $username, $password)
    {
        $this->smtp = $smtp;
        $this->port = $port;
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * Send
     * @param $from
     * @param $fromName
     * @param $to
     * @param $toName
     * @param $subject
     * @param $content
     *
     * @return int
     */
    public function send($from, $fromName, $to, $toName, $subject, $content)
    {
        $transport = Swift_SmtpTransport::newInstance($this->smtp, $this->port)
            ->setUsername($this->username)
            ->setPassword($this->password);
        $mailer = Swift_Mailer::newInstance($transport);
//        $logger = new Swift_Plugins_Loggers_EchoLogger();
//        $mailer->registerPlugin(new Swift_Plugins_LoggerPlugin($logger));
        $message = Swift_Message::newInstance();
        $message->setEncoder(Swift_Encoding::get8BitEncoding())
            ->setSubject($subject)
            ->setFrom(array($from => $fromName))
            ->setTo(array($to => $toName))
            ->setBody($content, 'text/html');
//        $message->toString();
//        $logger->dump();
        $result = $mailer->send($message);
        return $result;
    }
}
