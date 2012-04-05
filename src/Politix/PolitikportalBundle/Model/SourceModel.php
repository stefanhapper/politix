<?php

namespace Politix\PolitikportalBundle\Model;

use Doctrine\DBAL\Connection;


class SourceModel {
    
    private $conn;
    private $pagesize = 10;
    
    
    function __construct(Connection $conn) {
    	
    	$this->conn = $conn;
    	
    }
    
    
    public function setPagesize($pagesize) {
    
    	$this->pagesize = $pagesize;
    	
    }

    
    public function getSources($page = 1) {
        
        $start = $this->pagesize * ($page - 1);
        
    	$sql = "SELECT * FROM rss_sources LIMIT $start,$this->pagesize";
    	
		return $this->conn->query($sql);
		    	
    }


    public function getPages($page = 1) {
                
    	$sql = "SELECT COUNT(id) AS num FROM rss_sources";
    	
    	$result = $this->conn->fetchAssoc($sql);
    	
    	$totalpages = round($result[0]['num'] / $this->pagesize);
    	    	
    	for ($i=1;$i <= $totalpages;$i++) {
    		
    		$current = FALSE;
    		if ($page == $i) $current = TRUE;
    		
    		$pages[] = array('number' => $i, 'current' => $current);
    	
    	}
    	
    	return $pages;
		    	
    }
    
    
    
    
}
