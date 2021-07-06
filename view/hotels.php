<?php require_once __SITE_PATH . '/view/_header.php';
if(!isset($hotels)) echo "<h2>    Nema hotela s traženim parametrima!</h2>"
?>
<pre>
    <?php print_r($hotels); ?>
<pre>
<?php require_once __SITE_PATH . '/view/_footer.php'; ?>
