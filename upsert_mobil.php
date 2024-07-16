<?php
ob_start();
session_start();

if (!isset($_SESSION["username"])) {
  header('Location: login.php');
  exit;
}

if ($_SESSION['role'] == "MEMBER") {
    header('Location: mobil.php');
    exit;
}

require 'layout/header.php';
require 'layout/navbar.php';
require 'layout/sidebar.php';
require 'api/detail_mobil.php';

?>
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Mobil</h1>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <!-- General Form Elements -->
              <form method="post" action="api/upsert_mobil.php">
                <div class="row mb-3">
                  <label for="inputText" class="col-sm-2 col-form-label">Nama</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="nama" value="<?php if(isset($mobil['nama'])){echo $mobil['nama'];}?>">
                  </div>
                </div>

                <div class="row mb-3">
                  <label class="col-sm-2 col-form-label"></label>
                  <div class="col-sm-10">
                    <input type="hidden" name="secure_id" value='<?php if(isset($_GET['q'])) {echo $_GET['q'];} ?>'>
                      <?php if (isset($_SESSION['error'])) : ?>
                          <p style="color: red;"><?php echo $_SESSION['error']; ?></p>
                      <?php endif; ?>
                      <?php
                      unset($_SESSION['error']); 
                      ?>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                  </div>
                </div>

              </form><!-- End General Form Elements -->

            </div>
          </div>

        </div>
      </div>
    </section>

  </main><!-- End #main -->
  <script src="vendor/jquery/jquery.min.js"></script>

  <!-- ======= Footer ======= -->
  <?php
  require 'layout/footer.php';