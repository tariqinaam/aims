<?php

class UserController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
        $this->user = '';
        $auth = Zend_Auth::getInstance();

        if ($auth->hasIdentity()) {
            $this->user = $auth->getIdentity();
            //vdump($this->user);
            //  exit;
        }
    }

    public function indexAction() {

        if (in_array($this->user->acl_role, array('dev', 'admin', 'manager'))) {
            $this->_redirect('/user/dashboard');
            exit();
        }
        else
            throw new Zend_Exception('Invalid ACL role', 403);
    }

    public function dashboardAction() {
        if (!in_array($this->user->acl_role, array('dev', 'admin', 'manager'))) {
            $this->_redirect('/user/login');
            exit();
        }
             if ($this->_helper->FlashMessenger->hasMessages()) {
        $this->view->messages = $this->_helper->FlashMessenger->getMessages();
    }
      
        $this->view->user = $this->user['fname'] . ' ' . $this->user['lname'];
        $this->view->dashboard_buttons = array();
        if (in_array($this->user->acl_role, array('dev', 'admin'))) {

            $this->view->dashboard_buttons[] = array(
                'url' => '/receipt/index',
                'text' => 'Create New Receipt'
            );
            $this->view->dashboard_buttons[] = array(
                'url' => '/user/create',
                'text' => 'Add New Member'
            );
            $this->view->dashboard_buttons[] = array(
                'url' => '/user/search',
                'text' => 'View Member Summary'
            );
            $this->view->dashboard_buttons[] = array(
                'url' => '/user/search-year',
                'text' => 'Full Report'
            );
        }
        if ('manager' == $this->user->acl_role) {
            $this->view->dashboard_buttons[] = array(
                'url' => '/receipt/index',
                'text' => 'Create New Receipt'
            );
        }
    }

    public function searchAction() {
        $user = new Application_Model_Member;
        if ($this->getRequest()->getParam('user_id', false)) {
            $this->passUser();
            exit;
        } elseif ($this->getRequest()->getParam('search', false)) {
            // get list of choices
            $db = Zend_Db_Table::getDefaultAdapter();
            $search = addslashes($this->getRequest()->getParam('search', ''));
            $sql = "
                SELECT 
                    m.ID, m.first_name, m.last_name
                FROM 
                    member m
                WHERE 
                    m.is_active = 1 AND 
                    CONCAT_WS(' ',m.first_name,m.last_name) LIKE UPPER('%" . $search . "%')
                ORDER BY 
                    m.first_name DESC";
            $rows = $db->fetchAll($sql);
            if (!$rows)
                $this->view->choices = false;
            else {
                $choices = array();
                foreach ($rows as $row) {
                    $choice = stripslashes($row['first_name'] . ' ' . $row['last_name'] . '');
                    $choices[$row['ID']] = str_ireplace(
                            stripslashes($search), '<strong><u>' . stripslashes($search) . '</u></strong>', $choice
                    );
                }
                $this->view->choices = $choices;
            }
            $this->view->search = $this->getRequest()->getParam('search', '');
        } else {
            if ($this->getRequest()->isPost())
                $this->view->choices = false;
            else
                $this->view->choices = null;
            $this->view->search = '';
        }
    }

    private function passUser() {
        if (!in_array($this->user->acl_role, array('dev', 'admin')))
            throw new Zend_Exception('Invalid ACL role', 403);

        $user_id = @intval($this->getRequest()->getParam('user_id', 0));
        $this->redirect('/user/summary/user_id/' . $user_id);
        exit();
    }

    public function summaryAction() {
        $db = Zend_Db_Table::getDefaultAdapter();
        $user_id = @intval($this->getRequest()->getParam('user_id', 0));

        if (!$user_id) {
            $this->_helper->FlashMessenger(array('Please select a user first', 'error'));
            $this->_redirect('/user/search');
            exit();
        }

        $memberTable = new Application_Model_Member();

        $year = new Application_Model_Year();
        $userRowset = $memberTable->find($user_id);
        $userRow = $userRowset->current();  // will return null on error
        if (is_null($userRow))
            throw new Zend_Exception('unable to get user row from db', 500);

        $this->view->user = $userRow;
        $sql1 = "select jamaat_name from jamaat WHERE ID =" . $userRow['jamaat_id'];
        $this->view->jamaat = $db->fetchOne($sql1);
        $sql = "SELECT * from receipt_type WHERE
                is_active = 1";
        $value = $db->fetchAll($sql);
        foreach ($value as $item) {
            $receipt_type[$item['receipt_name']] = $item['receipt_name'];
        }
        $this->view->receipt_type = $receipt_type;
         $sql3 = "SELECT * from year where is_active = 1";
        $year = $db->fetchAll($sql3);
        $this->view->years = $year;
        
        foreach($year as $year){
        $sql2 = "SELECT distinct(receipt_type), year,sum(value) as total FROM receipt_meta WHERE
                    user_id=" . $userRow['ID'] . " AND year=".$year['year']." group by receipt_type , year order by year";
        $receipts[$year['year']] = $db->fetchAll($sql2);
        }
        foreach ($receipts as $key =>$value) {
            foreach($value as $value)
            {
                vdump($value);
            }
            exit;
        }
        exit;
        $this->view->receipts = $receipts;
        
       
    }
    
    public function searchYearAction()
    {
          $db = Zend_Db_Table::getDefaultAdapter();
         $receipt = new Application_Model_Receipt;
         $year = new Application_Model_Year();
         $form = new Application_Form_Year();
         $all_year = $year->fetchAll($where= 'is_active = 1');
         
        foreach ($all_year as $year) {
            $form->getElement('year')
                    ->addMultiOptions(array($year['year'] => $year['year']));
        }
         
        $this->view->form = $form;
         
         if ($this->getRequest()->isPost()) {
            if ($this->view->form->isValid($_POST)) {
                // process data here
                $data = $form->getValues();
                $sel_year = $data['year'];
                $sql = "SELECT receipt_type, sum(value) as total from receipt_meta WHERE
                        year =$sel_year GROUP BY receipt_type";
                $value = $db->fetchAll($sql);
                foreach ($value as $item) {
                    $new_array[$item['receipt_type']] = $item['total'];
                }
               
                if ($value) {
                    $this->view->current_year = $sel_year;
                    $this->view->data = $new_array;
                }else{
                    $this->view->message = "No chanda has been paid yet in $sel_year";
                }
                //vdump($data);exit;
                //$this->redirect('/receipt/submit');
                // vdump($surveyData);exit;
                } else {
                $this->view->errormessage = "errors on form, please check";
                $this->view->form->populate($_POST);
            }
        }
    }

    public function logoutAction() {
        Zend_Auth::getInstance()->clearIdentity();

        $sessionDetails = new Zend_Session_Namespace('sessionDetails');
        $sessionDetails->unsetAll();
        $this->redirect('/user/login');
    }

    public function loginAction() {
        if (in_array($this->user->acl_role, array('dev', 'admin', 'manager')))
            $this->redirect('/user/dashboard');
        $userTable = new Application_Model_Users();
        $form = new Application_Form_Login();
        $this->view->form = $form;
        $this->view->flashMessages = $this->_helper->FlashMessenger->getMessages();
        if ($this->getRequest()->isPost()) {
            $postData = $this->_request->getPost();
            if ($form->isValid($postData)) {
                $data = $form->getValues();
                $auth = Zend_Auth::getInstance();
                $authAdapter = new Zend_Auth_Adapter_DbTable($userTable->getAdapter(), 'user');
                $authAdapter->setIdentityColumn('email')->setCredentialColumn('password');
                $authAdapter->setIdentity($data['email'])->setCredential(md5($data['password']));
                $result = $auth->authenticate($authAdapter);

                if ($result->isValid()) {

                    $user = $authAdapter->getResultRowObject('ID');
                    $userRowset = $userTable->find(intval($user->ID));
                    $userRow = $userRowset->current();  // will return null on error
                    //if ($authAdapter->getResultRowObject()->IsActive) {

                    if (is_null($userRow)) {
                        throw new Zend_Exception('unable to get user row from db using ID ' . intval($user->ID));
                    } else {    // save user
                        $auth->getStorage()
                                ->write($userRow);
                    }

                    //var_dump($authAdapter->getResultRowObject());exit;
                    $this->_redirect('user/index');
                    /* } else {
                      $storage = new Zend_Auth_Storage_Session();
                      $storage->clear();
                      $this->view->errorMsg = "Account not activated. please check your email to verify it.";
                      } */
                } else {
                    $this->view->errorMsg = "Invalid username or password";
                }
            }
        }
    }
    
    public function createAction(){
         if (!in_array($this->user->acl_role, array('dev', 'admin')))
            $this->redirect('/user/dashboard');
    
        $memberTable = new Application_Model_Member();
        $form = new Application_Form_Member();
        $jamaatModel = new Application_Model_Jamaat();
        
        $jamaats = $jamaatModel->fetchAll($where = 'is_active = 1 ');
        foreach ($jamaats as $jamaat) {
            $form->getElement('jamaat_id')
                    ->addMultiOptions(array($jamaat['ID'] => $jamaat['jamaat_name']));
        }
         
        $this->view->form = $form;
    
        if ($this->getRequest()->isPost()) {
            if ($this->view->form->isValid($_POST)) {
                // process data here
                $data = $form->getValues();
                $fname = $data['first_name'];
                $lname = $data['last_name'];
                $jamaatid = $data['jamaat_id'];
                $wheres = array('first_name' => $fname, 'last_name' => $lname, 'jamaat_id' => $jamaatid);
                $value = $memberTable->fetchRow($where = $wheres);
                if ($value) {
                    $this->view->errormessage = "Member Already  exist";
                    $this->view->form->populate($_POST);
                }else{
                    $memberTable->insert($data);
                    $this->_helper->flashMessenger->addMessage('Member successfully added');
                    $this->_redirect("/user/dashboard");
                }
                //vdump($data);exit;
                //$this->redirect('/receipt/submit');
                // vdump($surveyData);exit;
                } else {
                $this->view->errormessage = "errors on form, please check";
                $this->view->form->populate($_POST);
            }
        }
        
    }

}

