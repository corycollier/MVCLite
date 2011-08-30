<?php
/**
 * Base Dispatcher
 * 
 * @category    MVCLite
 * @package     Lib
 * @subpackage  Dispatcher
 * @since       File available since release 1.0.1
 * @author      Cory Collier <corycollier@corycollier.com>
 */
/**
 * Base Dispatcher
 * 
 * @category    MVCLite
 * @package     Lib
 * @subpackage  Dispatcher
 * @since       Class available since release 1.0.1
 * @author      Cory Collier <corycollier@corycollier.com>
 */

class Lib_Dispatcher
extends Lib_Object_Singleton
{
    public function init ( )
    {
        throw new Lib_Exception('This method must be implemented in the app');
    }

    /**
     * dispatch
     * 
     * This is the main entry point for dispatching a request
     */
    public function dispatch ( )
    {
        // this method MUST be implemented in the app_dispatcher, or else this will fail!
        $this->init();

        $response = Lib_Response::getInstance();
        $request = Lib_Request::getInstance();
        $controller = $this->_translateControllerName(
            $request->getParam('controller')
        );
        
        $action = $this->_translateActionName($request->getParam('action'));
        
        // If the controller doesn't exist, or the action isn't callable, 
        // use the error controller
        try {
            $controller = new $controller;
            if (! method_exists($controller, $action)) {
                throw new Lib_Exception(
                    'Action not available'
                );
            }
        }
        catch (Exception $exception) {
            $request->setParam('controller', 'error');
            $request->setParam('action', 'error');
            $controller = new App_Controller_Error;
            $action = 'errorAction';
        }
        
        // run the init hook
        $controller->init();
        
        // run the preDispatch hook
        $controller->preDispatch();
        
        // run the requested action on the requested controller
        call_user_func(array($controller, $action));
        
        // run the postDispatch hook
        $controller->postDispatch();
        
        // send the response
        $response->setBody($controller->getView()->render());
        
        // if this is an actual request, not a unit test, send headers
        if ( PHP_SAPI != 'cli' ) $response->sendHeaders();
        
        // echo the body
        echo $response->getBody();
        
    } // END function dispatch
    
    /**
     * Translates a raw request param for a controller into a class name
     * 
     * @param string $controller
     * @return string
     */
    private function _translateControllerName ($controller = '')
    {
        // create a string of upper cased words by replacing hyphens
        $controller = ucwords(strtr($controller, array(
            '-' => ' ',
        )));
        
        // remove the spaces, creating a camelcased word
        $controller = strtr($controller, array(
            ' ' => '',
        ));
        
        // return the controller name, prefixed with App_Controller_
        return "App_Controller_{$controller}";
        
    } // END function _translateControllerName
    
    /**
     * 
     * Translates a raw request param for an action into an action name
     * 
     * @param string $action
     * @return string
     */
    private function _translateActionName ($action = '')
    {
        $words = explode('-', $action);
        foreach ($words as $i => $word) {
            if (! $i) {
                $words[$i] = strtolower($word);
                continue;
            }
            $words[$i] = ucwords($word);
        }
        
        $action = implode('', $words);
        
        return "{$action}Action";
        
    } // END function _translateActionName
    
} // END function dispatcher
