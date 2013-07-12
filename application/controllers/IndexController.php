<?php

class IndexController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {

        // action body
        $users = new Application_Model_Users();
        $user_answer = new Application_Model_UserAnswer();
        $form = new Application_Form_Feedback();
        $this->view->form = $form;

        $questionModel = new Application_Model_Question();
        $question = $questionModel->fetchAll($where = 'questionType=0');
        $textareaQuestion = $questionModel->fetchAll($where = 'questionType=1');

        $indexmodel = new Application_Model_Feedback;
       
        foreach ($question as $key) {
            $questionid = $key['Id'];

            $answers = $indexmodel->fetchAll($where = 'questionId=' . $questionid);
            foreach ($answers as $key1) {
                $form->getElement($key['questionType'] . '' . $key['Id'])
                        ->addMultiOptions(array($key1['Id'] => $key1['answer']));
            }
        }

        $result = $indexmodel->getCountries();
        foreach ($result as $key => $value) {
            $form->getElement('country')
                    ->addMultiOptions(array($key => $value));
        }

        if ($this->getRequest()->isPost()) {
            if ($this->view->form->isValid($_POST)) {
                // process data here

            
            
                $email = $form->getValue('email');
                if ($users->checkUnique($email)) {
                    $this->view->errorMessage = "you have already completed survey. Thank you.";
                    return;
                }

                $userData = array(
                    'fname' => $form->getValue("fname"),
                    'lname' => $form->getValue('lname'),
                    'email' => $form->getValue('email'),
                    'address' => $form->getValue('address'),
                    'address1' => $form->getValue('address1'),
                    'country' => $form->getValue('country')
                );

                $users->insert($userData);

                $id = $users->getId($email);



                foreach ($question as $key) {
                 
                 
                     $questionid = $key['Id'];
                    $x = array('userId' => $id, 'questionId' => $questionid, 'answerId' => $form->getValue('0' . $questionid));
                   
                    $user_answer->insertdata($x);
                }
                
                foreach ($textareaQuestion as $key) {
                    $questionid = $key['Id'];
                    $data = array('userId' => $id, 'questionId' => $questionid, 'answer' => $form->getValue('1' . $questionid));
                    
                    $user_answer->insertdata($data);
                    
                }
                
                
                $this->_helper->flashMessenger->addMessage('thank you for your feedback.');

                $this->_helper->redirector('thanks');
                // vdump($surveyData);exit;
            } else {
                $this->view->errormessage = "errors on form, please check";
                $this->view->form->populate($_POST);
            }
        }
    }

    public function thanksAction() {
        // action body
        $this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');
        $this->view->messages = $this->_flashMessenger->getMessages();
    }

}

/*'lname' => $form->getValue('lname'), 
                    'email' => $form->getValue('email'), 
                    'address' => $form->getValue('address'),
                    'address1' => $form->getValue('address1'),
                    'country' =>$form->getValue('country')
 * 
 */
