<?php
namespace APPConnection;

use PDO;
use PDOStatement;


/*
 * Example usage
$inst = new MyDB('...', 'usr', 'pass');
var_dump($inst->isConnected());//false
$stmt = $inst->getStatement('SELECT foo, bar, FROM db.tbl WHERE id = :id');
var_dump($inst->isConnected());//true
//re-using a prepared statement:
$ids = [123, 4556];
$found = [];
foreach ($ids as $id)
{
    $stmt->execute([':id' => $id]);
    $found[] = $stmt->fetch(PDO::FETCH_OBJ);
    $stmt->closeCursor();
}
 * */

class DbConnection
{
    /**
     * @var DbConnection
     */
    private $db = null;
    
    /**
     * @var string
     */
    protected $dsn = null;
    
    /**
     * @var string
     */
    protected $user = null;
    
    /**
     * @var string
     */
    protected $pass = null;
    
    /**
     * @var array
     */
    protected $attributes = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    );
    
    /**
     * constructor
     */
    public function __construct($dsn, $user, $pass, array $attr = null)
    {
        $this->dsn = $dsn;
        $this->user = $user;
        $this->pass = $pass;
        if ($attr)
            $this->attributes = $attr;
    }
    
    /**
     * Get prepared statement
     * @param string
     * @return PDOStatement
     */
    public function getStatement($query)
    {
        $db = $this->getConnection();
        return $db->prepare($query);
    }
    
    /**
     * @return bool
     */
    public function isConnected()
    {
        return ($this->db instanceof PDO);
    }
    
    /**
     * @ return PDO
     */
    final protected function getConnection()
    {
        if ($this->db === null)
        {//connect last-minute
            $this->db = new PDO(
                $this->dsn,
                $this->user,
                $this->pass,
                $this->attributes
                );
        }
        return $this->db;
    }
    
    public function closeConnection(){
        $this->db->close();
    }
}

