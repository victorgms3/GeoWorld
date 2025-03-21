<?php
/**
 * Home Page
 *
 * PHP version 7
 *
 * @category  Page
 * @package   Application
 * @author    SIO-SLAM <sio@ldv-melun.org>
 * @copyright 2019-2021 SIO-SLAM
 * @license   http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link      https://github.com/sio-melun/geoworld
 */

?>
<?php  require_once 'header.php'; ?>
<?php
require_once 'inc/manager-db.php';
$continent = isset($_GET['continent']) ? $_GET['continent'] : 'Asia';
$desPays = getCountriesByContinent($continent);
?>

<main role="main" class="flex-shrink-0">

  <div class="container">
    <h1>Les pays en <?php echo $continent; ?> </h1>
    <div>
    <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
         <tr>
           <th>Drapeau</th>
           <th>Nom</th>
           <th>Population</th>
           <th>Region</th>
           <th>Capitale</th>
         </tr>
        </thead>
        <tbody>
          <?php
            foreach ($desPays as $pays) :?>
              <tr>
                <td> <?php $drapeau = strtolower($pays->Code2);
                  $source = "images/flag/$drapeau.png";
                  if (!file_exists($source)) {
                    $source = "images/flag/onu.png";
                  }?>          
                  <img src="<?php echo $source; ?>" alt="Drapeau de <?php echo $pays->Name; ?>">
                </td>
                <td> 
                  <a href="detailPays.php?id=<?php echo $pays->id ?>"><?php echo $pays->Name ?></a></td>
            <td> <?php echo $pays->Population ?></td>
            <td> <?php echo $pays->Region ?></td>
            <td> <?php if (getCapitale($pays->Capital) == Null) echo "No capitale";
             else echo getCapitale($pays->Capital)->Name?></td>
          </tr>
          <?php
            endforeach
          ?>
          </tbody>
     </table>
    </div>
  </div>
</main>

<?php
require_once 'javascripts.php';
require_once 'footer.php';
?>
