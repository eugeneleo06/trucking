<?php
ob_start();
session_start();

if (!isset($_SESSION["username"])) {
  header('Location: login.php');
  exit;
}

require 'layout/header.php';
require 'layout/navbar.php';
require 'layout/sidebar.php';

?>

<main class="main" id="main">
    <div class="pagetitle">
      <h1>List Harga</h1>
      <!-- <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav> -->
    </div><!-- End Page Title -->
</main>
<script src="vendor/jquery/jquery.min.js"></script>

<?php
require 'layout/footer.php';