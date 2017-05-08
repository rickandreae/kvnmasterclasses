<?php

use Phalcon\Mvc\Model;

class products extends Model
{
	public $id;
	public $user_id;
	public $media_id;
	public $activated;

	 public function initialize()
    {
    	$this->belongsTo('user_id', 'Users', 'user_id');
    }
}


