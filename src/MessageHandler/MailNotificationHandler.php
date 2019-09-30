<?php
/**
 * Created by PhpStorm.
 * User: delirehberi
 * Date: 30.09.2019
 * Time: 20:45
 */

namespace Workouse\NotifierPlugin\MessageHandler;


use Sylius\Component\Customer\Model\Customer;
use Workouse\NotifierPlugin\Entity\NotifierLog;
use Workouse\NotifierPlugin\Message\MailNotification;

final class MailNotificationHandler extends AbstractNotificationHandler
{
    public function __invoke(MailNotification $notification)
    {
        $this->log($notification->getParameters()['customer'], $notification);
        echo "Processed: " . $notification->getTrigger() . "\n";
    }
}