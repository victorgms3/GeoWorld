<?php
require_once "header.php";
require_once "manager-db.php";
if (isset($_GET['id']) && !empty($_GET['id']) ){
    $idPays = $_GET['id'];
    $pays = getDetailsPays($idPays);
  }
  else{
    echo "Nul";
  }
?>
?>

