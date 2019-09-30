<?php
/**
 * Created by PhpStorm.
 * User: delirehberi
 * Date: 30.09.2019
 * Time: 21:51
 */

namespace Workouse\NotifierPlugin\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class NotifierLog
 * @package Workouse\NotifierPlugin\Entity
 * @ORM\Entity()
 * @ORM\Table(name="workouse_notifier_logs")
 */
class NotifierLog
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;
    /**
     * @ORM\ManyToOne(targetEntity="Sylius\Component\Customer\Model\Customer",fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="user_id",referencedColumnName="id")
     */
    protected $user;
    /**
     * @ORM\Column(type="string")
     */
    protected $trigger;
    /**
     * @ORM\Column(type="string")
     */
    protected $action;
    /**
     * @ORM\Column(type="datetime")
     */
    protected $datetime;

    /**
     * @ORM\Column(type="json",nullable=true)
     */
    protected $meta;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return NotifierLog
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     * @return NotifierLog
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTrigger()
    {
        return $this->trigger;
    }

    /**
     * @param mixed $trigger
     * @return NotifierLog
     */
    public function setTrigger($trigger)
    {
        $this->trigger = $trigger;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param mixed $action
     * @return NotifierLog
     */
    public function setAction($action)
    {
        $this->action = $action;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDatetime()
    {
        return $this->datetime;
    }

    /**
     * @param mixed $datetime
     * @return NotifierLog
     */
    public function setDatetime($datetime)
    {
        $this->datetime = $datetime;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMeta()
    {
        return $this->meta;
    }

    /**
     * @param mixed $meta
     * @return NotifierLog
     */
    public function setMeta($meta)
    {
        $this->meta = $meta;
        return $this;
    }


}