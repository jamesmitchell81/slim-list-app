<?php

namespace App\Entity;

/**
 * ListItem
 */
class ListItem
{
    /**
     * @var string
     */
    private $value;

    /**
     * @var integer
     */
    private $id;

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

}

