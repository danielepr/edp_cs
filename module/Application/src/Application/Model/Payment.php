namespace Application\Model;

 use Zend\InputFilter\InputFilter;
 use Zend\InputFilter\InputFilterAwareInterface;
 use Zend\InputFilter\InputFilterInterface;

 class Payment implements InputFilterAwareInterface
 {
     public $id;
     public $payer_firstname;
     public $payer_lastname;
     public $currency;
     public $amount;
     public $cc_number;
     public $cc_CVV;
     public $cc_expiration_month;
     public $cc_expiration_year;
     
     protected $inputFilter;

     public function exchangeArray($data)
     {
         $this->id     = (!empty($data['id'])) ? $data['id'] : null;
         $this->payer_firstname = (!empty($data['payer_firstname'])) ? $data['payer_firstname'] : null;
         $this->payer_lastname  = (!empty($data['payer_lastname'])) ? $data['payer_lastname'] : null;
         $this->currency  = (!empty($data['currency'])) ? $data['currency'] : null;
         $this->amount  = (!empty($data['amount'])) ? $data['amount'] : 0;
         $this->cc_number  = (!empty($data['cc_number'])) ? $data['cc_number'] : null;
         $this->cc_CVV  = (!empty($data['cc_CVV'])) ? $data['cc_CVV'] : null;
         $this->cc_expiration_month  = (!empty($data['cc_expiration_month'])) ? $data['cc_expiration_month'] : null;
         $this->cc_expiration_year  = (!empty($data['cc_expiration_year'])) ? $data['cc_expiration_year'] : null;
     }
     
     public function setInputFilter(InputFilterInterface $inputFilter)
     {
         throw new \Exception("Not used");
     }

     public function getInputFilter()
     {
         if (!$this->inputFilter) {
             $inputFilter = new InputFilter();

             $inputFilter->add(array(
                 'name'     => 'id',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'Int'),
                 ),
             ));

             $inputFilter->add(array(
                 'name'     => 'payer_firstname',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'StripTags'),
                     array('name' => 'StringTrim'),
                 ),
                 'validators' => array(
                     array(
                         'name'    => 'StringLength',
                         'options' => array(
                             'encoding' => 'UTF-8',
                             'min'      => 1,
                             'max'      => 100,
                         ),
                     ),
                 ),
             ));

             $inputFilter->add(array(
                 'name'     => 'payer_lastname',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'StripTags'),
                     array('name' => 'StringTrim'),
                 ),
                 'validators' => array(
                     array(
                         'name'    => 'StringLength',
                         'options' => array(
                             'encoding' => 'UTF-8',
                             'min'      => 1,
                             'max'      => 100,
                         ),
                     ),
                 ),
             ));
             
             $inputFilter->add(array(
                 'name'     => 'cc_number',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'StripTags'),
                     array('name' => 'StringTrim'),
                 ),
                 'validators' => array(
                     array(
                         'name'    => 'StringLength',
                         'options' => array(
                             'encoding' => 'UTF-8',
                             'min'      => 16,
                             'max'      => 16,
                         ),
                     ),
                 ),
             ));
             
             $inputFilter->add(array(
                 'name'     => 'cc_CVV',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'StripTags'),
                     array('name' => 'StringTrim'),
                 ),
                 'validators' => array(
                     array(
                         'name'    => 'StringLength',
                         'options' => array(
                             'encoding' => 'UTF-8',
                             'min'      => 3,
                             'max'      => 4,
                         ),
                     ),
                 ),
             ));           
             
              $inputFilter->add(array(
                 'name'     => 'cc_CVV',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'StripTags'),
                     array('name' => 'StringTrim'),
                 ),
                 'validators' => array(
                     array(
                         'name'    => 'StringLength',
                         'options' => array(
                             'encoding' => 'UTF-8',
                             'min'      => 3,
                             'max'      => 4,
                         ),
                     ),
                 ),
             ));                

             $this->inputFilter = $inputFilter;
         }

         return $this->inputFilter;
     }
     
     
 }