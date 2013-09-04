<?php
ini_set('display_errors',1); 
error_reporting(E_ALL);
class DB {
    
    public $db;
    
    function __construct() {
        $this->db = new PDO('sqlite:db.sqlite');
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
      
    public function fillDb() {
        
        try{
        
            $contents_of_sql_create_script = file_get_contents('create_tables.sql');
            $this->db->exec($contents_of_sql_create_script);
            
            $contents_of_sql_insert_script = file_get_contents('insert.sql');
            $this->db->exec($contents_of_sql_insert_script);
            
        }catch(Exception $e) {
            print_r($e->getMessage());
        } 
    }  
     
}

$db = new DB();

$db->fillDb();

try{
    
    $prepared_statement = $db->db->prepare("SELECT * FROM users WHERE username = :username AND password = :password");
    $prepared_statement->bindValue(':username', 'jacko', PDO::PARAM_STR);
    $prepared_statement->bindValue(':password', 'qwerty', PDO::PARAM_STR);
    
    $prepared_statement->execute();
    
    foreach($prepared_statement->fetchAll() as $row) {
        var_dump($row);
    }
    
} catch (Exception $e) {
    var_dump($e);
}




?>