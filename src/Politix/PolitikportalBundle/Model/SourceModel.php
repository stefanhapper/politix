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
    
    
    public function getSource($id) {
    
    	$sql = "SELECT * FROM rss_items WHERE source LIKE '" . $id . "' ORDER BY pubDate DESC LIMIT 0,10";
    	
		return $this->conn->query($sql);
    
    }
    
    public function addSid() {
    
    	$sql = "SELECT id,sid FROM rss_sources";
    	
    	$result = $this->conn->fetchAll($sql);
    	
    	$sources = array();
    	
    	foreach ($result as $source) {
    		$sources[$source['id']]['sid'] = $source['sid'];
    		$sources[$source['id']]['source'] = $source['id'];
    		$sources[$source['id']]['count'] = 0;
    	}
    	
    	
    	$sql = "SELECT id,source FROM rss_items WHERE id > 170000";
    
    	$items = $this->conn->fetchAll($sql);
  
  		foreach ($items as $item) {
  		
  			$sql = "UPDATE rss_items SET sid = " . $sources[$item['source']]['sid'] . " WHERE id = " . $item['id'];
  			
  			$sources[$item['source']]['count'] += 1;
  			
  		}
  		
  		return $sources;
    	
    }


    public function getPages($page = 1) {
                
    	$sql = "SELECT COUNT(id) AS num FROM rss_sources";
    	
    	$result = $this->conn->fetchAssoc($sql);
    	
    	$totalpages = round($result['num'] / $this->pagesize);
    	    	
    	for ($i=1;$i <= $totalpages;$i++) {
    	
    		if (($i == 1) or (($i - $page > -5) and ($i - $page < 5)) or ($i == $totalpages)) {
    		
    			$current = FALSE;
    			$disabled = FALSE;
    			if ($page == $i) {
    				$current = TRUE;
    				$disabled = TRUE;
    			}
    			
    			$pages[] = array('number' => $i, 'current' => $current, 'disabled' => $disabled);
    		
    		} else {
    		
    			if (($i - $page == -6) or ($i - $page == 6)) $pages[] = array('number' => '…', 'current' => FALSE, 'disabled' => TRUE);
    		
    		}
    		
    	}
    	
    	return $pages;
		    	
    }
    
    
    
    
}
