<?php

/**
 * @author matthias.kerstner <matthias@kerstner.at> 
 */
class Register_Form_StepOne extends Zend_Form_SubForm {

    public function init() {
        parent::init();

       
     
    
         
         
         $options = array(
            'disableLoadDefaultDecorators' => true,
            'decorators' => array(array('ViewScript', array(
                'viewScript' => '_form/element/textbox.phtml',
                'placement' => false
            ))),
            'description' => '',
            'required' => true,
            'label'      => 'Name',
            'id' => 'StepOne'
        );
     
        
  $this->addElement('text', 'name', $options);
//name    
       // $options['description'] = "Type your first name here.";
       /*
        $this->addElement('text', 'name', $options);
        //$this->getElement('name')->setAttrib('id', 'name');
        
         //lname    
        $options['description'] = "Type your last name here.";
        $options['id'] = "lname";
        $this->addElement('text', 'lname', $options);
        
        //Email
        $options['label'] = 'Email';
        $options['id'] = 'email';
        $options['description'] = "Your email address.";
        $this->addElement('text', 'email', $options);
        //$this->getElement('email')->addValidator($emailValidate);
        
        //address
        $options['label'] = 'Address';
        $options['id'] = 'address';
        $options['description'] = "Your first line of address.";
        $this->addElement('text', 'address', $options);
        
        //address 1
        $options['label'] = 'Address 1';
        $options['id'] = 'address1';
        $options['description'] = "Your second line of address.";
        $options['required'] = FALSE;
        $this->addElement('text', 'address1', $options);
       // $this->getElement('address1')->addValidator($notEmpty);
     */    
    }

}

?>