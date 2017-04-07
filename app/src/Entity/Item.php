<?php



/**
 * Item
 */
class Item
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $value;

    /**
     * @var timestamp
     */
    private $created;

    /**
     * @var timestamp
     */
    private $updated;

    /**
     * @var boolean
     */
    private $complete = false;

    /**
     * @var boolean
     */
    private $deleted = false;

    /**
     * @var \AppList
     */
    private $list;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set value
     *
     * @param string $value
     *
     * @return Item
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set created
     *
     * @param \timestamp $created
     *
     * @return Item
     */
    public function setCreated(\timestamp $created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \timestamp
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \timestamp $updated
     *
     * @return Item
     */
    public function setUpdated(\timestamp $updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \timestamp
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set complete
     *
     * @param boolean $complete
     *
     * @return Item
     */
    public function setComplete($complete)
    {
        $this->complete = $complete;

        return $this;
    }

    /**
     * Get complete
     *
     * @return boolean
     */
    public function getComplete()
    {
        return $this->complete;
    }

    /**
     * Set deleted
     *
     * @param boolean $deleted
     *
     * @return Item
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Get deleted
     *
     * @return boolean
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * Set list
     *
     * @param \AppList $list
     *
     * @return Item
     */
    public function setList(\AppList $list = null)
    {
        $this->list = $list;

        return $this;
    }

    /**
     * Get list
     *
     * @return \AppList
     */
    public function getList()
    {
        return $this->list;
    }
}

