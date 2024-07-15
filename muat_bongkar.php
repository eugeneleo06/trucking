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
require 'api/get_muat_bongkar.php';

?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Muat - Bongkar</h1>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body" style="padding-top:3dvh;">
              <a href="upsert_muat_bongkar.php" class="btn btn-primary" style="margin-bottom:20px;">Tambah Data</a>
              <!-- Table with stripped rows -->
              <table class="table datatable">
                <thead>
                  <tr>
                    <th>Nama</th>
                    <?php if ($_SESSION['role'] != "MEMBER"):?>
                    <th>Action</th>
                    <?php endif;?>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach($kota as $v):
                    echo '<tr>';
                      echo '<td>&nbsp;&nbsp;'.$v['nama'].'</td>';
                      if ($_SESSION['role'] != "MEMBER"):
                      echo '<td>';
                      echo '<a style="text-decoration:none;color:black;" href="upsert_muat_bongkar.php?q='.$v['secure_id'].'"><i class="fas fa-lg fa-pencil-alt"></i></a>';
                      echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'; 
                      echo '<a data-secure-id="'.$v['secure_id'].'"><i class="fas fa-lg fa-trash-alt"></i></a>';
                      echo '</td>';
                      endif;
                    echo '</tr>';
                  endforeach;
                  ?>
                </tbody>
              </table>
              <!-- End Table with stripped rows -->

            </div>
          </div>

        </div>
      </div>
    </section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <?php
  require 'layout/footer.php';