<?php
    class databaseCon{
    private $host = 'localhost';
    private $user = 'root';
    private $pass = 'root';
    private $dbName = 'oopBlog';

    private $dbh;
    private $error;
    private $stmt;

    public function __construct(){
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbName;
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );

        try{
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
        }
        catch (PDOException $e){
            $this->error = $e->getMessage();
        }
        echo $this->error;
    }

    public function query($query){
        $this->stmt = $this->dbh->prepare($query);
    }

    public function bind($param, $value, $type = null){
        if(is_null($type)){
            switch(true){
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param,$value,$type);
    }

    public function execute(){
        return $this->stmt->execute();
    }

    public function resultSet(){
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function lastInsertID(){
        return $this->dbh->lastInsertId();
    }

    public function resultSetSingular(){
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

}