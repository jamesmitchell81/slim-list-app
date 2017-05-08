<?php

namespace App\Entity;

use \DateTime;

/**
 * Class Entity
 * @package App\Entity
 */
abstract class Entity
{
    /**
     * @var
     */
    private $id;
    /**
     * @var
     */
    private $created;
    /**
     * @var
     */
    private $updated;
    /**
     * @var string
     */
    private $date_time_format = "Y-m-d H:i:s";

    /**
     * @return mixed
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param string $format
     * @return mixed|string
     */
    public function getCreated(string $format = "") : string
    {
        if ( strlen($format) == 0 )
            return $this->created->format($this->date_time_format);

        return $this->created->format($format);
    }

    /**
     * @return int
     */
    public function getCreatedTimestamp() : int
    {
        return $this->created->getTimestamp();
    }

    /**
     * @param string $created
     */
    public function setCreated(string $created)
    {
        $this->created = DateTime::createFromFormat($this->date_time_format, $created);
    }

    /**
     * @param string $format
     * @return string
     */
    public function getUpdated(string $format = "") : string
    {
        if ( strlen($format) == 0 )
            return $this->updated->format($this->date_time_format);

        return $this->updated->format($format);
    }

    /**
     * @return int
     */
    public function getUpdatedTimestamp() : int
    {
        return $this->updated->getTimestamp();
    }

    /**
     * @param $updated
     */
    public function setUpdated($updated)
    {
        $this->updated = DateTime::createFromFormat($this->date_time_format, $updated);
    }

}