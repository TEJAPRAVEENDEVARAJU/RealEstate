<?php
$conn = new mysqli("sql200.infinityfree.com", "if0_39282857", "G6wDbAohtp4I", "if0_39282857_realestate");
if ($conn->connect_error) {
  die(json_encode(["message" => "DB Connection failed"]));
}
?>
