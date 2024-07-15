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
require 'api/get_kota.php';

?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Kota</h1>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body" style="padding-top:3dvh;">
              <!-- Table with stripped rows -->
              <table class="table datatable">
                <thead>
                  <tr>
                    <th>Nama Kota</th>
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
                      echo '<a href="api/upsert_kota.php?q='.$v['secure_id'].'">Edit</a>';
                      echo '|'; 
                      echo '<a href="api/delete_kota.php?q='.$v['secure_id'].'">Delete</a>';
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
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>NiceAdmin</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
      <!-- All the links in the footer should remain intact. -->
      <!-- You can delete the links only if you purchased the pro version. -->
      <!-- Licensing information: https://bootstrapmade.com/license/ -->
      <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
      Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>