<?php

namespace Politix\PolitikportalBundle\Model;

use Doctrine\DBAL\Connection;


class TopicModel {
    
    private $conn;
    private $pagesize = 100;
    
    
    function __construct(Connection $conn) {
    	
    	$this->conn = $conn;
    	
    }
    
    
    
    public function getHomepage() {
        
    	$maxitems = 12;   // in topicsgorup (including first item)
	
		$start_ts = mktime (0,0,0,date("m"),date("d"),date("Y"));
		$end_ts = mktime (23,59,59,date("m"),date("d"),date("Y")) ;
	

		switch (date('w')) {

			case "6":
				// Saturday
				$days = 2;
				break;

			case "0":
				// Sunday
				$days = 2.5;
				break;
			
			case "1":
				// Monday
				$days = 3;
				break;
			
			default:
				// Tuesday - Friday
				$days = 1.5;
			
		}
	
		// august long archive
		// $days = 5;

		$start_ts = time() - ($days * 86400) + 20000;
	
		
		$catcrit = "rss_sources.category != 'nothing'";

		$sql = "SELECT	topics.url AS topicUrl,
						topics.id AS id,
						topics.parent_id,
						topics.title_at,
						topics.rank,
						topics.name,
						COUNT(rss_items.id) AS rssCount,
						MAX(rss_items.myDate) AS maxDate,
						MIN(rss_items.rank) AS maxRank
				
				FROM	topics
				
				INNER JOIN topic_links ON (topics.id = topic_links.fid_topics)
				INNER JOIN rss_items ON (topic_links.fid_rss_items = rss_items.id)
				INNER JOIN rss_sources ON (rss_sources.id = rss_items.source)
				
				WHERE	$catcrit AND
						rss_items.rank <> 2 AND
						rss_items.rank < 4 AND
						(UNIX_TIMESTAMP(rss_items.myDate) > (" . $start_ts . " -1)) AND
						UNIX_TIMESTAMP(rss_items.myDate) < " . $end_ts . "
						
				GROUP BY topics.id
				
				ORDER by topics.rank DESC,maxRank ASC,maxDate DESC
				
				LIMIT 0,20";
						
						
		return $this->conn->query($sql);
		    	
    }
    
    
    public function getTopic($id) {
    
    	// $sql = "SELECT * FROM rss_items WHERE source LIKE '" . $id . "' ORDER BY pubDate DESC LIMIT 0,10";
    	
		// return $this->conn->query($sql);
    
    }
    
    
}
