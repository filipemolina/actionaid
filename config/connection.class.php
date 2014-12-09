<?php
class DB {
  
//   private $host = 'localhost';
//   private $user = 'root';
//   private $pass = '';
 
  private $host = 'br254.hostgator.com.br';
  // private $host = 'localhost';
  private $user = 'doeum083_admin';
  // private $user = 'root';
  private $pass = 'G1020304050';
  // private $pass = '';

  public function __construct($db) {

    if( ! @mysql_connect($this->host, $this->user, $this->pass))
    {
       die(mysql_error());
    }

    if(!mysql_select_db($db)) {
      die(mysql_error());
    }

 }

  public function query($sql) {
    return mysql_query($sql);
  }

  public function fetch_object($sql) {
    return mysql_fetch_object($sql);
  }

  public function fetch_array($sql) {
    return mysql_fetch_array($sql);
  }

  public function num_rows($sql) {
   return mysql_num_rows($sql);
  }
  
  public function real_escape_string($val) {
  	return mysql_real_escape_string($val);
  } 

  public function aff_rows() {
   return mysql_affected_rows();
  }


  public function insert_id() {
   return mysql_insert_id();
  }

  public function close() {
   return mysql_close();
  }
}

// $con = new DB('comunidade');
$con = new DB('doeum083_app');
?>