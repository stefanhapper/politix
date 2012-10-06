<?php

namespace Politix\PolitikportalBundle\Model;
use Doctrine\DBAL\Connection;

class UserModel {
    
    private $conn;
    
    function __construct(Connection $conn) {
    	$this->conn = $conn;
    }
    
    public function existingEmail($email) {
  		$sql = "SELECT id FROM subscribers WHERE email LIKE '" . $email . "'";
	  	$rows = $this->conn->fetchAll($sql);
		  if ($rows) return true;
		  else return false;
    }

    public function addEmail($email) {
    	$sql = "INSERT INTO subscribers (email,type,info) VALUES ('" . $email . "','daily','self')";
  		$result = $this->conn->query($sql);
	  	if ($result == TRUE) {
			  $id = $this->conn->lastInsertId();
			  $info = "user registered via website";
			  $sql = "INSERT INTO subscribers_info (i,info) VALUES (" . mysql_real_escape_string($id) . ",'" . mysql_real_escape_string($info) . "')";
			  $this->conn->query($sql);
			  return TRUE;
		  } else {
			  return FALSE;
		  }
	  }


/******************************************************************************
	Validate an email address.
	Returns true if the email address has the email address format
*************************************************************************** */

	public function validEmail($email) {
	   $isValid = true;
	   $atIndex = strrpos($email, "@");
	   if (is_bool($atIndex) && !$atIndex)
	   {
		  $isValid = false;
	   }
	   else
	   {
		  $domain = substr($email, $atIndex+1);
		  $local = substr($email, 0, $atIndex);
		  $localLen = strlen($local);
		  $domainLen = strlen($domain);
		  if ($localLen < 1 || $localLen > 64)
		  {
			 // local part length exceeded
			 $isValid = false;
		  }
		  else if ($domainLen < 1 || $domainLen > 255)
		  {
			 // domain part length exceeded
			 $isValid = false;
		  }
		  else if ($local[0] == '.' || $local[$localLen-1] == '.')
		  {
			 // local part starts or ends with '.'
			 $isValid = false;
		  }
		  else if (preg_match('/\\.\\./', $local))
		  {
			 // local part has two consecutive dots
			 $isValid = false;
		  }
		  else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain))
		  {
			 // character not valid in domain part
			 $isValid = false;
		  }
		  else if (preg_match('/\\.\\./', $domain))
		  {
			 // domain part has two consecutive dots
			 $isValid = false;
		  }
		  else if
	(!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/',
					 str_replace("\\\\","",$local)))
		  {
			 // character not valid in local part unless 
			 // local part is quoted
			 if (!preg_match('/^"(\\\\"|[^"])+"$/',
				 str_replace("\\\\","",$local)))
			 {
				$isValid = false;
			 }
		  }
	   }
	   return $isValid;
	}
	

/******************************************************************************
	Verify an email address
	Returns true if the domain of the email address can be found in DNS
*************************************************************************** */

	public function verifyEmail($email) {
		$atIndex = strrpos($email, "@");
		$domain = substr($email, $atIndex+1);
		if ((checkdnsrr($domain,"MX") || checkdnsrr($domain,"A"))) {
			// domain found in DNS
			return true;
		} else {
			// domain not found
			return false;
		}
	}
    
}
