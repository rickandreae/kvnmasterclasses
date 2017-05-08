<?php

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Model\Validator\Uniqueness;

class SessionController extends ControllerBase
{
    public function indexAction()
    {
        $auth = $this->session->get('auth');
        $this->view->auth = $auth;
        if($this->request->isPost())
        {
            $password = $this->request->getPost("password");
            $email = $this->request->getPost('email');
            $user = Users::findFirstByEmail($email);
            $product = Products::findFirstByuser_id($user->user_id);
            if ($user) { if ($this->security->checkToken()){
                if ($this->security->checkHash($password, $user->password)) {
                    $this->_authSession($user);
                    $this->response->redirect('');
                }
                else{
                    $this->view->title = '';
                }
            }
        }
        }
        // The validation has failed
    }



    private function _authSession($user){
        $this->session->set('auth', array(
            'firstname' => $user->firstname,
            'lastname' => $user->lastname,
            'email' => $user->email,
            'phone' => $user->phone,
            'address' => $user->address,
            'zipcode' => $user->zipcode,
            'city' => $user->city,
            'userid' => $user->user_id,
            'lvl' => $user->lvl
            ));
    }


    public function ProfileAction()
    {
        $auth = $this->session->get('auth');
        $id = $this->session->get('auth');
        $this->view->setVars([
            'single' => Users::findFirstByuser_id($id['userid']),
        ]);
    }

        public function buyvideoAction()
        {
        $this->session->set('video', array('id' =>  $_GET['id']));
        $id = $this->session->get('auth');
        $user = Users::findFirstByuser_id($id['userid']);
        $show = $this->session->get('video');
        $this->view->message1 = $show['id'];
        $this->view->message2 = $show['id'];
        $media = mediabrons::findFirstBymedia_id($show['id']);
        $this->view->message3 = $media;
        if ($user->credits < $media->credit_amount) {
            $this->view->message = 'Niet genoeg muntjes';
        }else{
        $creditvalue1 = $user->credits;
        $creditvalue2 = $media->credit_amount;
        
        $user->credits = $creditvalue1 - $creditvalue2;
        $result = $user->save();

        $mediaid = $show['id'];
        $activated = 1;
        $product = new Products();
        $userid = $user->user_id;
             $product->user_id = $userid;
             $product->mediabrons_id = $mediaid;
             $product->activated = $activated;
             if($product->save() != false)
             {
                 $this->response->redirect('session');
             }else{
                 $this->view->message = 'something went wrong';
                 print_r($show);
             }
         }
         }

        // public function reserveAction()
        // {
        //     $this->session->set('video', array('id' => $_GET['id']));
        //     $id = $this->session->get('auth');
        //     $user = Users::findFirstByuser_id($id['userid']);
        //     $show = $this->session->get('video');
        //     $media = mediabrons::findFirstBymedia_id($show['id']);
        //     $userproducts = products::find();
        //     $userproduct = $this->modelsManager->createQuery("SELECT * from products WHERE user_id = $user and mediabrons_id = $media");
        //     print_r($userproduct);
        // }

        public function buycreditAction()
        {
            if (!$auth) {
                $this->response->redirect('session/register');
            }
                $this->view->disable();
                $id = $this->session->get('auth');
                $tickets = $this->request->getPost('credits');
                $user = Users::findFirstByuser_id($id['userid']);

                $pdf = new mPDF();


                $pdf->WriteHTML('<div style="position: absolute; left:0; right: 0; top: 0; bottom: 0;"><img style="width: 210mm; height: 297mm; margin: 0;" src="../public/img/masterclasspdf.jpg"></div>');
                $pdf->WriteHTML('<div style="position:absolute; margin-top:65mm">', 2, true, false);
                $pdf->WriteHTML('<h1>Registratie gegevens</h1><br>', 2, false, false);
                $pdf->WriteHTML($user->firstname.' ', 2, false, false);
                $pdf->WriteHTML($user->lastname.'<br>', 2, false, false);
                $pdf->WriteHTML($user->email.'<br>', 2, false, false);
                $pdf->WriteHTML($user->phone.'<br>', 2, false, false);
                $pdf->WriteHTML($user->address.'<br>', 2, false, false);
                $pdf->WriteHTML($user->zipcode.'<br>', 2, false, false);
                $pdf->WriteHTML($user->city.'<br>', 2, false, false);
                $pdf->WriteHTML('aantal tickets: '.$tickets, 2, false, true);
                $pdf->WriteHTML('</div>');
                $content = $pdf->Output();


                // Create instance of Swift_Attachment with our PDF file
                $attachment = new Swift_Attachment($content, 'order.pdf', 'application/pdf');
                
                $message = Swift_Message::newInstance()
                  ->setSubject('Bestelling gegevens')
                  ->setFrom(array('rickandreae@hotmail.com' => 'Rick Andreae'))
                  ->setTo(array('b.bloemhof@kweekvijernoord.nl', 'r.andreae@kweekvijvernoord.nl' => 'Kweekvijver'))
                  ->setBody('Bestelling van ....')
                  ->attach($attachment);
                
                $transport = Swift_MailTransport::newInstance();
                
                // Create the Mailer using your created Transport
                $mailer = Swift_Mailer::newInstance($transport);
                
                // Send the created message
                $result = $mailer->send($message);
                
                // Then, you can send PDF to the browser
                // if(!$result)
                // {
                //     $this->response->redirect('session');
                // }else{
                //     $this->response->redirect('');
                // }
                $pdf->Output($filename ,'I');
        }

