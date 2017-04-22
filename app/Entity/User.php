<?php

namespace App\Entity;

use App\Persistence\Record;
use App\Persistence\PdoDatabase;
use \PDO;

/**
 * User
 */
class User extends Record
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

    public function getId()
    {
        return $this->id;
    }

    private function __construct($id, $username, $emailAddress, $created, $updated)
    {
        $this->id = $id;
        $this->username = $username;
        $this->emailAddress = $emailAddress;
        $this->created = $created;
        $this->updated = $updated;
        return $this;
    }

    public static function find(int $id)
    {
        $SQL = "SELECT * FROM app_users WHERE id = :user_id";
        if ( !parent::$connection )
        {
            parent::$connection = parent::connect();
        }
        $statement = parent::$connection->prepare($SQL);
        $statement->bindParam(':user_id', $id, PDO::PARAM_INT);
        $statement->execute();
        $query = $statement->fetch(PDO::FETCH_ASSOC);

        // if not null.
            // return empty?

        return new self(
                $id,
                $query['username'],
                $query['email_address'],
                $query['created'],
                $query['updated']
            );
    }
}

