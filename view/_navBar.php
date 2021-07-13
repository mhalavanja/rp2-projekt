<style>
.navbar-nav .nav-item:hover .nav-link {
    background-color: SkyBlue;
    color: white;
}
</style>

<?php if(isset ($_SESSION["user"])) {?>
<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #e3f2fd;">
    <div class="container-fluid ">
    <ul class="navbar-nav me-auto mb-2 mb-lg-0 nav-fill w-100" id="menu">
        <li class="nav-item"><a class="nav-link" href="<?php echo __SITE_URL; ?>/hotels/bookings">Bookings</a></li>
        <li class="nav-item"><a class="nav-link" href="<?php echo __SITE_URL; ?>/hotels/userBookings">Your bookings</a></li>
        <li class="nav-item"><a class="nav-link" href="<?php echo __SITE_URL; ?>/user">Profile</a></li>
        <li class="nav-item" <?php if ($_SESSION["user"]->getisAdmin() == null) echo "hidden"?> >
            <a class="nav-link" href="<?php echo __SITE_URL; ?>/hotels/info">Add new information about hotel</a>
        </li>
    </ul>
    </div>
</nav>
<?php } ?>