        public function changePhoneAction()
    {
        if($this->request->isPost())
        {
            $id = $this->session->get('auth');
            print_r($id['userid']);

             $user = Users::findFirstByuser_id($id['userid']);
             if (!$user) {
            echo "User does not exist";
            die;
        }
        $user->phone = $this->request->getPost('phone');
       if($user->save() != false) {
        $this->view->message = 'success';
        }else{$this->view->message = 'fail';}
        }     
    }


    // private function changepasswordAction()
    // {
    //     $password = new password();
    //    $oldpassword = $this->request->getPost('oldpassword'); 
    //    $newpassword = $this->request->getPost('newpassword');
    // }

        public function changeAddressAction()
    {
        if($this->request->isPost())
        {
            $id = $this->session->get('auth');
            print_r($id['userid']);
             $user = Users::findFirstByuser_id($id['userid']);
             if (!$user) {
            echo "User does not exist";
            die;
        }
        $user->address = $this->request->getPost('address');
        $user->zipcode = $this->request->getPost('zipcode');
        $user->city = $this->request->getPost('city');
        $result = $user->save();
        if(!result) {
            print_r($user->getMessages());
        }
        }
       
        
    }

    public function changePasswordAction()
    {
        if($this->request->isPost())
        {
            $id = $this->session->get('auth');
            print_r($id['userid']);

            $user = Users::findFirstByuser_id($id['userid']);
            $oldpassword = $this->request->getPost('oldpassword');
        if($oldpassword == $this->security->checkHash($oldpassword, $user->password))
        {
             if (!$user) {
            echo "User does not exist";
            die;
        }
        $password = $this->request->getPost('newpassword');
        $password = $this->request->getPost('newpassword1');
        $user->password = $this->security->hash($password);
        $result = $user->save();
        if(!$result) 
        {
            echo "Password not Changed!";       
        }
        else
        {
            echo "Password Changed!";
            die;
        }
    }
    }
    }

    public function registerAction()
    {
        $producten = $this->session->get('producten');
        $product1 = print_r($producten, true);
        $product2 = $product1[20];
        $product = $product2;

        if ($product == 1) {
            $this->view->message = 'hoi';
        }
        if ($product == 2) {
            
        }
        if ($product == 3) {
            
        }
        if ($product == 4) {
            
        }
        if ($product == 5) {
            
        }

        if($this->request->isPost())
        {
            $auth = $this->session->get('auth');
            $this->view->auth = $auth;
            $firstname = $this->request->getPost('firstname');
            $lastname = $this->request->getPost('lastname');
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');
            $phone = $this->request->getPost('phone');
            $address = $this->request->getPost('address');
            $zipcode = $this->request->getPost('zipcode');
            $city = $this->request->getPost('city');

            $user = new Users();

            $user->firstname = $firstname;
            $user->lastname = $lastname;
            $user->email = $email;
            $user->password = $this->security->hash($password);
            $user->phone = $phone;
            $user->address = $address;
            $user->zipcode = $zipcode;
            $user->city = $city;
            $user->created_at = 'date';
            $user->lvl = 1;
            $user->credits = 0;

            if($user->save() != false)
            {
                $this->view->message = 'woops';
                $roles_id = $this->request->getPost('roles_id');
                $user->roles_id = $roles_id;
                $result = $user->save();
                if(!$result){
                    $this->view->message = 'something went wrong';
                }else{
                $school_id = $this->request->getPost('school_id');
                $user->school_id = $school_id;
                $result = $user->save();
                if(!$result){
                    $this->view->message = 'something went wrong';
                }else{
                if ($roles_id == 1) {
                $userid = $user->user_id;
                $student = new Student();
                $student->user_id = $userid;
                                if($student->save() != false){
                    $this->view->message = 'good';
                }else{
                    $this->view->message = 'wrongg';
                    }
                }
                if ($roles_id == 2) {
                $userid = $user->user_id;
                $leraar = new Leraar();
                $leraar->user_id = $userid;
                                if($leraar->save() != false){
                    $this->view->message = 'good';
                }else{
                    $this->view->message = 'wrongg';
                    }
                }
                if ($roles_id == 3) {
                $userid = $user->user_id;
                $ondernemer = new Ondernemer();
                $ondernemer->user_id = $userid;
                if($ondernemer->save() != false){
                    $company_name = $this->request->getPost('companies');
                    $userid = $user->user_id;
                    $companies = new Companies();
                    $companies->user_id = $userid;
                    $companies->company_name = $company_name;
                    if($companies->save() != false){
                        $this->view->message = 'good';
                    }else{$this->view->message = 'wrongg';}
                }else{
                    }
                }
                    }
                }
            }
            }
}



    public function logoutAction()
    {
        $this->session->remove('auth');
        $this->response->redirect('');
    }
} 

