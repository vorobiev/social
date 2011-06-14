<?php
 
	class WebUser extends CWebUser {
	    private $_model = null;
	 
	    public function getRole() {
	        if($user = $this->getModel())
	        {
	        	if ( $user -> role == 100 )
	        		return 'administrator';
	        		
	        	if ( $user -> role == 10 )
	        		return 'accountant' ;
	        		
	        	if ( $user -> role == 1 )
	        		return 'manager' ;
	        		
	           return 'guest';
	        }
	        else
	        {
	        	return 'guest';
	        }
	    }
	 
	    public function getModel(){
	        if (!$this->isGuest && $this->_model === null)
	        {
	            $this->_model = User::model()->findByPk($this->id, array('select' => 'role'));
	        }
	        return $this->_model;
	    }
	}