<?php 
abstract class Custom_Controller_Action_Abstract extends Zend_Controller_Action 
{
	/**
	 * Helper method to redirect to a specific action or controller
	 *
	 * @param string $controller / $url which contains http in its composition
	 * @param string $action
	 * @param array  $params
	 */
	public function redirect($controller = 'index', $action = 'index', $module = 'frontoffice', $params = array(), $route = null, $reset = true )
    {
    	$this->_redirect = $this->_helper->getHelper('Redirector');
    	
    	$current_controller = $this->_getParam('controller');
    	$current_action     = $this->_getParam('action');
    	$current_module     = $this->_getParam('module');

    	if (strstr($controller, 'http'))
    	{
    		if (DEBUG && (!$this->_request->isXmlHttpRequest() && !isset($_GET['ajax'])))
    		{
				debug_redirect($controller);
    		}
    		else
    		{
	    		return $this->_redirect($controller, array('code' => 301));
    		}
    	}
    	
    	if (DEBUG && (!$this->_request->isXmlHttpRequest() && !isset($_GET['ajax'])))
    	{
    		$url = 'http://' . $_SERVER['HTTP_HOST']
    			   . $this->view->url(array_merge(array('controller' => $controller, 'action' => $action, 'module' => $module), $params), $route, $reset);
    		debug_redirect($url);
    	}
    	else
    	{
    		if ($route !== null)
    		{
    			$params = array_merge(array('action'     => $action,
								    	    'controller' => $controller,
                                   			'module'     => null), $params);
    			
    			return $this->_redirect->setCode(301)
    			                       ->gotoRoute($params, $route, $reset);
    		}
    		
	    	return $this->_redirect->setCode(301)
	                      		   ->gotoSimple($action,
                                                $controller,
                                                $module,
                                                $params);
    	}
    }
}