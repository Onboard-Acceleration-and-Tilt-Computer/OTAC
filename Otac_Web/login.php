<?php 
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=db_otac', 'root', '');
 
if(isset($_GET['login'])) {
    $email = $_POST['email'];
    $passwort = $_POST['passwort'];
    
    $statement = $pdo->prepare("SELECT * FROM tbl_user WHERE email = :email");
    $result = $statement->execute(array('email' => $email));
    $user = $statement->fetch();
        
    //Überprüfung des Passworts
    if ($user !== false && password_verify($passwort, $user['passwort'])) {
        $_SESSION['userid'] = $user['id'];
        header("Location:geheim/geheim.php");
        //die('Login erfolgreich. Weiter zu <a href="geheim.php">internen Bereich</a>');
    } else {
        $errorMessage = "E-Mail oder Passwort war ungültig<br>";
    }
    
}
?>
<!DOCTYPE html> 
<html> 
<head>
  <title>Login</title> 
    <link href="css/login.css" rel="stylesheet" />
</head> 
<body>
 
<?php 
if(isset($errorMessage)) {
    echo $errorMessage;
}
?>
<form class="box" action="?login=1" method="post">
    <div id="profiel"></div>
    <img src="bilder/user.png" alt="Selfhtml" width="100px" height="100px">
<input placeholder="eMail" type="email" size="40" maxlength="250" name="email"><br>
<input placeholder="Password" type="password" size="40"  maxlength="250" name="passwort"><br>
 
<input type="submit" value="Login">
</form> 
<div id="box">
      <nav>
        <ul id="nav_bar">
          <li id="register"><a href="registrieren.php">Registrieren</a></li>
        </ul>  
      </nav>
    </div>
    
<div id="box1"><h1></h1></div>  
</body>
</html>
