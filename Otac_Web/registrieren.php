<?php 
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=db_otac', 'root', '');
?>
<!DOCTYPE html> 
<html> 
<head>
  <title>Registrierung</title>   
    <link href="css/regisstrieren.css" rel="stylesheet" /> 
</head> 
<body>
 
<?php
$showFormular = true; //Variable ob das Registrierungsformular anezeigt werden soll
 
if(isset($_GET['register'])) {
    $error = false;
    $email = $_POST['email'];
    $passwort = $_POST['passwort'];
    $passwort2 = $_POST['passwort2'];
  
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo 'Bitte eine gültige E-Mail-Adresse eingeben<br>';
        $error = true;
    }     
    if(strlen($passwort) == 0) {
        echo 'Bitte ein Passwort angeben<br>';
        $error = true;
    }
    if($passwort != $passwort2) {
        echo 'Die Passwörter müssen übereinstimmen<br>';
        $error = true;
    }
    
    //Überprüfe, dass die E-Mail-Adresse noch nicht registriert wurde
    if(!$error) { 
        $statement = $pdo->prepare("SELECT * FROM tbl_user WHERE email = :email");
        $result = $statement->execute(array('email' => $email));
        $user = $statement->fetch();
        
        if($user !== false) {
            echo 'Diese E-Mail-Adresse ist bereits vergeben<br>';
            $error = true;
        }    
    }
    
    //Keine Fehler, wir können den Nutzer registrieren
    if(!$error) {    
        $passwort_hash = password_hash($passwort, PASSWORD_DEFAULT);
        
        $statement = $pdo->prepare("INSERT INTO tbl_user (email, passwort) VALUES (:email, :passwort)");
        $result = $statement->execute(array('email' => $email, 'passwort' => $passwort_hash));
        
        if($result) {        
            header("Location:login.php");
            //echo 'Du wurdest erfolgreich registriert. <a href="login.php">Zum Login</a>';
            $showFormular = false;
        } else {
            echo 'Beim Abspeichern ist leider ein Fehler aufgetreten<br>';
        }
    } 
}
 
if($showFormular) {
?>
 
<form class="box"action="?register=1" method="post">
    <div id="profiel"></div>
    <img src="bilder/user.png" alt="Selfhtml" width="100px" height="100px">
<input type="email" size="40" maxlength="250" placeholder="eMail" name="email"><br>
 
<input type="password" size="40"  maxlength="250" placeholder="Password" name="passwort"><br>
 
<input type="password" size="40" maxlength="250" placeholder="Password Wiederholen"name="passwort2"><br><br>
 
<input type="submit" value="Abschicken">
</form>
<div id="boxreg">
      <nav>
        <ul id="nav_bar">
          <li id="login"><a href="login.php">Login</a></li>
        </ul>  
      </nav>
    </div>
    
<div id="box1"><h1></h1></div> 
 
<?php
} //Ende von if($showFormular)
?>
 
</body>
</html>