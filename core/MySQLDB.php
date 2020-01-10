<?php
/*
   MySQL Database Connection Class
   encapsulates PROCEDURAL mysqli 
*/


class MySQL 
{
	var  $host;
	var  $dbUser;
	var  $dbPass;
	var  $dbName;
	var  $dbConn;
	var  $dbconnectError;

	function __construct( $host, $dbUser, $dbPass, $dbName )
	{
	 $this->host   = $host;
	 $this->dbUser = $dbUser;
	 $this->dbPass = $dbPass;
	 $this->dbName = $dbName;
	 $this->connectToServer();
	}

	function connectToServer()
	{
	   $this->dbConn = mysqli_connect($this->host, $this->dbUser, $this->dbPass );
	   if ( ! $this->dbConn )
	   {
		  trigger_error ('could not connect to server' );
		  $this->dbconnectError = true;
	   }
	   else
	   {
			echo "<script>
			console.log('connected to server');
			</script>";
	   }
	}

	function selectDatabase()
	{
	if (! mysqli_select_db( $this->dbConn, $this->dbName ) )
		   {
				trigger_error('could not select database' );  
				$this->dbconnectError = true;                     
		   }
		   else
		   {
				echo "<script>
				console.log('$this->dbName  database selected');
				</script>";
		   }
	}
 

	function createDatabase()
	{
		$sql = "create database if not exists $this->dbName";
		echo "<script> console.log($sql); </script>";
		if ( $this->query($sql) )
		{
			echo "<script>
			console.log('the $this->dbName database was created');
			</script>";
		}
		else
		{
			echo "<script>
			console.log('the $this->dbName database was not created');
			</script>";
		}
	}	   


   function isError()
   {
		if  ( $this->dbconnectError )
		{
			return true;
		}
		$error = mysqli_error ( $this->dbConn );
		if ( empty ($error) )
        {
			return false;
        }
        else
        {
			return true;   
        }
   }


   function query( $sql )
   {
		if ( ! $queryResource = mysqli_query( $this->dbConn, $sql ) )
		{
			trigger_error( 'Query Failed: ' . mysqli_error($this->dbConn ) . ' SQL: ' . $sql );
			return false;
		}
		echo "<script> console.log('OK - |" . $sql . "| Worked'); </script>";
		return new MySQLResult( $this, $queryResource ); 
   }
}


class MySQLResult 
{
   var $mysql;
   var $queryResource;

   function __construct( $newMysql, $newQueryResource )
   {
		$this->mysql = $newMysql;
		$this->queryResource = $newQueryResource;
   }

    function size()
    {
		return mysqli_num_rows( $this->queryResource );
    }

    function fetch()
    {
       if ( $row = mysqli_fetch_array( $this->queryResource , MYSQLI_ASSOC ))
       {
			return $row;
       }
       else if ( $this->size() > 0 )
       {
			mysqli_data_seek( $this->queryResource , 0 );
			return false;
       }
       else
       {
			return false;
       }         
    }
	
	function insertID()
    {
      return mysqli_insert_id( $this->mysql->dbConn );
    }


   function isError()
    {
      return $this->mysql->isError();
    }
}