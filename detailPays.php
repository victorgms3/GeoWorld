<?php require_once 'header.php'; 
require_once 'inc/manager-db.php';

if (isset($_GET['name']) && !empty($_GET['name'])) {
    $name = $_GET['name'];
    $pays = getPaysByName($name); 
    $idPays = $pays->id;
} elseif (isset($_GET['id']) && !empty($_GET['id'])) {
    $idPays = $_GET['id'];
    $pays = getDetailsPays($idPays);
} else {
    echo "Aucun pays trouvé.";
    exit;
}

$capital = getCapitale($pays->Capital);
$langues = getPercentLanguage($idPays);

// Traitement du formulaire de mise à jour
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    // Vérifiez si les champs sont vides et utilisez les valeurs existantes si nécessaire
    $population = !empty($_POST['population']) ? $_POST['population'] : $pays["Population"];
    $pnb = !empty($_POST['pnb']) ? $_POST['pnb'] : $pays["GNP"];
    $chef = !empty($_POST['chef']) ? $_POST['chef'] : $pays["HeadOfState"];
    $esperance = !empty($_POST['esperance']) ? $_POST['esperance'] : $pays["LifeExpectancy"];

    // Appeler la fonction pour mettre à jour les informations
    ajouterInformation($idPays, $population, $pnb, $chef, $esperance);

    // Recharger les données mises à jour
    $pays = getDetailsPays($idPays);
    echo "<p style='color: green;'>Les informations ont été mises à jour avec succès.</p>";
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
<body>
    <div class="container">
        <?php  $drapeau = strtolower($pays->Code2);  
        $source = "images/flag/$drapeau.png";
        if (!file_exists($source)) {
            $source = "images/flag/us.png";
        }?>
        <h1 class = "centrer"><?php echo $pays->Name; ?> <img src=<?php echo $source;?> alt="Drapeau de <?php echo $pays->Name; ?>"></h1>
        <table>
            <tr>
                <th>Code</th>
                <th>Continent</th>
                <th>Capitale</th>
                <th>Population</th>
                <th>Superficie</th>
            </tr>
            <tr>
                <td><?php echo $pays->Code?></td>
                <td><?php echo $pays->Continent?></td>
                <td><?php if ($capital == Null) echo "No capitale";
                    else echo $capital->Name?></td>
                <td><?php echo $pays->Population?></td>
                <td><?php echo $pays->SurfaceArea?></td>
            </tr>
        </table>
        <button class="btndetailPays" onclick="window.location.href='cityOfPays.php?id=<?php echo $idPays?>';">Voir les villes</button>
        <div class="details">
            <div class="langues">
                <h2>Langues parlées</h2>
                <table >
                    <tr>
                        <th>Nom</th>
                        <th>Pourcentage</th>
                    </tr>
                    <?php foreach ($langues as $test):?>
                    <tr>
                        <td><?php echo $test->Name?></td>
                        <td><?php echo $test->Percentage?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
            <div class="economiques">
                <h2>Données économiques et sociales</h2>
                <table>
                    <tr>
                        <td>Population</td>
                        <td><?php echo $pays->Population?> </td>
                    </tr>
                    <tr>
                        <td>PNB</td>
                        <td><?php echo $pays->GNP?></td>
                    </tr>
                    <tr>
                        <td>Chef d'état</td>
                        <td><?php echo $pays->HeadOfState?></td>
                    </tr>
                    <tr>
                        <td>Espérance de vie</td>
                        <td><?php echo $pays->LifeExpectancy?></td>
                    </tr>
                </table>
            </div>
            <div class="actualisees">
                <h2>Données actualisées (source Wikipédia)</h2>
                <form action="detailPays.php?id=<?php echo $idPays; ?>" method="POST">
                    <label for="population">Population:</label>
                    <input type="text" id="population" name="population" value="<?php echo $pays->Population; ?>"><br>
                    <label for="pnb">PNB:</label>
                    <input type="text" id="pnb" name="pnb" value="<?php echo $pays->GNP; ?>"><br>
                    <label for="chef">Chef d'état:</label>
                    <input type="text" id="chef" name="chef" value="<?php echo $pays->HeadOfState; ?>"><br>
                    <label for="esperance">Espérance de vie:</label>
                    <input type="text" id="esperance" name="esperance" value="<?php echo $pays->LifeExpectancy; ?>"><br>
                    <button class="btndetailPays" type="submit" name="update">Mettre à jour</button>
                    <button class="btndetailPays" type="submit" name="update_wikipedia">Voir les données actualisées (Wikipedia)</button>
                </form>
            </div>
        </div>
    </div>

<?php 
require_once "javascripts.php";
require_once "footer.php"
?>



</body>
</html>