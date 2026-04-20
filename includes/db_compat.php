<?php
/**
 * Database Compatibility Layer for SQLite
 * Mimics mysqli behavior using PDO to minimize code changes.
 */

class SQLitePDO extends PDO {
    public $error = "";
    public $errno = 0;
    public $insert_id = 0;

    #[\ReturnTypeWillChange]
    public function query($statement, $mode = null, ...$fetch_modeArgs) {
        try {
            if ($mode === null) {
                $res = parent::query($statement);
            } else {
                $res = parent::query($statement, $mode, ...$fetch_modeArgs);
            }
            if (!$res) {
                $err = $this->errorInfo();
                $this->error = $err[2];
                $this->errno = $err[1];
                return false;
            }
            return new SQLiteResult($res, $this);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            $this->errno = $e->getCode();
            return false;
        }
    }

    #[\ReturnTypeWillChange]
    public function prepare($query, $options = []) {
        try {
            $stmt = parent::prepare($query, $options);
            return new SQLiteStatement($stmt, $this);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }

    public function get_last_id() {
        return $this->lastInsertId();
    }
}

class SQLiteResult {
    private $stmt;
    private $conn;
    public $num_rows = 0;

    public function __construct($stmt, $conn) {
        $this->stmt = $stmt;
        $this->conn = $conn;
        // Count rows for num_rows property
        $rows = $this->stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->num_rows = count($rows);
        // Reset the statement by creating a new iterator if needed, 
        // but PDOStatement::fetchAll already does the job.
        // We'll store the data and simulate fetch.
        $this->data = $rows;
        $this->current_row = 0;
    }

    public function fetch_assoc() {
        if ($this->current_row >= $this->num_rows) return null;
        return $this->data[$this->current_row++];
    }

    public function fetch_array() {
        if ($this->current_row >= $this->num_rows) return null;
        $row = $this->data[$this->current_row++];
        // Combine assoc and numeric for fetch_array behavior
        return array_merge($row, array_values($row));
    }
}

class SQLiteStatement {
    private $stmt;
    private $conn;
    public $num_rows = 0;

    public function __construct($stmt, $conn) {
        $this->stmt = $stmt;
        $this->conn = $conn;
    }

    public function bind_param($types, ...$vars) {
        // mysqli uses types like "ssi", PDO uses positional ? starting at 1
        foreach ($vars as $i => $var) {
            // Use bindValue as mysqli's behavior for passing values matches bindValue better in this wrapper context
            // especially when variables are not explicitly passed by reference into ...$vars
            $this->stmt->bindValue($i + 1, $var);
        }
        return true;
    }

    public function execute() {
        try {
            $res = $this->stmt->execute();
            if ($res) {
                $lastId = $this->conn->lastInsertId();
                if ($lastId) {
                    $this->conn->insert_id = $lastId;
                }
            }
            return $res;
        } catch (PDOException $e) {
            $this->conn->error = $e->getMessage();
            return false;
        }
    }

    public function get_result() {
        return new SQLiteResult($this->stmt, $this->conn);
    }
}

// Procedural wrappers
if (!function_exists('mysqli_fetch_array')) {
    function mysqli_fetch_array($result) {
        if ($result instanceof SQLiteResult) {
            return $result->fetch_array();
        }
        return null;
    }
}

if (!function_exists('mysqli_fetch_assoc')) {
    function mysqli_fetch_assoc($result) {
        if ($result instanceof SQLiteResult) {
            return $result->fetch_assoc();
        }
        return null;
    }
}

if (!function_exists('mysqli_insert_id')) {
    function mysqli_insert_id($conn) {
        if ($conn instanceof SQLitePDO) {
            return $conn->lastInsertId();
        }
        return 0;
    }
}

if (!function_exists('mysqli_real_escape_string')) {
    function mysqli_real_escape_string($conn, $string) {
        return str_replace("'", "''", $string);
    }
}

if (!function_exists('mysqli_error')) {
    function mysqli_error($conn) {
        if ($conn instanceof SQLitePDO) {
            return $conn->error;
        }
        return "";
    }
}

if (!function_exists('mysqli_num_rows')) {
    function mysqli_num_rows($result) {
        if ($result instanceof SQLiteResult) {
            return $result->num_rows;
        }
        return 0;
    }
}

if (!function_exists('mysqli_query')) {
    function mysqli_query($conn, $sql) {
        if ($conn instanceof SQLitePDO) {
            return $conn->query($sql);
        }
        return false;
    }
}


