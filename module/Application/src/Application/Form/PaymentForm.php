namespace Application\Form;

 use Zend\Form\Form;

 class PaymentForm extends Form
 {
     public function __construct($name = null)
     {
         // we want to ignore the name passed
         parent::__construct('payment');

         $this->add(array(
             'name' => 'id',
             'type' => 'Hidden',
         ));
         $this->add(array(
             'name' => 'payer_firstname',
             'type' => 'Text',
             'options' => array(
                 'label' => 'First name',
             ),
         ));
         $this->add(array(
             'name' => 'payer_lastname',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Last name',
             ),
         ));
         
		 $this->add(array(     
		    'type' => 'Zend\Form\Element\Select',       
		    'name' => 'currency',
		    'attributes' =>  array(
		        'id' => 'currency',                
		        'options' => array(
		            'eur' => 'EUR',
		            'usd' => 'USD',
		        ),
		    ),
		    'options' => array(
		        'label' => 'Currency',
		    ),
		));  
        
         $this->add(array(
             'name' => 'amount',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Amount',
             ),
         ));         
         
         $this->add(array(
             'name' => 'cc_number',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Credit Card Number',
             ),
         ));         
                  
         $this->add(array(
             'name' => 'cc_CVV',
             'type' => 'Text',
             'options' => array(
                 'label' => 'CVV',
             ),
         )); 
         
		 $this->add(array(     
		    'type' => 'Zend\Form\Element\Select',       
		    'name' => 'cc_expiration_month',
		    'attributes' =>  array(
		        'id' => 'currency',                
		        'options' => array(
		            '1' => '1',
		            '2' => '2',
		            '3' => '3',
		            '4' => '4',	
		            '5' => '5',
		            '6' => '6',
		            '7' => '7',
		            '8' => '8',				            
		            '9' => '9',
		            '10' => '10',
		            '11' => '11',
		            '12' => '12',				            	           
		        ),
		    ),
		    'options' => array(
		        'label' => 'Validity: Month',
		    ),
		));           

		 $this->add(array(     
		    'type' => 'Zend\Form\Element\Select',       
		    'name' => 'cc_expiration_year',
		    'attributes' =>  array(
		        'id' => 'currency',                
		        'options' => array(
		            '2015' => '2015',
		            '2016' => '2016',
		            '2017' => '2017',
		            '2018' => '2018',	
		            '2019' => '2019',
		            '2020' => '2020',			            	           
		        ),
		    ),
		    'options' => array(
		        'label' => 'Year',
		    ),
		));  
       
         
         $this->add(array(
             'name' => 'submit',
             'type' => 'Submit',
             'attributes' => array(
                 'value' => 'Proceed to checkout',
                 'id' => 'submitbutton',
             ),
         ));
     }
 }