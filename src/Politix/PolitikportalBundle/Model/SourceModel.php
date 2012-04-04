<?php

namespace Politix\PolitikportalBundle\Model;

use Doctrine\DBAL\Connection;


class SourceModel {
    
    private $conn;
    
    
    function __construct(Connection $conn) {
    	
    	$this->conn = $conn;
    	
    }

    
    public function getSources($start = 0, $max = 10) {
            
    	$sql = "SELECT * FROM rss_sources LIMIT $start,$max";
    	
		return $this->conn->query($sql);
		    	
    }
    
    
    
    
}
