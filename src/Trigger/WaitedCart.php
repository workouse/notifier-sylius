<?php
/**
 * Created by PhpStorm.
 * User: delirehberi
 * Date: 01.10.2019
 * Time: 00:13
 */

namespace Workouse\NotifierPlugin\Trigger;


use Doctrine\ORM\EntityManagerInterface;
use PhpCollection\CollectionInterface;
use Sylius\Component\Core\Repository\OrderRepositoryInterface;
use Sylius\Component\Customer\Model\CustomerInterface;
use Sylius\Component\Order\Model\Order;
use Sylius\Component\Order\Model\OrderInterface;
use Workouse\NotifierPlugin\Message\AbstractNotifierMessage;
use Workouse\NotifierPlugin\Message\MailNotification;

class WaitedCart implements TriggerInterface
{
    private $delay;
    /** @var OrderRepositoryInterface */
    private $repository;
    /** this is extra data for waited_cart trigger */
    private $orders;

    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->repository = $orderRepository;
    }

    public function setDelayString(string $delay): TriggerInterface
    {
        $this->delay = $delay;
        return $this;
    }

    public function getDelay(): \DateTimeInterface
    {
        /** @var \DateTime $time */
        $time = new \DateTime();
        $time->modify($this->delay);
        return $time;
    }


    public function getCustomers():?array
    {
        $date = $this->getDelay();
        $qb = $this->repository->createCartQueryBuilder();
        $qb
            ->andWhere('o.state = :state')
            ->andWhere('o.updatedAt < :terminalDate')
            ->setParameter('state', OrderInterface::STATE_CART)
            ->setParameter('terminalDate', $date);

        $orders = $qb->getQuery()->getResult();
        $customers = [];
        $_orders = [];
        foreach ($orders as $order) {
            /** @var Order $order */
            $customers[] = $order->getCustomer();
            if ($order->getCustomer()) {
                $_orders[$order->getCustomer()->getId()] = $order;
            }
        }
        $this->orders = $_orders;
        unset($orders);
        return $customers;
    }

    public function getNotification(CustomerInterface $customer, string $message_name): AbstractNotifierMessage
    {

        $order = $this->orders[$customer->getId()];
        $notification = new MailNotification("demo", ["order_id" => $order->getId(), 'customer' => $customer->getId()]);
        $notification->setTrigger("cart_waited");
        return $notification;
    }


}