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
</body>