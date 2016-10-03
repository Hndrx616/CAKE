<?php
//*******************************************************************
//Template Name: cake_db_mysql.php
//Author: Stephen Hilliard (c) 2016
//Developer: Stephen Hilliard (c) 2016
//license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
// @package plugins/db
// @project: cake_db_mysql
//*******************************************************************/


define('CAKE_DTD_BIGINT', 'BIGINT'); 
define('CAKE_DTD_INT', 'INT');
define('CAKE_DTD_TINYINT', 'TINYINT(1)');
define('CAKE_DTD_TINYINT2', 'TINYINT(2)');
define('CAKE_DTD_TINYINT4', 'TINYINT(4)');
define('CAKE_DTD_SERIAL', 'SERIAL');
define('CAKE_DTD_PRIMARY_KEY', 'PRIMARY KEY');
define('CAKE_DTD_VARCHAR10', 'VARCHAR(10)');
define('CAKE_DTD_VARCHAR255', 'VARCHAR(255)');
define('CAKE_DTD_VARCHAR', 'VARCHAR(%s)');
define('CAKE_DTD_TEXT', 'MEDIUMTEXT');
define('CAKE_DTD_BOOLEAN', 'TINYINT(1)');
define('CAKE_DTD_TIMESTAMP', 'TIMESTAMP');
define('CAKE_DTD_BLOB', 'BLOB');
define('CAKE_DTD_INDEX', 'KEY');
define('CAKE_DTD_AUTO_INCREMENT', 'AUTO_INCREMENT');
define('CAKE_DTD_NOT_NULL', 'NOT NULL');
define('CAKE_DTD_UNIQUE', 'PRIMARY KEY(%s)');
define('CAKE_SQL_ADD_COLUMN', 'ALTER TABLE %s ADD %s %s');   
define('CAKE_SQL_DROP_COLUMN', 'ALTER TABLE %s DROP %s');
define('CAKE_SQL_RENAME_COLUMN', 'ALTER TABLE %s CHANGE %s %s %s'); 
define('CAKE_SQL_MODIFY_COLUMN', 'ALTER TABLE %s MODIFY %s %s'); 
define('CAKE_SQL_RENAME_TABLE', 'ALTER TABLE %s RENAME %s'); 
define('CAKE_SQL_CREATE_TABLE', 'CREATE TABLE IF NOT EXISTS %s (%s) %s'); 
define('CAKE_SQL_DROP_TABLE', 'DROP TABLE IF EXISTS %s');  
define('CAKE_SQL_INSERT_ROW', 'INSERT into %s (%s) VALUES (%s)');
define('CAKE_SQL_UPDATE_ROW', 'UPDATE %s SET %s %s');
define('CAKE_SQL_DELETE_ROW', "DELETE from %s %s");
define('CAKE_SQL_CREATE_INDEX', 'CREATE INDEX %s ON %s (%s)');
define('CAKE_SQL_DROP_INDEX', 'DROP INDEX %s ON %s');
define('CAKE_SQL_INDEX', 'INDEX (%s)');
define('CAKE_SQL_BEGIN_TRANSACTION', 'BEGIN');
define('CAKE_SQL_END_TRANSACTION', 'COMMIT');
define('CAKE_DTD_TABLE_TYPE', 'ENGINE = %s');
define('CAKE_DTD_TABLE_TYPE_DEFAULT', 'INNODB');
define('CAKE_DTD_TABLE_TYPE_DISK', 'INNODB');
define('CAKE_DTD_TABLE_TYPE_MEMORY', 'MEMORY');
define('CAKE_SQL_ALTER_TABLE_TYPE', 'ALTER TABLE %s ENGINE = %s');
define('CAKE_SQL_JOIN_LEFT_OUTER', 'LEFT OUTER JOIN');
define('CAKE_SQL_JOIN_LEFT_INNER', 'LEFT INNER JOIN');
define('CAKE_SQL_JOIN_RIGHT_OUTER', 'RIGHT OUTER JOIN');
define('CAKE_SQL_JOIN_RIGHT_INNER', 'RIGHT INNER JOIN');
define('CAKE_SQL_JOIN', 'JOIN');
define('CAKE_SQL_DESCENDING', 'DESC');
define('CAKE_SQL_ASCENDING', 'ASC');
define('CAKE_SQL_REGEXP', 'REGEXP');
define('CAKE_SQL_NOTREGEXP', 'NOT REGEXP');
define('CAKE_SQL_LIKE', 'LIKE');
define('CAKE_SQL_ADD_INDEX', 'ALTER TABLE %s ADD INDEX (%s) %s');
define('CAKE_SQL_COUNT', 'COUNT(%s)');
define('CAKE_SQL_SUM', 'SUM(%s)');
define('CAKE_SQL_ROUND', 'ROUND(%s)');
define('CAKE_SQL_AVERAGE', 'AVG(%s)');
define('CAKE_SQL_DISTINCT', 'DISTINCT %s');
define('CAKE_SQL_DIVISION', '(%s / %s)');
define('CAKE_DTD_CHARACTER_ENCODING_UTF8', 'utf8');
define('CAKE_DTD_TABLE_CHARACTER_ENCODING', 'CHARACTER SET = %s');


