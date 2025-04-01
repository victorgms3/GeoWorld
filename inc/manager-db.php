<?php
/**
 * Ce script est composé de fonctions d'exploitation des données
 * détenues pas le SGBDR MySQL utilisées par la logique de l'application.
 *
 * C'est le seul endroit dans l'application où a lieu la communication entre
 * la logique métier de l'application et les données en base de données, que
 * ce soit en lecture ou en écriture.
 *
 * PHP version 7
 *
 * @category  Database_Access_Function
 * @package   Application
 * @author    SIO-SLAM <sio@ldv-melun.org>
 * @copyright 2019-2021 SIO-SLAM
 * @license   http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link      https://github.com/sio-melun/geoworld
 */

/**
 *  Les fonctions dépendent d'une connection à la base de données,
 *  cette fonction est déportée dans un autre script.
 */

require_once 'connect-db.php';

/**
 * Obtenir la liste de tous les continents
 *
 * @return array tableau de noms de continents
 */

function getContinents()
{
    global $pdo;
    $query = 'SELECT DISTINCT Continent FROM Country;';
    $result = $pdo->query($query);
    return $result->fetchAll(PDO::FETCH_COLUMN);
}

/**
 * Obtenir la liste de tous les pays référencés d'un continent donné
 *
 * @param string $continent le nom d'un continent
 * 
 * @return array tableau d'objets (des pays)
 */

function getCountriesByContinent($continent)
{
    // pour utiliser la variable globale dans la fonction
    global $pdo;
    $query = 'SELECT * FROM Country WHERE Continent = :cont;';
    $prep = $pdo->prepare($query);
    // on associe ici (bind) le paramètre (:cont) de la req SQL,
    // avec la valeur reçue en paramètre de la fonction ($continent)
    // on prend soin de spécifier le type de la valeur (String) afin
    // de se prémunir d'injections SQL (des filtres seront appliqués)
    $prep->bindValue(':cont', $continent, PDO::PARAM_STR);
    $prep->execute();
    // var_dump($prep);  pour du debug
    // var_dump($continent);

    // on retourne un tableau d'objets (car spécifié dans connect-db.php)
    return $prep->fetchAll();
}

/**
 * Obtenir la liste des pays
 *
 * @return liste d'objets
 */

function getAllCountries()
{
    global $pdo;
    $query = 'SELECT * FROM Country;';
    return $pdo->query($query)->fetchAll();
}

function getCapitale($countryId){
    global $pdo;
    $query = 'SELECT Name FROM City WHERE id = :id;';
    $prep = $pdo->prepare($query);
    $prep->bindValue(':id', $countryId, PDO::PARAM_INT);
    $prep->execute();
    return $prep->fetch();
}

function getPays($id)  {
    global $pdo;
    $query = 'SELECT Name FROM `Country` WHERE Country = :id;';
    $prep = $pdo->prepare($query);
    $prep->bindValue(':id', $idPays, PDO::PARAM_INT);
    $prep->execute();
    return $prep->fetch();
}

function getDetailsPays($id) {
    global $pdo;
    $query = 'SELECT * FROM Country WHERE id = :id;';
    $prep = $pdo->prepare($query);
    $prep->bindValue(':id', $id, PDO::PARAM_INT);
    $prep->execute();
    return $prep->fetch();
}

function getPercentLanguage($idPays)  {
    //On recupère les diffèrentes pourcentages de langue parle dans un pays 
    global $pdo;
    $query = 'SELECT Percentage, Name FROM `CountryLanguage`,`Language` WHERE CountryLanguage.idLanguage = Language.id  AND idCountry = :id ORDER BY Percentage DESC ;';
    $prep = $pdo->prepare($query);
    $prep->bindValue(':id', $idPays, PDO::PARAM_INT);
    $prep->execute();
    return $prep
    ->fetchAll();
}
function getCity($idPays){
    global $pdo;
    $query = 'SELECT Name, District,Population  FROM `City` WHERE idCountry = :id ORDER BY Population DESC;';
    $prep = $pdo->prepare($query);
    $prep->bindValue(':id', $idPays, PDO::PARAM_INT);
    $prep->execute();
    return $prep->fetchAll();
}

function ajouterInformation($idPays, $population, $pnb, $chefEtat, $esperanceDeVie) {
    global $pdo;
    $population = (int) $population;
    $requete = "UPDATE Country SET Population = :population, GNP = :pnb, HeadOfState = :chefEtat, LifeExpectancy = :esperance WHERE id = :id";
    try {
        $prep = $pdo->prepare($requete);
        $prep->bindValue(':population', $population, PDO::PARAM_INT);
        $prep->bindValue(':pnb', $pnb, PDO::PARAM_STR);
        $prep->bindValue(':chefEtat', $chefEtat, PDO::PARAM_STR);
        $prep->bindValue(':esperance', $esperanceDeVie, PDO::PARAM_STR);
        $prep->bindValue(':id', $idPays, PDO::PARAM_INT);
        $prep->execute();
    } catch (Exception $e) {
        die("Erreur dans la requête : " . $e->getMessage());
    }
}

function getPaysByName($name)  {
    global $pdo;
    $query = 'SELECT * FROM Country WHERE Name = :name;';
    $prep = $pdo->prepare($query);
    $prep->bindValue(':name', $name, PDO::PARAM_STR);
    $prep->execute();
    return $prep->fetch();
}












// function getWikipediaData($nomPays) {
//     $url = "https://fr.wikipedia.org/w/api.php?action=query&prop=extracts&titles=$nomPays&format=json&exintro=1";
//     $response = @file_get_contents($url);
//     if ($response === FALSE) {
//         return null;
//     }
//     $data = json_decode($response, true);
//     if (isset($data['query']['pages'])) {
//         $pages = $data['query']['pages'];
//         foreach ($pages as $page) {
//             if (isset($page['extract'])) {
//                 return $page['extract']; // Retourner l'extrait
//             }
//         }
//     }

//     return null; // Retourner null si aucune donnée n'est trouvée
// }
    

    // A verifier pour mettre a jour les données grace a wikipedia