<?php

namespace Politix\PolitikportalBundle\Model;

// use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class SourceModel {

	private $conn = NULL;
	
    
    function __construct(&$controllerObject) {
    
    	$this->conn = $controllerObject->container->get('database_connection');        	
    
    }
    
    
    public function getSources($start = 0, $max = 10) {
    
    	$sql = "SELECT * FROM sources LIMIT $start,$max";
    	
		return $this->conn->query($sql);
		    	
    }
    
    
    
    
}
