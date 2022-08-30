<?php
$servername   = '';
$username     = '';
$password     = '';
$NAME_DB      = '';
$NAME_DB_OLTP = 'NOME_BANCO_OLTP';

$conn = new mysqli($servername, $username, $password, $NAME_DB);
if (!$conn) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->set_charset('utf8');
