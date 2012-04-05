<?php

namespace Politix\PolitikportalBundle\Model;

use Doctrine\DBAL\Connection;


class SourceModel {
    
    private $conn;
    private $pagesize = 100;
    
    
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
    	
    	$totalpages = round($result['num'] / $this->pagesize);
    	    	
    	for ($i=1;$i <= $totalpages;$i++) {
    	
    		if (($i == 1) or (($i - $page > -5) and ($i - $page < 5)) or ($i == $totalpages)) {
    		
    			$current = FALSE;
    			$disabled = FALSE;
    			if ($page == $i) $current = TRUE;
    		
    			$pages[] = array('number' => $i, 'current' => $current, 'disabled' => $disabled);
    		
    		} else {
    		
    			if (($i - $page == -6) or ($i - $page == 6)) $pages[] = array('number' => '…', 'current' => FALSE, 'disabled' => TRUE);
    		
    		}
    		
    	}
    	
    	return $pages;
		    	
    }
    
    
    
    
}
