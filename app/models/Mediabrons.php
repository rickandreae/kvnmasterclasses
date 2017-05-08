<?php

use \Phalcon\Mvc\Model;
use \Phalcon\Mvc\Model\Query;

class mediabrons extends Model
{ 
	public $media_id;

	public $videos;

	public $titel;

	public $subtitel;

	public function initialize()
    {
        $this->hasMany("media_id", "submedia", "mediabrons_id");
    }

}
