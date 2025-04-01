<?php require_once 'header.php'; 
require_once 'inc/manager-db.php';
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $idPays = $_GET['id'];
    $pays = getDetailsPays($idPays);
}
else {
    echo "Aucun pays trouvé.";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails du Pays <?php echo $pays->Name ?></title>
    <link href="css/custom.css" rel="stylesheet">
    <link href="detailPays.css" rel="stylesheet">
</head>
    <div class="container">
        <?php  $drapeau = strtolower($pays->Code2);  
        $source = "images/flag/$drapeau.png";
        if (!file_exists($source)) {
            $source = "images/flag/us.png";
        }?>
        <h1 class = "centrer"><?php echo $pays->Name; ?> <img src=<?php echo $source;?> alt="Drapeau de <?php echo $pays->Name; ?>"></h1>