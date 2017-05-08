<?php

use Phalcon\Mvc\Controller;
use kphalcon\Forms\ChangePasswordForm;

class ControllerBase extends Controller
{
	public function initialize()
	{
        $auth = $this->session->get('auth');
        $this->view->auth = $auth;
	}
}