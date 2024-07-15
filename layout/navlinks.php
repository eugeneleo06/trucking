<?php
// nav_links.php
$nav_links = [
    ['url' => 'index.php', 'text' => 'List Harga'],
    ['url' => 'muat_bongkar.php', 'text' => 'Muat - Bongkar'],
    ['url' => 'mobil.php', 'text' => 'Mobil'],
    ['url' => 'vendor.php', 'text' => 'Vendor'],
];

if (isset($_SESSION['role']) && $_SESSION['role'] == 'MASTER') {
    $nav_links[] = ['url' => 'user.php', 'text' => 'User Management'];
    // Add more links as needed
}

?>
