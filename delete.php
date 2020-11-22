<?php
require 'config/config.php';

if (empty($_SESSION['user_id'])) {
    header('Location: index.php');
  } 
session_start();
session_destroy();
$stmt=$pdo->prepare("DELETE FROM users WHERE id=".$_GET['id']);
$stmt->execute();


header('location: index.php');

?>