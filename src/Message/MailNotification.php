<?php
/**
 * Created by PhpStorm.
 * User: delirehberi
 * Date: 30.09.2019
 * Time: 20:42
 */

namespace Workouse\NotifierPlugin\Message;


class MailNotification extends AbstractNotifierMessage
{
    private $layout;
    private $parameters;

    public function __construct(string $layout, array $parameters = null)
    {
        $this->layout = $layout;
        $this->parameters = $parameters;
        $this->setMetadata($parameters);
    }

    public function getLayout(): string
    {
        return $this->layout;
    }

    public function getParameters():?array
    {
        return $this->parameters;
    }
}