<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php

class Application_Form_Member extends Zend_Form {

    public function init() {

        $notEmpty = new Zend_Validate_NotEmpty();
        $notEmpty->setMessage('Field can not be empty');

        $options = array(
            'disableLoadDefaultDecorators' => true,
            'decorators' => array(array('ViewScript', array(
                        'viewScript' => '_form/element/textbox.phtml',
                        'placement' => false
                ))),
            'description' => '',
            'required' => false,
        );
        $selectbox = array(
            'disableLoadDefaultDecorators' => true,
            'decorators' => array(array('ViewScript', array(
                        'viewScript' => '_form/element/selectbox.phtml',
                        'placement' => false
                ))),
            'description' => '',
            'required' => true,
            'label' => 'Last Name',
            'id' => 'default'
        );

        //first name
        $options['description'] = FALSE;
        $options['label'] = 'First Name';
        $options['id'] = "first_name";
        $options['required'] = TRUE;
        $this->addElement('text', 'first_name', $options);
        $this->getElement('first_name')->addValidator($notEmpty);        
        
        //last name  
        $options['description'] = FALSE;
        $options['label'] = 'Last Name';
        $options['id'] = "last_name";
        $options['required'] = TRUE;
        $this->addElement('text', 'last_name', $options);
        $this->getElement('last_name')->addValidator($notEmpty);
        
        //age
        $options['description'] = FALSE;
        $options['label'] = 'Age';
        $options['id'] = "age";
        $options['required'] = TRUE;
        $this->addElement('text', 'age', $options);
        $this->getElement('age')->addValidator($notEmpty)
                                        ->addValidator('int', true);
        
        //Jamaat
        $selectbox['label'] = 'Jamaat';
        $selectbox['id'] = 'jamaat_id';
        $selectbox['description'] = FALSE;
        $this->addElement('select', $selectbox['id'], $selectbox);

        //Tajneed
        $selectbox['label'] = 'Tajneed';
        $selectbox['id'] = 'tajneed';
        $selectbox['description'] = FALSE;
        $this->addElement('select', $selectbox['id'], $selectbox);
        $this->getElement('tajneed')
                    ->addMultiOptions(array(
                        'ansar' => 'ansar',
                        'khuddam' => 'Khuddam',
                        'atfal' => 'Atfal',
                        'lajna' => 'Lajna',
                        'nasrat' => 'Nasrat'
                        ));

        /*
          $selectbox['label'] = 'How much have your skills improved because of the training at the Forum?';
          $selectbox['id'] = 'skills';
          $selectbox['description'] = FALSE;
          $this->addElement('select', 'skills', $selectbox);

          $selectbox['label'] = 'Overall, were you satisfied with the Forum, neither satisfied nor dissatisfied with it, or dissatisfied with it?';
          $selectbox['id'] = 'satisfaction';
          $selectbox['description'] = FALSE;
          $this->addElement('select', 'satisfaction', $selectbox);

          $selectbox['label'] = 'Was the Forum better than what you expected, worse than what you expected, or about what you expected?';
          $selectbox['id'] = 'expectation';
          $selectbox['description'] = FALSE;
          $this->addElement('select', 'expectation', $selectbox);

          $selectbox['label'] = 'How useful was the information presented at the Forum?';
          $selectbox['id'] = 'presentation';
          $selectbox['description'] = FALSE;
          $this->addElement('select', 'presentation', $selectbox);

         * */
    }

}