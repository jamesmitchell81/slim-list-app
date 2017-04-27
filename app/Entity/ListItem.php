<?php

namespace App\Entity;

/**
 * ListItem
 */
class ListItem extends Entity
{
    /**
     * @var string
     */
    private $value;

    /**
     * @var boolean
     */
    private $complete = false;

    /**
     * @var boolean
     */
    private $deleted = false;

    /**
     * @var bool
     */
    private $active = true;

    private $list;

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     */
    public function setValue(string $value)
    {
        $this->value = $value;
    }

    /**
     * @return bool
     */
    public function isComplete(): bool
    {
        return $this->complete;
    }

    /**
     * @param bool $complete
     */
    public function setComplete(bool $complete)
    {
        $this->complete = $complete;
    }

    /**
     * @return bool
     */
    public function isDeleted(): bool
    {
        return $this->deleted;
    }

    /**
     * @param bool $deleted
     */
    public function setDeleted(bool $deleted)
    {
        $this->deleted = $deleted;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @param bool $active
     */
    public function setActive(bool $active)
    {
        $this->active = $active;
    }

    /**
     * @return \App\Entity\AppList
     */
    public function getList(): AppList
    {
        return $this->list;
    }

    /**
     * @param \App\Entity\AppList $list
     */
    public function setList(AppList $list)
    {
        $this->list = $list;
    }

}

