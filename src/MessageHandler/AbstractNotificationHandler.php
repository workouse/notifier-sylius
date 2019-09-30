<?php
/**
 * Created by PhpStorm.
 * User: delirehberi
 * Date: 30.09.2019
 * Time: 23:20
 */

namespace Workouse\NotifierPlugin\MessageHandler;


use Doctrine\ORM\EntityManagerInterface;
use Sylius\Component\Customer\Model\Customer;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Workouse\NotifierPlugin\Entity\NotifierLog;
use Workouse\NotifierPlugin\Message\AbstractNotifierMessage;

abstract class AbstractNotificationHandler implements MessageHandlerInterface
{
    /** @var EntityManagerInterface */
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }


    protected function log($customer_id, AbstractNotifierMessage $trigger, $metadata = [])
    {
        $customer = $this->em->getRepository(Customer::class)->find($customer_id);
        $nolog = new NotifierLog();
        $nolog->setUser($customer)
            ->setAction(get_class($this))
            ->setDatetime(new \DateTime())
            ->setTrigger($trigger->getTrigger())
            ->setMeta($trigger->getMetadata());

        $this->em->persist($nolog);
        $this->em->flush();
    }
}