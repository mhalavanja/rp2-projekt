<nav>
    <ul id="menu">
        <li><a href="<?php echo __SITE_URL; ?>/hotels">Visited hotels (my products)</a></li>
        <li><a href="<?php echo __SITE_URL; ?>/hotels/ShoppingHistory">Visited hotels (shopping hitory)</a></li>
        <li><a href="<?php echo __SITE_URL; ?>/search">Search htoels</a></li>
        <li <?php if (!$_SESSION["user"]->getIs_admin()) echo "hidden"?> ><a href="<?php echo __SITE_URL; ?>/hotels/newHotel">Add new information about hotel</a></li>
        <li><a href="<?php echo __SITE_URL; ?>/login/processLogout">Logout</a></li>
    </ul>
</nav>