<?php
/**
 * Created by PhpStorm.
 * User: delirehberi
 * Date: 30.09.2019
 * Time: 23:50
 */

namespace Workouse\NotifierPlugin\Message;


abstract class AbstractNotifierMessage
{
    private $trigger;
    private $metadata;

    public function getTrigger()
    {
        return $this->trigger;
    }

    public function setTrigger(string $trigger)
    {
        $this->trigger = $trigger;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * @param mixed $metadata
     * @return AbstractNotifierMessage
     */
    public function setMetadata($metadata)
    {
        $this->metadata = $metadata;
        return $this;
    }


}