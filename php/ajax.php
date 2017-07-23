<?php
require_once "chatif.php";
$chat = new Chat();
if (!empty($_GET["method"])){
    $functionname = $_GET["method"];
}
else {
    $functionname = $_POST["method"];
}
$chat->$functionname();
?>