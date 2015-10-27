<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Model\Payment;   
use Application\Model\PaymentTable;
use Application\Model\Logging;
use Application\Model\LoggingTable;      
use Application\Form\PaymentForm;       


class IndexController extends AbstractActionController
{
	
	protected $paymentTable;
	protected $loggingTable;
	
    public function indexAction()
    {
        return new ViewModel();
    }
    
    public function responseAction(){


        $form = new PaymentForm();
        $form->get('submit')->setValue('submit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $payment = new Payment();
            $logging = new Logging();
            $form->setInputFilter($payment->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
            	$config = $this->getServiceLocator()->get('Config');
            	$token=$config['token']; 
                $payment->exchangeArray($form->getData());
                
      
                //If the API does not do CC validation....this may be done here...
				$valid = new Zend\Validator\CreditCard();
				$valid->setType(array(
				    Zend\Validator\CreditCard::AMERICAN_EXPRESS,
				    Zend\Validator\CreditCard::VISA
				));   
				if ($valid->isValid($payment->cc_number)) {
				    // input appears to be valid
				} else {
				    // input is invalid
				}	
				
				//If the API does not do Amount validation....this may be done here...
				$valid = new Zend\I18n\Validator\IsInt(array('locale' => 'de'));
				if ($valid->isValid($payment->amount)) {
				    // input appears to be valid
				} else {
				    // input is invalid
				}	
				$valid = new Zend\I18n\Validator\IsFloat(array('locale' => 'de'));			
				if ($valid->isValid($payment->amount)) {
				    // input appears to be valid
				} else {
				    // input is invalid
				}
				
 				$new_cc_number = $this->encriptPassword(
						$this->getStaticSalt(),
						$payment['cc_number'],
						$this->generateDynamicSalt()
				);      
				//encrypt CC number
				$payment['cc_number'] = $new_cc_number;
												             
				$client = new \Zend\Http\Client();
				$client->setAdapter(new \Zend\Http\Client\Adapter\Curl());	
				$client->setUri('http://api.europaymentgroup.test.com/api/token=$token');
				$client->setMethod('POST');
				$adapter->setCurlOption(CURLOPT_POST, 1);
				$adapter->setCurlOption(CURLOPT_POSTFIELDS, $payment);
				$adapter->setCurlOption(CURLOPT_SSL_VERIFYPEER, 0);
				$adapter->setCurlOption(CURLOPT_HTTPHEADER, array(
				    'Content-type: application/json',
				    'Authorization: Bearer $token'
				));

				$response  = $client->send();
				$viewModel = new ViewModel();
				if($response->getStatusCode() === 200) {
				    $obj = json_decode($response->getBody(), true);
					$result="";
				    if($obj === null) {
				     $result="<span style='color:red;font-size:16px;font-weight:800'>ERROR: Not a valid response</span>";
				    }else{
				    	$status=$obj['result'];
				    	$logging->date = time();
				    	if ($status=="OK"){
				    		$result="<span style='color:green;font-size:16px;font-weight:800'>";
				    		$result="Payment successful!";
				    		$result.="</span>";
				    		$this->getPaymentTable()->savePayment($payment);
				    		$logging->payment_id=$obj['id'];
				    		$logging->result_code="1";
				    		$logging->result_message="SUCCESS";	
				    	}else{
				    		$result="<span style='color:red;font-size:16px;font-weight:800'>";
				    		$result.="DECLINE<br>".$obj["resultCode"]."  - ".$obj["resultMessage"];
				    		$result.="</span>";
				    		$logging->payment_id=-1;
				    		$logging->result_code=$obj['resultCode'];
				    		$logging->result_message=$obj['resultMessage'];			    		
				    	}
				    	$this->getLoggingTable()->saveLogging($logging);
				    }
				    
				    $viewModel->setVariable('response', $result);
				
				} else {
				    $obj="<span style='color:red;font-size:16px;font-weight:800'>ERROR: Not a valid response</span>";
				    $viewModel->setVariable('response', $obj);
				}
				
				return $viewModel;
            }
         }
         return array('form' => $form);
    }
    
    public function getPaymentTable()
    {
        if (!$this->paymentTable) {
            $sm = $this->getServiceLocator();
            $this->paymentTable = $sm->get('Application\Model\PaymentTable');
        }
        return $this->paymentTable;
    }  
    
    public function getLoggingTable()
    {
        if (!$this->loggingTable) {
            $sm = $this->getServiceLocator();
            $this->loggingTable = $sm->get('Application\Model\LoggingTable');
        }
        return $this->loggingTable;
    }  
    
    	public function getStaticSalt()
	{
		$staticSalt = '';
		$config = $this->getServiceLocator()->get('Config');
		$staticSalt = $config['static_salt'];
		return $staticSalt;
	}

	public function encriptPassword($staticSalt, $password, $dynamicSalt)
	{
		return $password = md5($staticSalt . $password . $dynamicSalt);
	}
	
    public function generateDynamicSalt()
    {
		$dynamicSalt = '';
		for ($i = 0; $i < 50; $i++) {
			$dynamicSalt .= chr(rand(33, 126));
		}
        return $dynamicSalt;
    }	
    
}
