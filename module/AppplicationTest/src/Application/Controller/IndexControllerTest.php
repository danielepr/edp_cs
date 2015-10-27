<?php

namespace ApplicationTest\Controller;

use ApplicationTest\Bootstrap;
use Zend\Mvc\Router\Http\TreeRouteStack as HttpRouter;
use Application\Controller\IndexController;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use PHPUnit_Framework_TestCase;

use Application\Model\Payment;   
use Application\Model\PaymentTable;
use Application\Model\Logging;
use Application\Model\LoggingTable; 


class IndexControllerTest extends \PHPUnit_Framework_TestCase
{
    protected $controller;
    protected $request;
    protected $response;
    protected $routeMatch;
    protected $event;

    protected function setUp()
    {
        $serviceManager = Bootstrap::getServiceManager();
        $this->controller = new IndexController();
        $this->request    = new Request();
        $this->routeMatch = new RouteMatch(array('controller' => 'index'));
        $this->event      = new MvcEvent();
        $config = $serviceManager->get('Config');
        $routerConfig = isset($config['router']) ? $config['router'] : array();
        $router = HttpRouter::factory($routerConfig);

        $this->event->setRouter($router);
        $this->event->setRouteMatch($this->routeMatch);
        $this->controller->setEvent($this->event);
        $this->controller->setServiceLocator($serviceManager);
    }
    
	public function testIndexActionCanBeAccessed()
	{
	    $this->routeMatch->setParam('action', 'index');
	
	    $result   = $this->controller->dispatch($this->request);
	    $response = $this->controller->getResponse();
	
	    $this->assertEquals(200, $response->getStatusCode());
	}    
	
	public function testResponseActionCanBeAccessed()
	{
	    $this->routeMatch->setParam('action', 'response');
	
	    $result   = $this->controller->dispatch($this->request);
	    $response = $this->controller->getResponse();
	
	    $this->assertEquals(200, $response->getStatusCode());
	}    
	
	public function testPostForm()
	{
	   
    	$this->request->setMethod('POST')
         ->setPost(array(
             'payer_firstname'         => 'John',
             'payer_lastname'         => 'Smith',
             'currency'            => 'EUR',
             'amount'         => '150.00',
             'cc_number'     => 'XXXYYYYXXXXYYYY',
             'cc_CVV'     => 'XXX',
             'cc_expiration_month'     => '10',
             'cc_expiration_year'     => '2016',
           ));
	    
	    $this->dispatch('/index');				
	}
    
}