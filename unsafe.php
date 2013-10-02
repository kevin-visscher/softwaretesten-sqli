<?php
    // http://zetcode.com/db/sqlitephp/
    ini_set('display_errors',1); 
    error_reporting(E_ALL);

    $db = new PDO("sqlite:db.sqlite");
    
    $db->exec(file_get_contents("create_tables.sql"));
    $db->exec(file_get_contents("insert.sql"));
    
    if (isset($_POST['username']))
    {
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        $statement = $db->query(
            "select * " . 
            "from users " . 
            "where username = '" . $username . "' " .
            "and password = '" . $password . "'"
        );
        
        $user = $statement->fetch();
    }
  
    if (isset($_GET['myname']))
    {
        $myname = $_GET['myname'];
    }
    
    if (isset($_POST['message']))
    {
        $message = $_POST['message'];
        
        $db->exec("INSERT INTO messages (message) VALUES ('$message')");
    }
    
    // Retrieve messages
    $messagesStatement = $db->query('SELECT * FROM messages');
    $messages = $messagesStatement->fetchAll();
    
?>

<!doctype>
<body>
    <h1>Unsafe</h1>
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
            echo '<p>Your name is:', $myname;
        }
        
        if (isset($registered))
        {
            echo 'You are now registered. Please login';
        }
    ?>
    
    <h2>Unsafe login form</h2>
    <!-- Unsafe login form (SQL Injections) -->
    <form method="post">
        <input type="text" name="username" placeholder="Username">
        <input type="password" name="password" placeholder="Password">
        <button type="submit">Login</button>
    </form>
    
    <h2>Unsafe form that accepts html</h2>
    <!-- Unsafe form that accepts HTML chars -->
    <form method="get">
        <input type="text" name="myname" placeholder="My name">
        <button type="submit">Say my name!</button>
    </form>
    
    <h2>Unsafe message form</h2>
    <!-- XSS vunlerable register form -->
    <form method="post">
        <textarea name="message" cols="40" rows="10"></textarea>
        <button type="submit" style="font-size:24px;">Ja hoor. Plaatst u aub mijn bericht</button>
    </form>
    
    <h2>Messages</h2>
    <?php foreach ($messages as $m) : ?>
    <?php echo $m['message']; ?>
    <hr>
    <?php endforeach; ?>
</body>