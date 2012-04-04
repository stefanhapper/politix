<?php

namespace Politix\PolitikportalBundle\Model;

// use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Doctrine\DBAL\Connection;


class SourceModel extends Connection{
    
    
    public function getSources($start = 0, $max = 10) {
    
    	$sql = "SELECT * FROM sources LIMIT $start,$max";
    	
		return $this->conn->query($sql);
		    	
    }
    
    
    
    
}
