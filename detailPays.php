<?php require_once 'header.php'; ?>
<?php
require_once 'inc/manager-db.php';
if (isset($_GET['id']) && !empty($_GET['id']) ){
    $idPays = $_GET['id'];
    $pays = getDetailsPays($idPays);
    $capital = getCapitale($pays["Capital"]);
  }
  else{
    echo "Nul";
  }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails du Pays <?php echo $pays["Name"] ?></title>
    <link href="css/custom.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <?php  $drapeau = strtolower($pays["Code2"]); ?>
        <h1><?php echo $pays["Name"]; ?> <img src="images/drapeau/<?php echo $drapeau; ?>.png" alt="Drapeau de <?php echo $pays["Name"]; ?>"></h1>
        <table>
            <tr>
                <th>Code</th>
                <th>Continent</th>
                <th>Capitale</th>
                <th>Population</th>
                <th>Superficie</th>
            </tr>
            <tr>
                <td><?php echo $pays["Code"]?></td>
                <td><?php echo $pays["Continent"]?></td>
                <td><?php echo $capital->Name;?></td>
                <td><?php echo $pays["Population"]?></td>
                <td><?php echo $pays["SurfaceArea"]?></td>
            </tr>
        </table>
        <button>Voir les villes</button>
        <div class="details">
            <div class="langues">
                <h2>Langues parlées</h2>
                <table>
                    <tr>
                        <th>Nom</th>
                        <th>Pourcentage</th>
                    </tr>
                    <tr>
                        <td>French</td>
                        <td>93.6</td>
                    </tr>
                    <tr>
                        <td>Arabic</td>
                        <td>2.5</td>
                    </tr>
                    <tr>
                        <td>Portuguese</td>
                        <td>1.2</td>
                    </tr>
                    <tr>
                        <td>Spanish</td>
                        <td>0.4</td>
                    </tr>
                    <tr>
                        <td>Italian</td>
                        <td>0.4</td>
                    </tr>
                    <tr>
                        <td>Turkish</td>
                        <td>0.4</td>
                    </tr>
                </table>
            </div>
            <div class="economiques">
                <h2>Données économiques et sociales</h2>
                <table>
                    <tr>
                        <td>Population</td>
                        <td>59,225,700</td>
                    </tr>
                    <tr>
                        <td>PNB</td>
                        <td>1,424,285.00</td>
                    </tr>
                    <tr>
                        <td>Chef d'état</td>
                        <td>Jacques Chirac</td>
                    </tr>
                    <tr>
                        <td>Espérance de vie</td>
                        <td>78.8</td>
                    </tr>
                </table>
            </div>
            <div class="actualisees">
                <h2>Données actualisées (source Wikipédia)</h2>
                <form>
                    <label for="population">Population:</label>
                    <input type="text" id="population" name="population"><br>
                    <label for="pnb">PNB:</label>
                    <input type="text" id="pnb" name="pnb"><br>
                    <label for="chef">Chef d'état:</label>
                    <input type="text" id="chef" name="chef"><br>
                    <label for="esperance">Espérance de vie:</label>
                    <input type="text" id="esperance" name="esperance"><br>
                    <button type="submit">Mettre à jour</button>
                </form>
                <button>Voir les données actualisées (wikipedia):</button>
                <button>Espérance</button>
                <button>Chef</button>
                <button>PNB</button>
                <button>Population</button>
            </div>
        </div>
    </div>

<?php require_once "javascripts.php" ?>

<hr />
<footer class="footer mt-auto py-3">
  <div class="container">
    <span class="text-muted">&copy;2023-2024 SIO SLAM MyWebApp</span>
  </div>
</footer>

</body>
</html>