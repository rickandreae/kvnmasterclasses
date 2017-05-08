<?php

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Model\Query;


class IndexController extends ControllerBase
{
    public function indexAction()
    {
    	mediabrons::find();
    	$query = $this->modelsManager->createQuery("SELECT media_id, videos, thumbnail, titel, subtitel, description FROM mediabrons ORDER BY media_id LIMIT 8");
		$this->view->mediabrons = $query->execute();
        $this->session->set('mediaid', array('id' =>  $_GET['id']));

    }
}