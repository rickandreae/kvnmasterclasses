<?php

class AdminController extends ControllerBase
{
	public function indexAction()
	{
		$auth = $this->session->get('auth');
		if(empty($auth)){
            $this->response->redirect('');
        }
	}

	public function changecreditsAction()
	{
		$auth = $this->session->get('auth');
        $this->view->credits = credits::find();
		if(empty($auth)){
            $this->response->redirect('');
        }
		if($this->request->isPost())
        {
        $id = $this->request->getPost(user_id);
		$user = users::findFirstByuser_id($id);

        $creditvalue1 = $user->credits;
        $creditvalue2 = $this->request->getPost(credit_value);
        $creditvalue = $creditvalue1 + $creditvalue2;
        $user->credits = $creditvalue;
        $result = $user->save();
        if(!result) {
            print_r($user->getMessages());
        }else{
        	$this->response->redirect('');
        }
	}
}
}