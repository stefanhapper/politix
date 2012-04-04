<?php

namespace Politix\PolitikportalBundle\Model;

// use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class SourceModel {
    
    private $conn;
    
    
    function __construct($conn) {
    	
    	$this->conn = $conn;
    	
    }
    
    
    public function getSources($start = 0, $max = 10) {
    
        // $conn = $this->container->get('database_connection');
        
    	$sql = "SELECT * FROM rss_sources LIMIT $start,$max";
    	
		return $this->conn->query($sql);
		    	
    }
    
    
    
    
}
