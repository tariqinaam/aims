<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php

class Application_Form_Receipt extends Zend_Form {

    public function init() {

        $receiptTypeModel = new Application_Model_ReceiptType();
        /* Form Elements & Other Definitions Here ... */


        $notEmpty = new Zend_Validate_NotEmpty();
        $notEmpty->setMessage('Field can not be empty');

        $receipt_type = $receiptTypeModel->fetchAll($where = 'is_active=1');
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

        //receiptno    
        $options['description'] = FALSE;
        $options['label'] = 'Receipt No';
        $options['id'] = "receiptno";
        $options['required'] = TRUE;
        $this->addElement('text', 'receiptno', $options);
        $this->getElement('receiptno')->addValidator($notEmpty)
                                        ->addValidator('int', true);

        $selectbox['label'] = 'Year';
        $selectbox['id'] = 'year';
        $selectbox['description'] = FALSE;
        $this->addElement('select', $selectbox['id'], $selectbox);

        foreach ($receipt_type as $key) {
            $receiptid = $key['ID'];

            //address 1
            $options['label'] = $key['receipt_name'];
            $options['id'] = $receiptid;
            $options['required'] = FALSE;
            $options['description'] = FALSE;

            $this->addElement('text', $receiptid, $options);
            $this->getElement($receiptid)->addValidator('float')
                    ->addErrorMessage('please enter valid value');
        }


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