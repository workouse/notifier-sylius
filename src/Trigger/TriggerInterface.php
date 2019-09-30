<?php
/**
 * Created by PhpStorm.
 * User: delirehberi
 * Date: 01.10.2019
 * Time: 00:14
 */

namespace Workouse\NotifierPlugin\Trigger;


use PhpCollection\CollectionInterface;
use Sylius\Component\Customer\Model\CustomerInterface;
use Workouse\NotifierPlugin\Message\AbstractNotifierMessage;
use Workouse\NotifierPlugin\MessageHandler\AbstractNotificationHandler;

interface TriggerInterface
{
    public function getDelay(): \DateTimeInterface;

    public function setDelayString(string $delay): TriggerInterface;

    public function getCustomers():?array;

    public function getNotification(CustomerInterface $customer, string $message_name): AbstractNotifierMessage;
}