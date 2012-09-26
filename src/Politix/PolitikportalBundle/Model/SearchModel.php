<?php

namespace Politix\PolitikportalBundle\Model;
use Doctrine\DBAL\Connection;

class SearchModel {
    
  private $conn;

  function __construct(Connection $conn) {
    $this->conn = $conn;
  }
  
  public function searchNews($query) {
    $sql = 'SELECT
              UNIX_TIMESTAMP(pubDate) AS tspubDate,
              rss_items.id AS rssId,
              rss_items.lang,
              rss_items.link,
              rss_items.title AS rssTitle,
              rss_items.rank,
              rss_items.description,
              rss_items.linktype,
              rss_items.source,
              rss_sources.name AS sourceName,rss_sources.web_url AS sourceUrl
            FROM rss_items
						  INNER JOIN rss_sources ON (rss_items.source = rss_sources.id)
            WHERE
              (rss_items.rank < 4) AND
              MATCH (title, description)
              AGAINST ("' . $query . '" IN BOOLEAN MODE) ORDER BY pubDate DESC';
    return $this->conn->fetchAll($sql);
  }
  
}
