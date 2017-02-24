<?php
session_start();


class Conexion extends PDO {
	
	
	private $tipo_de_base = 'mysql';
	
	private $host = 'localhost';
	
	private $nombre_de_base = 'prueba';
	
	private $usuario = 'root';
	
	private $contrasena = 'zayro';
	
	
	public function __construct() {
		
		try{
			
			
			parent::__construct($this->tipo_de_base.':host='.$this->host.';dbname='.$this->nombre_de_base, $this->usuario, $this->contrasena);
			
			
		}
		
		catch(PDOException $e){
			
			
			echo 'Ha surgido un error y no se puede conectar a la base de datos. Detalle: ' . $e->getMessage();
			
			
			exit;
			
			
		}
		
		
	}
	
	
	
	
}

 
class POSTGRES extends PDO
{
 
 //nombre base de datos
 private $dbname = "prueba";
 //nombre servidor
 private $host = "localhost";
 //nombre usuarios base de datos
 private $user = "postgres";
 //password usuario
 private $pass = 123456;
 //puerto postgreSql
 private $port = 5432;
 private $dbh;
 
 //creamos la conexión a la base de datos prueba
 public function __construct() 
 {
     try {
 
         $this->dbh = parent::__construct("pgsql:host=$this->host;port=$this->port;dbname=$this->dbname;user=$this->user;password=$this->pass");
 
     } catch(PDOException $e) {
 
         echo  $e->getMessage(); 
 
     }
 
 }
 
 //función para cerrar una conexión pdo
 public function close_con() 
 {
 
     $this->dbh = null; 
 
 }
 
}


class Oracle {
	
	
	private $dbh;
	
	
	function __construct() {
		
		try {
			
			
			$server         = "127.0.0.1";
			
			$db_username    = "SYSTEM";
			
			$db_password    = "Oracle_1";
			
			$service_name   = "ORCL";
			
			$sid            = "ORCL";
			
			$port           = 1521;
			
			$dbtns          = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = $server)(PORT = $port)) (CONNECT_DATA = (SERVICE_NAME = $service_name) (SID = $sid)))";
			
			
			//$			this->dbh = new PDO("mysql:host=".$server.";dbname=".dbname, $db_username, $db_password);
			
			
			$this->dbh = new PDO("oci:dbname=" . $dbtns . ";charset=utf8", $db_username, $db_password, array(
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_EMULATE_PREPARES => false,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC));
			
			
		}
		catch (PDOException $e) {
			
			echo $e->getMessage();
			
		}
		
	}
	
	
	public function select($sql) {
		
		$sql_stmt = $this->dbh->prepare($sql);
		
		$sql_stmt->execute();
		
		$result = $sql_stmt->fetchAll(PDO::FETCH_ASSOC);
		
		return $result;
		
	}
	
	
	public function insert($sql) {
		
		$sql_stmt = $this->dbh->prepare($sql);
		
		try {
			
			$result = $sql_stmt->execute();
			
		}
		catch (PDOException $e) {
			
			trigger_error('Error occured while trying to insert into the DB:' . $e->getMessage(), E_USER_ERROR);
			
		}
		
		if ($result) {
			
			return $sql_stmt->rowCount();
			
		}
		
	}
	
	
	function __destruct() {
		
		$this->dbh = NULL;
		
	}
	
	
}


