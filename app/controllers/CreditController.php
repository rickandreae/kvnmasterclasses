<?php

use Phalcon\Mvc\Controller;

class CreditController extends ControllerBase
{
    public function indexAction()
    {  
        $auth = $this->session->get('auth');
        $this->view->auth = $auth;
    }
}