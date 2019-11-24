<html>
<
<?php
define('BROKER', 'localhost');
define('PORT', 1883);
define('CLIENT_ID', "pubclient_" + getmypid());

$client = new Mosquitto\Client(CLIENT_ID);
$client->onConnect('connect');
$client->onDisconnect('disconnect');
$client->onSubscribe('subscribe');
$client->onMessage('message');
$client->connect(BROKER, PORT, 60);
$client->subscribe('#', 1); // Subscribe to all messages

$client->loopForever();

function connect($r) {
        echo "Received response code {$r}\n";
}

function subscribe(){
}

function message($messages) { 
 printf("topic %s with payload:\n%s\n", $messages->topic, $messages->payload);
}


function disconnect() {
        echo "Disconnected cleanly\n";
}

    while ($messages >= 0){
        echo $message;
    }
    
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



echo json_encode(massage);
?>
