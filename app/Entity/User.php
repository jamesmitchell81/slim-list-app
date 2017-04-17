<?php

namespace App\Entity;

/**
 * User
 */
class User
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $emailAddress;

    /**
     * @var string
     */
    private $password;

    /**
     * @var timestamp
     */
    private $created;

    /**
     * @var timestamp
     */
    private $updated;

    public function find(int $id)
    {

    }
}