/**
 * MySQL Data Access Class
 */
class cake_db_mysql extends cake_db {

	function connect() {
	
		if (!$this->connection) {
		
			if ($this->getConnectionParam('persistant')) {
				
				$this->connection = mysql_pconnect(
					$this->getConnectionParam('host'),
					$this->getConnectionParam('user'),
					$this->getConnectionParam('password'),
					$this->getConnectionParam('open_new_connection')
	    		);
	    		
			} else {
				
				$this->connection = mysql_connect(
					$this->getConnectionParam('host'),
					$this->getConnectionParam('user'),
					$this->getConnectionParam('password'),
					$this->getConnectionParam('open_new_connection')
	    		);
			}
			
			$this->database_selection = mysql_select_db($this->getConnectionParam('name'), $this->connection);
			
			if (function_exists('mysql_set_charset')) {
				mysql_set_charset('utf8',$this->connection);
			} else {
				$this->query("SET NAMES 'utf8'");
			}
			
		}
			
			
		if (!$this->connection || !$this->database_selection) {
			$this->e->alert('Could not connect to database.');
			$this->connection_status = false;
			return false;
		} else {
			$this->connection_status = true;
			return true;
		}
	}

	/**
	 * Database Query
	 * @param 	string $sql
	 * @access 	public
	 */
	function query( $sql ) {
  
  		if ( $this->connection_status == false) {
  			
  			cake_coreAPI::profile($this, __FUNCTION__, __LINE__);
  			
  			$this->connect();
  			
  			cake_coreAPI::profile($this, __FUNCTION__, __LINE__);
  		}
  
  		cake_coreAPI::profile($this, __FUNCTION__, __LINE__);
		
		$this->e->debug(sprintf('Query: %s', $sql));
		
		$this->result = '';
		
		$this->new_result = '';	
		
		if (!empty($this->new_result)) {
			mysql_free_result($this->new_result);
		}
		
		cake_coreAPI::profile($this, __FUNCTION__, __LINE__, $sql);
		
		$result = @mysql_unbuffered_query( $sql, $this->connection );
		
		cake_coreAPI::profile($this, __FUNCTION__, __LINE__);			
		// Log Errors
		
		if ( mysql_errno( $this->connection ) ) {
			$this->e->debug(
				sprintf(
					'A MySQL error ocured. Error: (%s) %s. Query: %s',
					mysql_errno( $this->connection ), 
					htmlspecialchars( mysql_error( $this->connection ) ),
					$sql
				)
			);
		}
		
		cake_coreAPI::profile($this, __FUNCTION__, __LINE__);
		
		$this->new_result = $result;
		
		return $this->new_result;
	}
	
	function close() {
		
		@mysql_close($this->connection);
		return;
		
	}
	
	/**
	 * Fetch result set array
	 * @param 	string $sql
	 * @return 	array
	 * @access  public
	 */
	function get_results( $sql ) {
	
		if ( $sql ) {
		
			$this->query($sql);
		}
	
		$num_rows = 0;
		
		while ( $row = @mysql_fetch_assoc($this->new_result) ) {
		
			$this->result[$num_rows] = $row;
			$num_rows++;
		}
		
		if ( $this->result ) {
					
			return $this->result;
			
		} else {
		
			return null;
		}
	}
	
	/**
	 * Fetch Single Row
	 * @param string $sql
	 * @return array
	 */
	function get_row($sql) {
		
		$this->query($sql);
		
		//print_r($this->result);
		$row = @mysql_fetch_assoc($this->new_result);
		
		return $row;
	}
	
	/**
	 * Prepares and escapes string
	 * @param string $string
	 * @return string
	 */
	function prepare( $string ) {
		
		if ($this->connection_status == false) {
  			$this->connect();
  		}
		
		return mysql_real_escape_string($string, $this->connection); 
		
	}
	
	function getAffectedRows() {
		
		return mysql_affected_rows();
	}
}
?>