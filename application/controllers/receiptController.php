<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php

class ReceiptController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
        $this->user = '';
        $this->userdata = '';
        $auth = Zend_Auth::getInstance();

        if ($auth->hasIdentity()) {
            $this->user = $auth->getIdentity();
            //new dBug($this->user);
            //exit;
        }
    }

    public function indexAction() {
        $user = new Application_Model_Member;
        if ($this->getRequest()->getParam('user_id', false)) {
            $this->createAction();
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

    private function createAction() {
        if (!in_array($this->user->acl_role, array('dev', 'admin', 'manager')))
            throw new Zend_Exception('Invalid ACL role', 403);

        $user_id = @intval($this->getRequest()->getParam('user_id', 0));
        $this->redirect('receipt/form/user_id/' . $user_id);
        exit();
    }

    public function formAction() {

        $db = Zend_Db_Table::getDefaultAdapter();
        $user_id = @intval($this->getRequest()->getParam('user_id', 0));

        if (!$user_id) {
            $this->_helper->FlashMessenger(array('Please select a user first', 'error'));
            $this->_redirect('/receipt/index');
            exit();
        }

        $userTable = new Application_Model_Member();
        $receipt = new Application_Model_Receipt();
        $receipt_type = new Application_Model_ReceiptType();
        $year = new Application_Model_Year();
        $userRowset = $userTable->find($user_id);
        $userRow = $userRowset->current();  // will return null on error
        if (is_null($userRow))
            throw new Zend_Exception('unable to get user row from db', 500);

        $_POST['userrow'] = $userRow;
        $this->view->user = $userRow;
        $sql1 = "select jamaat_name from jamaat WHERE ID =" . $userRow['jamaat_id'];
        $this->view->jamaat = $db->fetchOne($sql1);

        $sql = "SELECT * from receipt_type WHERE
                is_active = 1";
        $this->view->receipt_type = $db->fetchAll($sql);



        $form = new Application_Form_Receipt();

        $this->view->form = $form;

        $all_year = $year->fetchAll($where = 'is_active = 1 ', $order = 'year DESC');
        foreach ($all_year as $year) {
            $form->getElement('year')
                    ->addMultiOptions(array($year['year'] => $year['year']));
        }

        if ($this->getRequest()->isPost()) {
            if ($this->view->form->isValid($_POST)) {
                // process data here
                $data = $form->getValues();
                $rcpt = $data['receiptno'];
                $value = $receipt->select($where = "receipt_no =" . $rcpt);
                if ($value) {
                    $this->view->errormessage = "Receipt no already exist";
                    $this->view->form->populate($_POST);
                }else{
                foreach ($data as $key => $item) {
                    if ($key == 'receiptno') {

                        $receiptno = $item;
                        continue;
                    }
                    if ($key == 'year') {
                        $year = $item;
                        continue;
                    }

                    if ($item) {
                        $value = $receipt_type->fetchRow($where = "ID =" . $key);
                        $rtype = $value['receipt_name'];

                        $this->userdata[$key]['receipt_no'] = $receiptno;
                        $this->userdata[$key]['receipt_type'] = $rtype;
                        $this->userdata[$key]['value'] = number_format($item, 2);
                        $this->userdata[$key]['year'] = $year;
                        $this->userdata[$key]['user_id'] = $userRow['ID'];
                    }
                }

                if ($this->userdata) {
                    foreach ($this->userdata as $value) {
                        $receipt->insert($value);
                    }
                    $this->_helper->flashMessenger->addMessage('thank you for your feedback.');
                    $_POST['userdata'] = $this->userdata;

                    $this->redirect('/receipt/submit/user_id/' . $userRow['ID'] . '/receipt_no/' . $receiptno);
                } else {
                    $this->view->errormessage = "No data";
                    $this->view->form->populate($_POST);
                }


                //$this->redirect('/receipt/submit');
                // vdump($surveyData);exit;
                }} else {
                $this->view->errormessage = "errors on form, please check";
                $this->view->form->populate($_POST);
            }
        }
    }

    public function submitAction() {
        $user_id = @intval($this->getRequest()->getParam('user_id'));
        $receipt_no = $this->getRequest()->getParam('receipt_no');

        $userTable = new Application_Model_Member();
        $receipt = new Application_Model_Receipt();
        $db = Zend_Db_Table::getDefaultAdapter();

        if (!$user_id) {
            $this->_helper->FlashMessenger(array('Please select a user first', 'error'));
            $this->_redirect('/receipt/index');
            exit();
        }

        $userRowset = $userTable->find($user_id);
        $userRow = $userRowset->current();  // will return null on error
        if (is_null($userRow))
            throw new Zend_Exception('unable to get user row from db', 500);

        $this->view->user = $userRow;
        $sql1 = "select jamaat_name from jamaat WHERE ID =" . $userRow['jamaat_id'];
        $this->view->jamaat = $db->fetchOne($sql1);

        $data = $receipt->fetchAll($where = "receipt_no = " . $receipt_no);
        foreach ($data as $item) {
            $total += $item['value'];
        }
        $this->view->total = $total;
        $this->view->receiptno = $receipt_no;
        $this->view->data = $data;
    }

}