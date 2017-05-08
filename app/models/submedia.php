<?php

use Phalcon\Mvc\Model;

class submedia extends Model
{
	public $id;
	public $mediabrons_id;
	public $subvideos;
	public $thumbnail;
	public $titel;
	public $description;

	 public function initialize()
    {
    	$this->belongsTo("mediabrons_id", "mediabrons", "media_id");
    }
}


