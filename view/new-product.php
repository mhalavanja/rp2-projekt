<?php require_once __SITE_PATH . '/view/_header.php';
if(isset($error) && $error === true) echo "<p>All the fields are required!</p>" ?>
<form method="post" action="<?php echo __SITE_URL . '/hotels/processNewHotel' ?>">
    <div>
        <label for="name">Name: </label>
        <input type="text" id="name" name="name">
    </div>
    <br>
    <div>
        <label for="description">Description: </label>
        <input type="text" id="description" name="description">
    </div>
    <br>
    <div>
        <label for="price">Price: </label>
        <input type="number" id="price" name="price">
    </div>
    <br>
    <button type="submit">Submit</button>
</form>
<?php require_once __SITE_PATH . '/view/_footer.php'; ?>
