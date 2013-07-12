<?php

class Application_Model_Feedback extends Zend_Db_Table_Abstract
{
protected $_name = "answer";
public function getCountries(){
            
header('Content-Type: text/html; charset=utf-8'); 
require_once 'Zend/Locale.php'; 
$locale = new Zend_Locale('en_US'); 
$countries = ($locale->getTranslationList('Territory', 'en', 2)); 
asort($countries, SORT_LOCALE_STRING); 

return $countries;

    
}
public function getAnswers($answer){
    
       
}


}

