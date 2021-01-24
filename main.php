<!DOCTYPE html>
<html>
  <head>
      <meta charset="utf-8">
      <title>Exemple de lectura de dades a MySQL</title>
      <style>
          table,td {
              border: 1px solid black;
              border-spacing: 0px;
          }
      </style> 
  </head>
  
  <body>
    <h1>Exemple de lectura de dades a MySQL</h1>

    <?php
      try {
        $hostname = "localhost";
        $dbname = "world";
<<<<<<< HEAD
        $username = "exercises";
=======
        $username = "root";
>>>>>>> aec7379c52f08a5ce88d6b46695b7939efed8cb1
        $pw = "";
        $pdo = new PDO ("mysql:host=$hostname;dbname=$dbname","$username","$pw");
      } catch (PDOException $e) {
        echo "Failed to get DB handle: " . $e->getMessage() . "\n";
        exit;
      }
      $continentsQuery = $pdo->prepare("SELECT distinct(Continent) FROM country;");
      $continentsQuery->execute();
      $continent = $continentsQuery->fetch();
    ?>

    <form action='main.php' method='POST'>
      <label>Continent: </label>
      <select name='continent'>
      <?php    
        while ( $continent ) {
          echo "<option name='continent' value='" .$continent['Continent']."'>".$continent['Continent']. "</option>";
          $continent = $continentsQuery->fetch();
        }
        unset($continentsQuery);
      ?>
      </select><br><br>
      <input type='submit' name='Send' value='Send'>
      <br><br>
    </form>

    <?php       
      if(isset($_POST["continent"])) {
          $continent = $_POST["continent"];
          $countryQuery = $pdo->prepare("SELECT name, population FROM country WHERE continent = '$continent'"); 
          $countryQuery->execute();
          $countryRow = $countryQuery->fetch(); 
          
        echo "<table><thead><td colspan='4' align='center' bgcolor='cyan'>Països de:  $continent</td></thead>";
        echo "<tr><th>Pais</th><th>Població</th></tr>";

      while($countryRow){
          echo "\t\t<td>".$countryRow["name"]."</td>";
          echo "\t\t<td>".$countryRow["population"]."</td>\n";
          echo "\t</tr>\n";
          $countryRow = $countryQuery->fetch(); 
          }

      unset($countryQuery);

      $populationQuery = $pdo->prepare("SELECT SUM(population) AS 'poblacio' FROM country WHERE continent = '$continent';"); 
      $populationQuery->execute();
      $populationRow = $populationQuery->fetch();

      echo "<tr><th>Total de població: </th>";
      
      while($populationRow){
          echo "\t\t<td>" .$populationRow["poblacio"]. "</td>";
          echo "\t</tr>\n";
          $populationRow = $populationQuery->fetch();
      }
      unset($pdo);
      unset($populationQuery);
      }
    ?>
</body>
</html>
