<?php

class Model_Acl extends Zend_Acl
{    
    private $_roles = array(
        'anonymous',    // not logged i
        'admin',        // YST site admin
        'dev',          // YST site developer (joericharles)
        'manager'          // SIRC external examinar
    );
        
    // this instance - this request
    public $role = null;
    
    public function __construct( Zend_Auth $auth ) 
    {
        
        $this->_loadRole( $auth ); // establish a role for this request
        $this->_loadResources(); // pull up a laim.ist of resources and actions and add them to the ACL
        $this->_loadPermissions(); // pull up our black/whitelist and do allow() and deny() operations
    }
    
    private function _loadRole( Zend_Auth $auth )
    {
        if (! $auth->hasIdentity() )
        {
            // not logged in
            $this->role = 'anonymous';
        }
        else
        {
            // logged in to yourschoolgames site
           $identity = $auth->getIdentity();
            if ( in_array( $identity->acl_role, $this->_roles ) )
            {
                $this->role = $identity->acl_role;
            }
            else
            {
                $this->role = 'anonymous';
            }
        }
        $this->addRole($this->role);
    }
    
    // this is used in the CMS for page access levels
    public function getRoleInt()
    {
        switch ($this->role)
        {
            case 'dev':
                $roleInt = 6;
                break;
            case 'admin':
                $roleInt = 5;
                break;
            case 'manager':
                $roleInt = 4;
                break;
            default:
                $roleInt = 0;
                break;
        }
        return $roleInt;
    }
    
    private function _loadResources()
    {
        $xml = simplexml_load_file( APPLICATION_PATH . '/configs/ACL_resources.xml' );
        foreach ( $xml->resources->children() as $x )
        {
            $resource = $x->getName();
            $this->addResource( $resource );
            foreach ($x as $y) 
            {
                $action = $y->getName();
                $this->addResource( $resource."_".$action, $resource );
            }
        }
    }
    
    private function _loadPermissions()
    {
      $xml = simplexml_load_file( APPLICATION_PATH . '/configs/ACL/' . $this->role . '.xml' );
    
        foreach ( $xml->children() as $x )
        {
            $resource = $x->getName();
            $this->_setPermission( $resource, $x );
            foreach ($x as $y)
            {
                $action = $resource."_".$y->getName();
                $this->_setPermission( $action, $y );
            }
        }
    }
    
    private function _setPermission( $resource, $xmlnode )
    {
        $attrs = $xmlnode->attributes();
        // pull the allow/deny from xml attribute (if it exists)
        $allow = null;
        if (isset($attrs['allow']))
            $allow = ( "true" == (string)$attrs['allow'] ? true : false );
        elseif (isset($attrs['deny']))
            $allow = ( "true" == (string)$attrs['deny'] ? false : true );
        // do the assertion (if it exists)
        if ( !is_null($allow) && true == $allow )
            $this->allow( $this->role, $resource );
        elseif ( !is_null($allow) && false == $allow )
            $this->deny( $this->role, $resource );
    
    }
}
