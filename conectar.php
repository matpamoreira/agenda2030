<?php

$servername   = "fiscalize.cg5foykmezxr.us-west-2.rds.amazonaws.com";
$username     = "agenda2030";
$password     = "pnud4mti";
$NAME_DB      = "agenda2030";
$NAME_DB_OLTP = "NOME_BANCO_OLTP";

$conn = new mysqli($servername, $username, $password, $NAME_DB);
if (!$conn) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->set_charset('utf8');