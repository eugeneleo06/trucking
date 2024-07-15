<?php
// nav_links.php
$nav_links = [
    ['url' => 'index.php', 'text' => 'Katalog'],
    ['url' => 'kota.php', 'text' => 'Kota'],
    ['url' => 'mobil.php', 'text' => 'Mobil'],
    ['url' => 'vendor.php', 'text' => 'Vendor'],
];

if (isset($_SESSION['role']) && $_SESSION['role'] == 'MASTER') {
    $nav_links[] = ['url' => 'user.php', 'text' => 'User Management'];
    // Add more links as needed
}

?>
