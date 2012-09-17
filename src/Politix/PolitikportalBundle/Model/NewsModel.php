<?php

namespace Politix\PolitikportalBundle\Model;
use Doctrine\DBAL\Connection;

class NewsModel {
    
  private $conn;

  function __construct(Connection $conn) {
    $this->conn = $conn;
  }
  
  public function getLink($id) {
    if (!is_numeric($id)) return FALSE;
    $sql = "SELECT link FROM rss_items WHERE id = " . $id;
    $result = $this->conn->fetchAssoc($sql);
    if ($result) {
      return $result['link'];
    } else {
      return FALSE;
    }
  }
  
  public function saveClick($id, $url, $i, $p, $textversion) {
    if (isset($_SERVER["HTTP_REFERER"])) {
      $referer = "'" . $_SERVER["HTTP_REFERER"] . "'";
    } else {
      $referer = "NULL";
    }
    $sql = "INSERT INTO clicklog01
              (id,site,ip,user,url,useragent,go,ref,item_id,i,p,sessionid,textversion)
		          VALUES (
		            NULL," .
		            "'politikportal'," .
		            "'" . $_SERVER["REMOTE_ADDR"] . "'," . 
					      "NULL," . 
					      "'" . $_SERVER["REQUEST_URI"] . "'," . 
					      "'" . $_SERVER["HTTP_USER_AGENT"] . "'," .
					      "'" . $url . "'," .
					      $referer . "," .
					      $id . "," .
					      $i . "," .
					      "'" . $p . "'," .
					      "'" . session_id() . "'," . 
					      $textversion . ")";
    $this->conn->query($sql);
  }

}
