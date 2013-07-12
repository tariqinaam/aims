<?php

/**
 * This plugin maps the request to an ACL resource, checks the access role of the user,
 * and uses the ACL to see if the user is allowed to act on the resource.
 * @see preDispatch method
 * 

 */

class Plugin_AccessCheck extends Zend_Controller_Plugin_Abstract {
    
    private $_acl = null;
    private $_auth = null;
    private $_redirector = null;
    private $_reminderExpired = null;
    
    public function __construct( Zend_Acl $acl, Zend_Auth $auth )
    {
        $this->_acl = $acl;
        $this->_redirector = Zend_Controller_Action_HelperBroker::getStaticHelper( 'redirector' );
        $this->_auth = $auth;
        //uncomment the below to get the date expiry in effect
        //$this->_reminderExpired = date( 'Y-m-d H:i:s' ) > date('c', mktime(0, 0, 0, 4, 1, 2013)); // Later than 1st April 2013?
        $this->_reminderExpired = false;
        
    }
 
    public function preDispatch( Zend_Controller_Request_Abstract $request )
    {
        
                    
        // The rest of this method relates to the ACL implementation
        
         $resource = $request->getControllerName();
         $action = $request->getActionName();
         $x = $this->_acl->isAllowed( $this->_acl->role, $resource."_".$action);
         //var_dump($x);exit;
        
        if ( $this->_acl->isAllowed( $this->_acl->role, $resource."_".$action ) ) {
            // we have permission      
	    if( 'development' === APPLICATION_ENV ){
		
	    }
        }
        else {
	    // Check if they are logged in at all
	    if( 'anonymous' == $this->_acl->role ){
                $this->view->message = 'Anon user accessing protected resource, redirecting to login.';     
                    header( 'Location: /user/login' );
		die;
            }
	    
            // we dont have permission
	    if( 'development' === APPLICATION_ENV ){
		//Zend_Registry::get( 'logger' )->debug("access denied to " . $action . " on " . $resource);
	    }
            throw new Zend_Exception( '403 Forbidden - Insufficient Priviledges for' . $action . " on " . $resource, 403 );
        }
    }
    
}
