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
    
    if (isset($_POST['username']))
    {
        $username = $_POST['username'];
        $password = $_POST['password'];
      
        $prepared_statement = $db->db->prepare("SELECT * FROM users WHERE username = :username AND password = :password");
        $prepared_statement->bindValue(':username', $username, PDO::PARAM_STR);
        $prepared_statement->bindValue(':password', $password, PDO::PARAM_STR);      
        $prepared_statement->execute();
        
        $user = $prepared_statement->fetch();
    }
    
} catch (Exception $e) {
    var_dump($e);
}

    if (isset($_GET['myname']))
    {
        $myname = $_GET['myname'];
    }
    
    if (isset($_POST['message']))
    {
        $message = strip_tags($_POST['message']);
        
        $prepared_statement = $db->db->prepare("INSERT INTO messages (message) values (:message)");
        $prepared_statement->bindValue(':message', $message, PDO::PARAM_STR);
        $prepared_statement->execute();
        
        // $db->db->exec("INSERT INTO messages (message) VALUES ('$message')");
    }
    
    // Retrieve messages
    $messagesStatement = $db->db->query('SELECT * FROM messages');
    $messages = $messagesStatement->fetchAll();


?>

<!doctype>
<body>
    <h1>Safe</h1>
    <?php
        
        if (isset($user))
        {
            if ($user)
            {
                echo "<p>You're now logged in.";
            }
            else
            {
                echo '<p>Invalid login details.';
            }
        }
        
        if (isset($myname))
        {
            $outputname = preg_replace("/[^a-zA-Z0-9]+/", "", $myname);
            echo '<p>Your name is:', $outputname;

        }
        
    ?>
    <form method="post">
        <input type="text" name="username" placeholder="Username">
        <input type="password" name="password" placeholder="Password">
        <button type="submit">Login</button>
    </form>
    
    <form method="get">
        <input type="text" name="myname" placeholder="My name">
        <button type="submit">Say my name!</button>
    </form>
    
    <h2>Safe message form</h2>
    <!-- XSS protected register form -->
    <form method="post">
        <textarea name="message" cols="40" rows="10"></textarea>
        <button type="submit" style="font-size:24px;">Ja hoor. Plaatst u aub mijn bericht</button>
    </form>
    
    <h2>Messages</h2>
    <?php foreach ($messages as $m) : ?>
    <?php echo strip_tags($m['message']); ?>
    <hr>
    <?php endforeach; ?>
    
</body>