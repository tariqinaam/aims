<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php

class Application_Form_Year extends Zend_Form {

    public function init() {

        
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

        
        //Jamaat
        $selectbox['label'] = 'Year';
        $selectbox['id'] = 'year';
        $selectbox['description'] = FALSE;
        $this->addElement('select', $selectbox['id'], $selectbox);

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