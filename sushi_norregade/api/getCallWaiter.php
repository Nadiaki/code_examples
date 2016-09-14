<?php
header('Content-Type: application/json');
require_once("../db.php");
$calls = processWaiterCalls();
echo json_encode($calls);