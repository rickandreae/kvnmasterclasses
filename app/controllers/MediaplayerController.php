<?php

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\View;

class MediaplayerController extends ControllerBase
{
	public function indexAction()
	{
		$auth = $this->session->get('auth');
        $id = $this->session->get('auth');
        // $this->view->setVars([
        //     'single2' => 
        //     ]);
        $this->view->setVars([
            'single' => Users::findFirstByuser_id($id['userid']),
        ]);
		if($auth['lvl'] == 6){
		$this->view->mediabrons = mediabrons::find();
	}else{
		$this->response->redirect('');
	}
		$this->session->set('mediaid', array('id' =>  $_GET['id']));
	}

	public function playbronsAction()
	{
        
        $auth = $this->session->get('auth');
        $id = $this->session->get('auth');
		$this->session->set('mediaid', array('id' =>  $_GET['id']));
                $this->view->setVars([
            'single' => Users::findFirstByuser_id($id['userid']),
        ]);
        $this->session->set('id', array('id' =>  $_GET['id']));
                $this->view->setVars([
            'single2' => mediabrons::findFirstBymedia_id($_GET['id']),
        ]);
	} 

	public function bronsvideoAction() 
	{
		$auth = $this->session->get('auth');
		if(empty($auth)){
            $this->response->redirect('');
        }
        if($auth['lvl'] == 6){
		if($this->request->isPost()){
				$videos = $this->request->getPost('videos');
				$titel = $this->request->getPost('titel');
                $subtitel = $this->request->getPost('subtitel');
				$description = $this->request->getPost('description');
				$thumbnail = $this->request->getPost('thumbnail');
				$credit_amount = $this->request->getPost('credit_amount');
                $student_plaatsen = $this->request->getPost('student_plaatsen');
                $docent_plaatsen = $this->request->getPost('docent_plaatsen');
                $ondernemer_plaatsen = $this->request->getPost('ondernemer_plaatsen');
				$mediabrons = new mediabrons();

				$mediabrons->videos = $videos;
				$mediabrons->titel = $titel;
                $mediabrons->subtitel = $subtitel;
				$mediabrons->thumbnail = $thumbnail;
				$mediabrons->description = $description;
				$mediabrons->credit_amount = $credit_amount;
                $mediabrons->student_plaatsen = $student_plaatsen;
                $mediabrons->docent_plaatsen = $docent_plaatsen;
                $mediabrons->ondernemer_plaatsen = $ondernemer_plaatsen;
                $mediabrons->event_date = 0;

            if($mediabrons->save() != false)
            {
                $this->view->message = 'upload went right';
            }else{
                $this->view->message = 'something went wrong';
            }
				
		}
	}		
	}

    public function subvideoAction()
    {
        $auth = $this->session->get('auth');
        if(empty($auth)){
            $this->response->redirect('');
        }
        if($auth['lvl'] == 6){
        if($this->request->isPost()){
                $subvideos = $this->request->getPost('subvideos');
                $titel = $this->request->getPost('titel');
                $thumbnail = $this->request->getPost('thumbnail');
                $mediabrons_id = $this->request->getPost('mediabrons');

                $submedia = new submedia();

                $submedia->subvideos = $subvideos;
                $submedia->titel = $titel;
                $submedia->thumbnail = $thumbnail;
                $submedia->mediabrons_id = $mediabrons_id;

            if($submedia->save() != false)
            {
                $this->view->message = 'upload went right';
            }else{
                $this->view->message = 'something went wrong';
            }
                
        }
    }        
    }

    public function addthumbAction()
    {
        $auth = $this->session->get('auth');
        if(empty($auth)){
            $this->response->redirect('');
        }
    if($this->request->isPost())
        {
        $id = $this->request->getPost('mediabrons');
        $videolink = $this->request->getPost('videolink');
        $mediabrons = mediabrons::findFirstBymedia_id($id);
        $mediabrons->videos = $videolink;
        $result = $mediabrons->save();
        if(!result){
            $this->view->message = 'Not done';
        }else{
            $this->view->message = 'Done';
        }

    }
}



    public function videoactionsAction()
    {
        $auth = $this->session->get('auth');
		$this->view->mediabrons = mediabrons::find();
    }

    public function deletevideoAction($media_id)
    {
    	$auth = $this->session->get('auth');
    	if($auth['lvl'] == 6){
            $media = mediabrons::findFirstBymedia_id($media_id);
            if($media->delete() != false){
                $this->response->redirect('');
            }else{
                $this->response->redirect('');
            }
    }
}

 public function uploadAction(){
        $auth = $this->session->get('auth');
        $this->view->auth = $auth;

        if(empty($auth)){
            $this->response->redirect('');
        }

        if ($this->request->hasFiles() == true){
          
            $baseLocation = 'img/thumbnail/';

            if(!file_exists($baseLocation)){
                mkdir($baseLocation, 0777);
            }
             $extension = array(
              'jpg',
              'png',
              'jpeg');

          foreach ($this->request->getUploadedFiles() as $file) {
            
            if(in_array($file->getExtension(), $extension))
            {
                $path = $baseLocation . $file->getName();
                $this->view->message = $file->getExtension();
                if($file->moveTo($path) != false){
                    $this->view->message .= ' moved';
                }else{
                    $this->view->message .= ' no move';
                }

                 $this->view->message = 'file is uploaded';
            }else{
    
                $this->view->message = 'file is not uploaded... ext: ' . $file->getExtension();
            }         
          }
        }

}

 public function uploadheaderAction(){

        $auth = $this->session->get('auth');
        $this->view->auth = $auth;

        if(empty($auth)){
            $this->response->redirect('');
        }

        if ($this->request->hasFiles() == true){
          
            $baseLocation = 'img/header/';

            if(!file_exists($baseLocation)){
                mkdir($baseLocation, 0777);
            }
             $extension = array(
              'jpg',
              'png',
              'jpeg');

          foreach ($this->request->getUploadedFiles() as $file) {
            
            if(in_array($file->getExtension(), $extension))
            {
                $path = $baseLocation . $file->getName();
                $this->view->message = $file->getExtension();
                if($file->moveTo($path) != false){
                    $this->view->message .= ' moved';
                }else{
                    $this->view->message .= ' no move';
                }

                 $this->view->message = 'file is uploaded';
            }else{
    
                $this->view->message = 'file is not uploaded... ext: ' . $file->getExtension();
            }         
          }
        }

}


}
