<?php
$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
  die(json_encode(["message" => "DB Connection failed"]));
}
?>
