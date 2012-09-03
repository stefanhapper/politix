<?php

namespace Politix\PolitikportalBundle\Model;
use Doctrine\DBAL\Connection;

class LogModel {

  private $conn;
  public $host;
    
  function __construct(Connection $conn) {
    $this->conn 					= $conn;
    $this->host 					= '176.58.110.16';
    $this->syntax['log'] 	= 'CREATE TABLE log (
    												  id int(11) unsigned NOT NULL AUTO_INCREMENT,
														  timestamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
														  type tinyint(128) NOT NULL DEFAULT 0,
														  log varchar(255) NOT NULL DEFAULT "",
														  PRIMARY KEY (id,timestamp,type)
														 ) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8';
  }
    
  public function write($log, $type = 0) {
  	if (!$this->tableExists('log')) $this->createTable('log');
    $sql = "INSERT INTO log (log,type) VALUES ('$log',$type)";
		$this->conn->query($sql);
		$this->message($log);
  }
  
  public function message($log, $type = 0) {
  	$url = 'http://www.brusselsmedia.eu/msg/' . urlencode(json_encode($log));
  	@file_get_contents($url);
  }

  public function tableExists($table) {
  	$sql = "SHOW tables LIKE '$table'";
  	$rows = $this->conn->fetchAll($sql);
		if ($rows) return true;
		else return false;
  }
 
  public function createTable($table) {
		$this->message('Creating log table');
    $sql = $this->syntax[$table]; // syntax variable holds sql statement to create table
		$this->conn->query($sql);
		$this->write('Log table created');
	}
	
}
