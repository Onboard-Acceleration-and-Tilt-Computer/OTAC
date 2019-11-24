<?php
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=test', 'root', '');
if(!isset($_SESSION['userid'])) {
    header("Location:../login.php");
   //die('Bitte zuerst <a href="login.php">einloggen</a>');
}
 
//Abfrage der Nutzer ID vom Login
$userid = $_SESSION['userid'];

?>
<!doctype html>
<html lang="de">
<head>
    <meta charset-"UTF-8">
	<link href="../css/stylesave.css" rel="stylesheet" />
     <script src="plotly.min.js"></script>
	<title>OTAC-Computers</title>
    <link rel="icon" href="../bilder/man-woman-riding-scooter/1356.jpg">
    <form action="https://wiki.selfhtml.org/extensions/Selfhtml/show-request-params.php" method="post" target="_blank"></form>
</head>

<div id="boxreg">
      <nav>
        <ul id="nav_bar">
            <div id="logo"><a href="#"><img src="../bilder/man-woman-riding-scooter/1356.jpg" height="35" width="35" alt="Bild" /></a></div>
          <li id="logout"><a href="../logout.php">Logout</a></li>
        </ul>  
      </nav>
</div>    
    
    
    <br>
    <br>
  
    
    <div id ="titleleft">
        <h1>OTAC-Computers</h1></div>
<div id="leftbox">
    
    <div class="wrapper">
        <div id="chart"></div>
        <script>
            function getData() {
                return Math.random();
            }  
            Plotly.plot('chart',[{
                y:[getData()],
                type:'line'
            }]);
            
            var cnt = 0;
            setInterval(function(){
                Plotly.extendTraces('chart',{ y:[[getData()]]}, [0]);
                cnt++;
                if(cnt > 500) {
                    Plotly.relayout('chart',{
                        xaxis: {
                            range: [cnt-500,cnt]
                        }
                    });
                }
            },15);
        </script>
    </div>
<!-- 
    
$pdo = mysqli_connect("localhost", "root", "", "test");

$abfrage = "SELECT * FROM Buzz;" ;
$ergebnis = mysqli_query($pdo,$abfrage);
?>
<br>
    <table class="tabelle">
        <thead>
        <tr>
            <th>Fahrt</th>
            <th>Zeit</th>
            <th>Km/Luft</th>
            <th>Km Ø</th>
        </tr>
            </thead>
            <tbody>
    <php while($rows = mysqli_fetch_array($ergebnis)): ?>
    <tr>
        <td><php echo $rows['Buzz_ID']; ?></td>
        <td><php echo $rows['Zeit']; ?></td>
        <td><php echo $rows['Km/Luft']; ?></td>
        <td><php echo $rows['Km']; ?></td>
    </tr>
        <php endwhile; ?>
                
            </tbody>
    
</table></div>
    
    


    
        <div id ="titleright">
            <h1>Grafik</h1></div>
<div id="rightbox">
    </div>
    
<!--
<div id="box">
<div id="box1"> <img src="../bilder/iconfinder_key_1055040.png" height="200px" width="200px">     </div>
    <div id="box2"> <a href="../geheim/geheimmedia.php"><img src="../bilder/1055020-512.png" height="200px" width="200px"/></a> </div>
<div id="box3">  <img src="../bilder/iconfinder_arrow-down_1055120%2019.11.00.png" height="200px" width="200px">   </div>
<div id="box4">  <img src="../bilder/iconfinder_contacts_1055082.png" height="200px" width="200px">   </div>   
</div>

<div id="music">
<!--<iframe src="https://open.spotify.com/embed/user/lvss%21e/playlist/1pE0w5F1h2mEhXLOzSgp4u" width="309" height="80" frameborder="0" allowtransparency="true" allow="encrypted-media"></iframe>
</div>-->
    