<?php

namespace Project\Client\Models;

use Phalcon\Mvc\Model;

class Client extends Model
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $email;


    /**
     * Method to set the value of field id
     *
     * @param integer $id
     */
    public function setId($id)
    {
        $this->id = $id;
	    return $this;

    }
    public function getId($id)
    {
        return $this->id;
    }
}