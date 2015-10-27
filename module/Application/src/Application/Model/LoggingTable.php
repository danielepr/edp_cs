 namespace Application\Model;

 use Zend\Db\TableGateway\TableGateway;

 class LoggingTable
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

     public function getLogging($id)
     {
         $id  = (int) $id;
         $rowset = $this->tableGateway->select(array('id' => $id));
         $row = $rowset->current();
         if (!$row) {
             throw new \Exception("Could not find row $id");
         }
         return $row;
     }

     public function saveLogging(Logging $logging)
     {
         $data = array(
             'date' => $logging->date,
             'result_code'  => $logging->result_code,
		     'result_message'  => $logging->result_message,
		     'payment_id'  => $logging->payment_id,	                  
         );

         $id = (int) $logging->id;
         if ($id == 0) {
             $this->tableGateway->insert($logging);
         } else {
             if ($this->getLogging($logging)) {
                 $this->tableGateway->update($data, array('id' => $id));
             } else {
                 throw new \Exception('Logging id does not exist');
             }
         }
     }

     public function deleteLogging($id)
     {
         $this->tableGateway->delete(array('id' => (int) $id));
     }
 }