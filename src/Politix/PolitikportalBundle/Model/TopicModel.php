<?php

namespace Politix\PolitikportalBundle\Model;

use Doctrine\DBAL\Connection;


class TopicModel {
    
  private $conn;
  private $days = 1.5;
  private $start_ts = 0;
	private $end_ts = 0;
  private $ids = array();

  function __construct(Connection $conn) {
    $this->conn = $conn;
    $this->setPeriod();
  }
    
  public function setPeriod($days = false) {
    if (!$days) { 
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
		}
	
		// august long archive
		// $days = 5;

    $this->start_ts = time() - ($days * 86400) + 20000;
    $this->end_ts = mktime (23,59,59,date("m"),date("d"),date("Y"));
    
  }
    
  public function getHomepageTopics() {	
		$sql = "SELECT	topics.url AS topicUrl,
						topics.id AS id,
						topics.title_at,
						COUNT(rss_items.id) AS rssCount,
						MAX(rss_items.myDate) AS maxDate,
						MIN(rss_items.rank) AS maxRank
				
			      FROM	topics
				
				    INNER JOIN topic_links ON (topics.id = topic_links.fid_topics)
				    INNER JOIN rss_items ON (topic_links.fid_rss_items = rss_items.id)
				    INNER JOIN rss_sources ON (rss_sources.id = rss_items.source)
				
				    WHERE	rss_items.rank <> 2 AND
						      rss_items.rank < 4 AND
						      (UNIX_TIMESTAMP(rss_items.myDate) > (" . $this->start_ts . " -1)) AND
						      UNIX_TIMESTAMP(rss_items.myDate) < " . $this->end_ts . "
						
				    GROUP BY topics.id
				
				    ORDER by topics.rank DESC,maxRank ASC,maxDate DESC
				
				    LIMIT 0,20";
						
		return $this->conn->query($sql);
	
	}
    
  public function getTopic($topic, $options = array()) {			
				
		$sql = "SELECT	UNIX_TIMESTAMP(pubDate) AS tspubDate,
						rss_items.id AS rssId,
						rss_items.lang,
						rss_items.link,
						rss_items.title AS rssTitle,
						rss_items.rank,
						rss_items.description,
						rss_items.linktype,
						rss_items.source,
						rss_sources.name AS sourceName,rss_sources.web_url AS sourceUrl,
						topics.title_at AS topicTitle
				
				    FROM rss_items
				
				    INNER JOIN rss_sources ON (rss_items.source = rss_sources.id)
				    LEFT JOIN topic_links ON (topic_links.fid_rss_items = rss_items.id)
				    LEFT JOIN topics ON (topic_links.fid_topics = topics.id)";
	  
	  if (isset($options['parent'])) {
	    $sql .= "WHERE	(topic_links.fid_topics = " . $topic['id'] . " OR topics.parent_id = " . $topic['id'] . ")";
	  } else {
	    $sql .= "WHERE	topic_links.fid_topics = " . $topic['id'];
	  }
	  
	  $sql .= " AND rss_items.rank <> 2
	            AND rss_items.rank < 4
	            AND (UNIX_TIMESTAMP(myDate) > (" . $this->start_ts . " -1))
	            AND UNIX_TIMESTAMP(myDate) < " . $this->end_ts . "

				      GROUP BY rss_items.id ";
				      
		if ((isset($options['order'])) and ($options['order'] == 'date')) {
		  $sql .= "ORDER BY pubDate DESC ";
		} else {
		  $sql .= "ORDER BY rss_items.rank ASC, pubDate DESC ";
		}
		
		if (!isset($options['start'])) $start = 0;
		if (!isset($options['limit'])) $limit = 100;
		
		$sql .= "LIMIT $start, $limit";
					
		return $this->removeDouble($this->conn->fetchAll($sql));
		
  }
  
  public function getId($url) {
    $sql = "SELECT id FROM topics WHERE url LIKE '$url'";
    return $this->conn->fetchAssoc($sql);
    //return $result['id'];
  }
    
  public function removeDouble($topic) {
    $cleanTopic = array();
    foreach ($topic as $item) {
    	if (!in_array($item['rssId'],$this->ids)) {
    		$this->ids[] = $item['rssId'];
    		$cleanTopic[] = $item;
    	}
    } 
    return $cleanTopic;
  }  
    
}
