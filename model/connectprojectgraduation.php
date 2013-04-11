<?php
$dsn = 'mysql:host=localhost;dbname=projectgraduation';
$username = 'root';
$password = '';
$options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING);

try {
    $db = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    $error_message = $e->getMessage();
     include 'views/header.php'; 
     ?>
     <div id="content">
          <h1>Database Error</h1>
          <p>The database server seems to be down temporarily.</p>
          <p>This doesn't usually last long. Try again in a minute or two.</p>
          <p>Error message: <?php echo $error_message; ?></p>
          <p>&nbsp;</p>
     </div><!-- end content -->

     <?php
     include 'views/footer.php';    
     exit;
}//end catch
?>