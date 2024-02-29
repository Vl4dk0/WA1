<?php
$conn = new mysqli("localhost", "root", "", "wa1");
if ($conn->connect_error) {
    die("chyba pri nadviazovani s databazou" . $conn->connect_error);
}
?>