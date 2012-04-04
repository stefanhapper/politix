<?php

namespace Politix\PolitikportalBundle\Model;

// use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Doctrine\DBAL\Connection;


class SourceModel extends Connection {
    
    
    public function getSources($start = 0, $max = 10) {
    
        //$conn = $this->get('database_connection');

    	$sql = "SELECT * FROM sources LIMIT $start,$max";
    	
		return $this->query($sql);
		    	
    }
    
    
    
    
}
