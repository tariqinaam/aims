<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Application_Model_UserAnswer extends Zend_Db_Table_Abstract{
    
    protected $_name = "user-answer";
    
    public function insertdata($x)
    {
        $result = $this->_db->insert('user-answer', $x);
        
        if($result){
            return TRUE;
        }
        else{
            return FALSE;
        }
        
    }
    
}
