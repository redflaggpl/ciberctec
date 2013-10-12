<?
  /** Una clase php para acceder a MySQL con utiles metodos
    * orientada a objetos, y poderoso sistema debug
    * @version  1.0
    */


  class DB
  {
	/** Ponga esta variable en true si desea TODAS las consultas con debug por default:
      */
    var $defaultDebug = false;

    /** INTERNAL: El tiempo incial en milisegundos.
      */
    var $mtStart;
    /** INTERNAL: El numero de consultas ejecutadas.
      */
    var $nbQueries;
    /** INTERNAL: El ultimo resultado de un query().
      */
    var $lastResult;
    
    private $lastArray = array();

    /** 
     * Conecta a a MySQL para habilitar uso de siguientes metodos
      */
    function DB()
    {
      global $base, $server, $user, $pass;
      
      $this->mtStart    = $this->getMicroTime();
      $this->nbQueries  = 0;
      $this->lastResult = NULL;
      mysql_connect($server, $user, $pass) or die('Server connexion not possible.');
      mysql_select_db($base)               or die('Database connexion not possible.');
      mysql_query ("SET NAMES 'utf8'");
    }

    
    function query($query, $debug = -1)
    {
      $this->nbQueries++;
      $this->lastResult = mysql_query($query) or $this->debugAndDie($query);

      $this->debug($debug, $query, $this->lastResult);

      return $this->lastResult;
    }
    
    
    function execute($query, $debug = -1)
    {
      $this->nbQueries++;
      $res = mysql_query($query); // or $this->debugAndDie($query);
      return $res;
      $this->debug($debug, $query);
    }
    
    function fetchNextObject($result = NULL)
    {
      if ($result == NULL)
        $result = $this->lastResult;

      if ($result == NULL || mysql_num_rows($result) < 1)
        return NULL;
      else
        return mysql_fetch_object($result);
    }
    
  function fetchNextAssoc($result = NULL)
    {
      if ($result == NULL)
        $result = $this->lastResult;

      if ($result == NULL || mysql_num_rows($result) < 1)
        return NULL;
      else
        return mysql_fetch_assoc($result);
    }
    

    function numRows($result = NULL)
    {
      if ($result == NULL)
        return mysql_num_rows($this->lastResult);
      else
        return mysql_num_rows($result);
    }
    

    function queryUniqueObject($query, $debug = -1)
    {
      $query = "$query LIMIT 1";

      $this->nbQueries++;
      $result = mysql_query($query) or $this->debugAndDie($query);

      $this->debug($debug, $query, $result);

      return mysql_fetch_object($result);
    }
    
  	function queryUniqueArray($query, $debug = -1)
    {
      $query = "$query LIMIT 1";

      $this->nbQueries++;
      $result = mysql_query($query) or $this->debugAndDie($query);

      $this->debug($debug, $query, $result);

      return mysql_fetch_assoc($result);
    }
    

    function queryUniqueValue($query, $debug = -1)
    {
      $query = "$query LIMIT 1";

      $this->nbQueries++;
      $result = mysql_query($query) or $this->debugAndDie($query);
      $line = mysql_fetch_row($result);

      $this->debug($debug, $query, $result);

      return $line[0];
    }
    

    function maxOf($column, $table, $where)
    {
      return $this->queryUniqueValue("SELECT MAX(`$column`) FROM `$table` WHERE $where");
    }
    

    function maxOfAll($column, $table)
    {
      return $this->queryUniqueValue("SELECT MAX(`$column`) FROM `$table`");
    }
    
    
    function countOf($table, $where)
    {
      return $this->queryUniqueValue("SELECT COUNT(*) FROM `$table` WHERE $where");
    }
    

    function countOfAll($table)
    {
      return $this->queryUniqueValue("SELECT COUNT(*) FROM `$table`");
    }
    

    function debugAndDie($query)
    {
      $this->debugQuery($query, "Error");
      die("<p style=\"margin: 2px;\">".mysql_error()."</p></div>");
    }
    

    function debug($debug, $query, $result = NULL)
    {
      if ($debug === -1 && $this->defaultDebug === false)
        return;
      if ($debug === false)
        return;

      $reason = ($debug === -1 ? "Default Debug" : "Debug");
      $this->debugQuery($query, $reason);
      if ($result == NULL)
        echo "<p style=\"margin: 2px;\">Number of affected rows: ".mysql_affected_rows()."</p></div>";
      else
        $this->debugResult($result);
    }
    

    function debugQuery($query, $reason = "Debug")
    {
      $color = ($reason == "Error" ? "red" : "orange");
      echo "<div style=\"border: solid $color 1px; margin: 2px;\">".
           "<p style=\"margin: 0 0 2px 0; padding: 0; background-color: #DDF;\">".
           "<strong style=\"padding: 0 3px; background-color: $color; color: white;\">$reason:</strong> ".
           "<span style=\"font-family: monospace;\">".htmlentities($query)."</span></p>";
    }

    
    function debugResult($result)
    {
      echo "<table border=\"1\" style=\"margin: 2px;\">".
           "<thead style=\"font-size: 80%\">";
      $numFields = mysql_num_fields($result);
      // BEGIN HEADER
      $tables    = array();
      $nbTables  = -1;
      $lastTable = "";
      $fields    = array();
      $nbFields  = -1;
      while ($column = mysql_fetch_field($result)) {
        if ($column->table != $lastTable) {
          $nbTables++;
          $tables[$nbTables] = array("name" => $column->table, "count" => 1);
        } else
          $tables[$nbTables]["count"]++;
        $lastTable = $column->table;
        $nbFields++;
        $fields[$nbFields] = $column->name;
      }
      for ($i = 0; $i <= $nbTables; $i++)
        echo "<th colspan=".$tables[$i]["count"].">".$tables[$i]["name"]."</th>";
      echo "</thead>";
      echo "<thead style=\"font-size: 80%\">";
      for ($i = 0; $i <= $nbFields; $i++)
        echo "<th>".$fields[$i]."</th>";
      echo "</thead>";
      // END HEADER
      while ($row = mysql_fetch_array($result)) {
        echo "<tr>";
        for ($i = 0; $i < $numFields; $i++)
          echo "<td>".htmlentities($row[$i])."</td>";
        echo "</tr>";
      }
      echo "</table></div>";
      $this->resetFetch($result);
    }
    

    function getExecTime()
    {
      return round(($this->getMicroTime() - $this->mtStart) * 1000) / 1000;
    }
    

    function getQueriesCount()
    {
      return $this->nbQueries;
    }
    

    function resetFetch($result)
    {
      if (mysql_num_rows($result) > 0)
        mysql_data_seek($result, 0);
    }
    

    function lastInsertedId()
    {
      return mysql_insert_id();
    }
    

    function close()
    {
      mysql_close();
    }

    function getMicroTime()
    {
      list($msec, $sec) = explode(' ', microtime());
      return floor($sec / 1000) + $msec;
    }
    
    
  	/*
 	* Previene sql injection, agrega barras de escape antes de comillas
 	*/
   
	function sqlQuote($value)
	{
		if(get_magic_quotes_gpc())
	    	$value = stripslashes($value);
	        //check if this function exists
	        if(function_exists("mysql_real_escape_string"))
	        	$value = mysql_real_escape_string( $value );
			else//for PHP version <4.3.0 use addslashes
	           	$value = addslashes( $value );
	       	return $value;
	}
	
	function perform($table, $data, $action = 'insert', $parameters = '')
	{
		reset($data);
	    if ($action == 'insert') {
	      $query = 'insert into ' . $table . ' (';
	      while (list($columns, ) = each($data)) {
	        $query .= $columns . ', ';
	      }
	      $query = substr($query, 0, -2) . ') values (';
	      reset($data);
	      while (list(, $value) = each($data)) {
	        switch ((string)$value) {
	          case 'now()':
	            $query .= 'now(), ';
	            break;
	          case 'null':
	            $query .= 'null, ';
	            break;
	          default:
	            $query .= '\'' . DB::sqlQuote($value) . '\', ';
	            break;
	        }
	      }
	      $query = substr($query, 0, -2) . ')';
	    } elseif ($action == 'update') {
	      $query = 'update ' . $table . ' set ';
	      while (list($columns, $value) = each($data)) {
	        switch ((string)$value) {
	          case 'now()':
	            $query .= $columns . ' = now(), ';
	            break;
	          case 'null':
	            $query .= $columns .= ' = null, ';
	            break;
	          default:
	            $query .= $columns . ' = \'' . DB::sqlQuote($value) . '\', ';
	            break;
	        }
	      }
	      $query = substr($query, 0, -2) . ' where ' . $parameters;
	    }
	
	    return DB::execute($query);
	  }
	  
  	/**
	* @desc prepara el tipo de dato
	* @param valor
	* @param tipo de dato
	* @return string int date
	*/
	function sqlInput($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
	{
	  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;
	
	  switch ($theType) {
	    case "text":
	      $theValue = ($theValue != "") ?  $theValue : "NULL";
	      break;    
	    case "long":
	    case "int":
	      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
	      break;
	    case "double":
	      $theValue = ($theValue != "") ?   doubleval($theValue)   : "NULL";
	      break;
	    case "date":
	      $theValue = ($theValue != "") ?  $theValue  : "NULL";
	      break;
	    case "defined":
	      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
	      break;
  		}
  		return $theValue;
	}
	
 } // class DB
?>