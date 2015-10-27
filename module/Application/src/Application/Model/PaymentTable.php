 namespace Application\Model;

 use Zend\Db\TableGateway\TableGateway;

 class PaymentTable
 {
     protected $tableGateway;

     public function __construct(TableGateway $tableGateway)
     {
         $this->tableGateway = $tableGateway;
     }

     public function fetchAll()
     {
         $resultSet = $this->tableGateway->select();
         return $resultSet;
     }

     public function getPayment($id)
     {
         $id  = (int) $id;
         $rowset = $this->tableGateway->select(array('id' => $id));
         $row = $rowset->current();
         if (!$row) {
             throw new \Exception("Could not find row $id");
         }
         return $row;
     }

     public function savePayment(Payment $payment)
     {
         $data = array(
             'payer_firstname' => $payment->payer_firstname,
             'payer_lastname'  => $payment->payer_lastname,
		     'currency'  => $payment->currency,
		     'amount'  => $payment->amount,
		     'cc_number'  => $payment->cc_number,
		     'cc_CVV'  => $payment->cc_CVV,
		     'cc_expiration_month'  => $payment->cc_expiration_month,
		     'cc_expiration_year'  => $payment->cc_expiration_year,		                  
         );

         $id = (int) $payment->id;
         if ($id == 0) {
             $this->tableGateway->insert($data);
         } else {
             if ($this->getPayment($id)) {
                 $this->tableGateway->update($data, array('id' => $id));
             } else {
                 throw new \Exception('Payment id does not exist');
             }
         }
     }

     public function deletePayment($id)
     {
         $this->tableGateway->delete(array('id' => (int) $id));
     }
 }