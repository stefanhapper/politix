<?php

namespace Politix\PolitikportalBundle\Model;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class SourceModel extends Controller {
    
    public function getSources($start = 0, $max = 10) {
    
        $conn = $this->container->get('database_connection');
        
    	$sql = "SELECT * FROM sources LIMIT $start,$max";
    	
		return $conn->query($sql);
		    	
    }
    
    
    
    
}
