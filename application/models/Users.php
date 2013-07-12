<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Application_Model_Users extends Zend_Db_Table_Abstract{
    
    protected $_name = "user";
    protected $_question = "question";
    protected $_answer = "answer";
    protected $_useranswer = "user-answer";
            
function checkUnique($username)
    {
        $select = $this->_db->select()
                            ->from($this->_name,array('email'))
                            ->where('email=?',$username);
        $result = $this->getAdapter()->fetchOne($select);
        if($result){
            return true;
        }
        return false;
    }
    
    function getId($email){
        
        $select = $this->_db->select()
                            ->from($this->_name,array('Id'))
                            ->where('email=?',$email);
        $result = $this->getAdapter()->fetchOne($select);
    return $result;
        
    }
    function getAnswers($questionId)
    {
        $uanswer = $this->_useranswer;
        $answer = $this->_answer;
        
        $select = $this->_db->select()
                        ->from($this->_useranswer, 
                                array('total_answer' => 'count(*)', 'answerId'))
                                
                        ->group('answerId')
                        ->where('questionId=?', $questionId)
                ;
             
        $result = $this->getAdapter()->fetchAll($select);
        //$sql = "select $uanswer.answerId, $answer.answer count(*) as totalanswer from $uanswer, $answer where $uanswer.questionId = $questionId and $uanswer.answerId=$answer.Id";
        //$x = $this->getAdapter()->fetchAll($sql);
        return $result;
        
        
        
    }
    function getAnswerText($answerId){
        
         $select = $this->_db->select()
                            ->from($this->_answer, array('answer'))
                            ->where('Id=?',$answerId);
        $result = $this->getAdapter()->fetchOne($select);
        return $result;
    }
    
  function getQuestion($questionId){
       $select = $this->_db->select()
                            ->from($this->_question, array('question'))
                            ->where('Id=?',$questionId);
        $result = $this->getAdapter()->fetchOne($select);
        return $result;
      
  }
}