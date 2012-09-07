<?php

namespace Politix\PolitikportalBundle\Model;
use Doctrine\DBAL\Connection;

class NewsModel {
    
  private $conn;

  function __construct(Connection $conn) {
    $this->conn = $conn;
  }
  
  public function getLink($id) {
    $sql = "SELECT link FROM rss_items WHERE id = " . $id;
    $result = $this->conn->fetchAssoc($sql);
    return $result['link'];
  }

}
