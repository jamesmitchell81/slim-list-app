<?php

namespace App\Entity;


/**
 * Class AppList
 * @package App\Entity
 */
class AppList
{

    /**
     * @var \User
     */
    private $user;

    /**
     * @var
     */
    private $id;
    /**
     * @var
     */
    private $list_name;
    /**
     * @var
     */
    private $description;
    /**
     * @var
     */
    private $created;
    /**
     * @var
     */
    private $updated;
    /**
     * @var bool
     */
    private $complete;

    public static function from(array $state)
    {
        // TODO: validate!!!!
        return new self(
                (int)$state['id'],
                $state['list_name'],
                $state['description'],
                $state['created'],
                $state['updated'],
                (bool)$state['complete']
            );
    }

    private function __construct(int $id, $list_name, $description, $created, $updated, bool $complete)
    {
        $this->id = $id;
        $this->list_name = $list_name;
        $this->description = $description;
        $this->created = $created;
        $this->updated = $updated;
        $this->complete = $complete;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getListName()
    {
        return $this->list_name;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @return mixed
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @return mixed
     */
    public function getComplete()
    {
        return $this->complete;
    }
}

