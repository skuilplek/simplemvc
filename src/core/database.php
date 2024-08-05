<?php


//TODO Better to use PDO, but mysqli is faster for MySQL only apps


class Database
{

	private $host = DATABASE_SERVER;
	private $username = DATABASE_USERNAME;
	private $password = DATABASE_PASSWORD;
	private $database = DATABASE_NAME;
	private $dbconn; /** stores the mysqli database details */
	private $query; /** stores the mysqli queries */
	private $results = array(); /** stores the mysqli results in an array */
	private $count = 0; /** stores the number of rows (count) from a mysqli query */
	public $error = ""; /** stores the mysqli error */

	public static $connection;


	/** Call to start the database connection
	 * @return mixed the database connection
	 */
	public static function dbconn()
	{
		if (!isset(self::$connection)) {
			self::$connection = new Database();
		}
		return self::$connection;
	}

	/** Obtains the database connection singleton instance
	 * @usage $db = Database::obtain();
	 * @return mixed the database connection
	 */
	public static function obtain()
	{
		return self::dbconn();
	}

	/**
	 * Builds the database connection to work with
	 */
	public function __construct()
	{
		$this->dbconn = new mysqli($this->host, $this->username, $this->password, $this->database);

		if ($this->dbconn->connect_errno) {
			error_log("DB ERROR: Connecting To Mysqli Failed --> " . $this->dbconn->connect_error . "..");
			$this->error = $this->dbconn->connect_error;
			//TODO create a nice HTML file to display to users when the DB is down
			die("..Database ERROR..");
		} else {
			$this->error = "";
			$this->dbconn->set_charset("utf8");
		}
	}

	/**
	 * Returns tha raw connection object in case we need it
	 * @return mixed
	 */
	public function connection()
	{
		return $this->dbconn;
	}

	/**
	 * Escapes the input and returns the escaped string 
	 * @param mixed $data the data to be escaped
	 * @return mixed the escaped data
	 */
	public function escape($data)
	{
		return $this->dbconn->real_escape_string($data);
	}


	/**
	 * Runs a database query with the givin SQL string
	 * @param string $sql the raw SQL query to perform
	 * @return mixed the result, if any
	 */
	public function query($sql)
	{
		try {
			$this->query = $this->dbconn->query($sql);
			if ($this->dbconn->errno == 1146) {
				$this->error = "No such table";
				error_log("DB ERROR1: " . $this->dbconn->error);
				return;
			}
			if (!$this->query) {
				error_log("DB ERROR2: query failed --> " . $this->dbconn->error . "..");
				error_log("DB ERROR3: " . $sql);
				$this->error = $this->dbconn->error;
				return false;
			} else {
				$this->error = "";
				if (is_object($this->query)) {
					$this->results = array();
					while ($row = $this->query->fetch_object()) {
						$this->results[] = $row;
					}
					$this->count = $this->query->num_rows;
				}
			}
			if ($this->dbconn->insert_id > 0)
				return $this->dbconn->insert_id;
			return $this->results;

		} catch (Exception $e) {
			error_log($e->getMessage());
		}
	}

	/**
	 * Returns the results of the last query
	 * @return mixed 
	 */
	public function results()
	{
		return $this->results;
	}

	/**
	 * Returns the number of results in the last query
	 * @return int the number of rows
	 */
	public function count()
	{
		return $this->count;
	}

	/**
	 * Fetches the data from the database and returns it as an array
	 * @param string $sql the raw SQL query to perform
	 * @return mixed an array of data
	 */
	public function query_array($sql)
	{
		$this->query($sql);
		if (count($this->results) > 0)
			return object_to_array($this->results);
		else
			return array();

	}

	/**
	 * Fetches the data from the database and returns it as a value
	 * @param string $sql the raw SQL query to perform
	 * @return string a single value
	 */
	public function query_var($sql)
	{
		$data = $this->query_first($sql);
		if (count($data) > 0) {
			$data = array_reverse($data);
			return array_pop($data);
		} else
			return "";
	}

	/**
	 * Fetches the data from the database and returns it as an array
	 * @param string $sql the raw SQL query to perform
	 * @return mixed an array of a single result
	 */
	public function query_first($sql)
	{
		$this->query($sql);
		if (count($this->results) > 0)
			return object_to_array($this->results[0]);
		else
			return array();
	}

	/**
	 * Gets the id of the last inserted item
	 * @param string $sql the raw SQL query to perform
	 * @return int an item id
	 */
	public function insert_id()
	{
		return $this->dbconn->insert_id;
	}

}
