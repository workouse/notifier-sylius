<?php
namespace Workouse\NotifierPlugin\Command;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Sylius\Component\Core\Repository\OrderRepositoryInterface;
use Sylius\Component\Customer\Model\Customer;
use Sylius\Component\Customer\Model\CustomerInterface;
use Sylius\Component\Order\Model\OrderInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Workouse\NotifierPlugin\Message\MailNotification;
use Workouse\NotifierPlugin\Trigger\TriggerInterface;

class NotifierCommand extends Command
{
    /** @var OrderRepositoryInterface */
    protected $orderRepository;
    /** @var MessageBusInterface */
    protected $bus;
    /** @var ContainerInterface */
    protected $container;

    public function __construct(OrderRepositoryInterface $orderRepository, MessageBusInterface $bus, ContainerInterface $container)
    {
        $this->orderRepository = $orderRepository;
        $this->bus = $bus;
        $this->container = $container;
        parent::__construct();
    }

    protected static $defaultName = "workouse:notifier:find";

    /**
     * undocumented function
     *
     * @return void
     */
    protected function configure()
    {
    }

    //logic:
    // step1: this command search database for notifier requirements
    // step2: add finded notifier actions to new table
    // step3: run other command for process
    // step4: process notifier actions

    protected function execute(InputInterface $input, OutputInterface $output)
    { ///bunlar zamanlanmış epostalar
        $scenarios = [
            [ //kullanıcı sepette ürün unuttuktan 3 gün sonra eposta
                'name' => 'your_cart_waiting',
                'trigger' => [
                    'waited_cart' => [
                        'delay' => "-1 days",
                    ]
                ],
                'notifiers' => [
                    'mail'
                ]
            ],
            [ // kullanıcı kayıt olup alışveriş yapmadıktan 3 gün sonra
                'name' => 'do_you_want_product',
                'trigger' => [
                    'register' => [
                        'delay' => '-3 days',
                        'purchase' => false
                    ]
                ],
                'notifiers' => [
                    'mail', 'sms'
                ]
            ],
            [
                'name' => 'referral_request',
                'trigger' => [
                    'register' => [
                        'delay' => '-1 week',
                    ]
                ],
                'notifiers' => [
                    'mail'
                ]
            ],
            [
                'name' => 'promotion_code',
                'trigger' => [
                    'register' => [
                        'delay' => '-2 weeks',
                    ]
                ],
                'notifiers' => [
                    'mail'
                ]
            ],
            [// kullanıcı alışveriş tamamladıktan 1 hafta sonra alışveriş anketi
                'name' => 'do_you_like_it',
                'trigger' => [
                    'purchase' => [
                        'delay' => '-1 week'
                    ]
                ],
                'notifiers' => [
                    'mail'
                ]
            ],
            [
                'name' => 'thank_you_for_your_response',
                'trigger' => [
                    'pool_response' => [
                        'delay' => 0,
                    ]
                ],
                'notifiers' => [
                    'mail'
                ]
            ],
            [// kullanıcı alışveriş tamamladıktan 1 ay sonra başka şey de al
                'name' => 'you_can_try_this',
                'trigger' => [
                    'purchase' => [
                        'delay' => '-1 month',
                    ]
                ],
                'notifiers' => [
                    'mail'
                ]
            ],
            [//yeni blog içeriği yazıldığı anda
                'name' => 'new_blog_post',
                'trigger' => [
                    'new_post' => [
                        'delay' => 0
                    ]
                ],
                'notifiers' => [
                    'mail', 'push'
                ]
            ]
        ];
        foreach ($scenarios as $scenario) {
            $keys = array_keys($scenario['trigger']);
            /** @var TriggerInterface $service */
            $service = $this->container->get(sprintf('workouse.trigger.%s', $keys[0]));
            $service->setDelayString($scenario['trigger'][$keys[0]]['delay']);
            $customers = $service->getCustomers();
            foreach ($customers as $customer) {
                foreach ($scenario['notifiers'] as $notifier) {

                    if (!($customer instanceof CustomerInterface)) {
                        continue;
                    }
                    //control
                    $notification = $service->getNotification($customer, $notifier);
                    $envelope = new Envelope($notification);
                    $this->bus->dispatch($envelope);
                }
            }
        }
    }

}

?>
