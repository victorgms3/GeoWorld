<?php
require_once "header.php";
require_once 'inc/manager-db.php';
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $idPays = $_GET['id'];
    $pays = getDetailsPays($idPays);
    $villes = getCity($idPays);
} else {
    echo "Nul";
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails du Pays <?php echo $pays->Name; ?></title>
    <link href="css/custom.css" rel="stylesheet">
    <link href="css/detailPays.css" rel="stylesheet">
</head>
<body>
<main role="main" class="flex-shrink-0">
    <div class="container">
    <h1 class = "text-center">Villes</h1>
        <h1 class = "text-center">..........</h1>
        <div>
        <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Région</th>
                        <th>Population</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($villes as $ville):?>
                      <tr>
                        <td><?php echo $ville->Name?></td>
                        <td><?php echo $ville->District?></td>
                        <td><?php echo $ville->Population?></td>
                      </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>
<?php require_once "javascripts.php"; ?>
<?php require_once "footer.php"; ?>
</body>
</html>