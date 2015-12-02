<?php


class PostDatabase {
	
	public $dbHandle;
	
	public $pages;
		
	public function __construct() {
		
		try {
		    $this->dbHandle = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASSWORD);
			  $this->dbHandle->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		} catch (PDOException $error) {
		    print "Error!: " . $error->getMessage() . "<br/>";
		    die();
		}
	}
	
	public function __destruct() {
		$this->dbHandle = null;
	}
/*	
	public function PDOFetchAssoc($query,$params) {
		$statement = $this->dbHandle->prepare($query);
		$statement->execute($params);
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		$result = $statement->fetch();
		return $result;
	}
	
	public function PDOExecute($query,$params) {
		$statement = $this->dbHandle->prepare($query);
		$statement->execute($params);
	}
*/	
	/* cleans arrays and scalar values and makes them ready for SQL queries */
	public function clean(&$args) {
		/*
		if (is_array($args)) {
			foreach ($args as &$arg) {
				$arg = $this->dbHandle->real_escape_string($arg);
			}
		}
		else {
			$args = $this->dbHandle->real_escape_string($args);
		}*/
	}

	
	protected function getTotalRecords($table) {
		$query = "SELECT COUNT(*) FROM $table";
		$statement = $this->dbHandle->prepare($query);
		$statement->execute();
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		$records = $statement->fetch();
		return $records['COUNT(*)'];
	}
	
	/* returns a paged result set, and sets $this->pages to the number of total pages in the result */
	protected function pagedQuery($page = null, $size, $table, $sort, $order, $fields="*") {
	    $offset = ($page - 1) * $size;
		$params = array();
		$params['offset'] = $offset;
		$params['size'] = $size;
		$params['table'] = $table;
		$params['sort'] = $sort;
		$params['order'] = $order;
		$statementString = "SELECT " .$fields . " FROM {$params['table']} ORDER BY {$params['sort']} {$params['order']} LIMIT {$params['offset']}, {$params['size']}";
		$statement = $this->dbHandle->prepare($statementString);   			
	    $statement->execute();
		$total = 0;
		$items = array();
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		while ($item = $statement->fetch())
	        {
	            $items[] = $item;
	        }

	    // fetch the TOTAL number of records
		$total = $this->getTotalRecords($table);
		$this->pages = ceil($total/$size);
		return $items;
	}
	
	public function updatePriority($table,$saveids,$priorities) {
		for ($i = 0;$i<count($saveids);$i++) {
			$params = array();
			$params['saveid'] = (int)$saveids[$i];
			$params['priority'] = (int)$priorities[$i];
			$statement = $this->dbHandle->prepare("UPDATE $table SET priority=:priority WHERE id=:saveid");
			$statement->execute($params);
		}
	}
}
?>