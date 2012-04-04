<?php

namespace Politix\PolitikportalBundle\Model;

// use Symfony\Bundle\FrameworkBundle\Controller\Controller;

//use Doctrine\DBAL\Connection;


class SourceModel {
    
    
    public function getSources($start = 0, $max = 10) {
    
        //$conn = $this->get('database_connection');
        
        $config = new \Doctrine\DBAL\Configuration();

		$params = array(
    		'dbname' => 'politikportal',
    		'user' => 'politikportal',
   			'password' => 'p2008db',
    		'host' => 'localhost',
			'driver' => 'pdo_mysql',
		);

		$conn = DriverManager::getConnection($params, $config);


    	$sql = "SELECT * FROM sources LIMIT $start,$max";
    	
		return $conn->query($sql);
		    	
    }
    
    
    
    
}
