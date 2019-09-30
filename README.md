<p align="center">
    <a href="https://sylius.com" target="_blank">
        <img src="https://demo.sylius.com/assets/shop/img/logo.png" />
    </a>
</p>

<h1 align="center">Notifier Plugin For Sylius eCommerce</h1>

<p align="center">You can manage all notifications (email, push-notifications, sms) for sylius commerce projects.</p>

### Requirements

- `composer require symfony/messenger`
- add messenger transport dsn to .env file
- configure your messenger.
```
    framework:
        messenger:
             transports:
                 async: "%env(MESSENGER_TRANSPORT_DSN)%"
             routing:
               'Workouse\NotifierPlugin\Message\MailNotification': async
```

## Installation

1. Run `composer require workouse/notifier-sylius`.

2. Symfony Flex resolve all configurations for you.
