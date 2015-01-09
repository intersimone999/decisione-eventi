<?php
require_once "../config.php";
require_once ROOT_DIR . "/core/ChatControl.php";

//{"messages" : [{"author": "Simone", "message": "Ciao a tutti!"}, {"author": "AAA", "message": "Ciao a tutti!"}]}

session_start();

if (!isset($_GET['message']) || !isset($_SESSION['user']))
	die("ERROR");

$message = $_GET['message'];

$control = new ChatControl();
$result = $control->sendMessages($_SESSION['user'], $message);

if (!$result)
	die("ERROR");

$time = round(microtime(true) * 1000);
$resdata['author'] = $_SESSION['user']->getName();
$resdata['message'] = $message;
$resdata['time'] = date('Y-m-d H:i:s',$time);

echo "{\"messages\" : [" . json_encode($resdata) . "], \"time\" : $time}";
?>
