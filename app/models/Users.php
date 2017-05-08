<?php

use Phalcon\Mvc\Model,
    Phalcon\Mvc\Model\Validator\Uniqueness;
use Phalcon\Mvc\Model\Behavior\Timestampable;

class users extends Model
{ 
	public $user_id;

    public $firstname;

    public $lastname;

    public $email;

    public $password;

    public $phone;

    public $address;

    public $zipcode;

    public $city;

    public $lvl;

    public $credits;

    public $roles_id;

    public $school_id;

    public function initialize()
    {
        $this->hasMany('user_id', 'Products', 'user_id');
        $this->hasMany('user_id', 'Student', 'user_id');
        $this->hasMany('user_id', 'Leraar', 'user_id');
        $this->hasMany('user_id', 'Ondernemer', 'user_id');
    }

    public function beforeCreate()
    {
        $this->created_at = date('Y-m-d H:i:s');
    }

    public function beforeUpdate()
    {
        $this->updated_at = date('Y-m-d H:i:s');
    }


    // public function validation()
    // {
    //     $this->validate(new Uniqueness(
    //         array(
    //                 "field" => "email",
    //                 "message" => "the email is already registered"
    //             )
    //         ));

    //     return $this->validationHasFailed() != true;
    // }
}