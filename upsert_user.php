<?php
ob_start();
session_start();

if (!isset($_SESSION["username"])) {
  header('Location: login.php');
  exit;
}

if ($_SESSION['role'] == "MEMBER" || $_SESSION['role' == "ADMIN"]) {
    header('Location: user.php');
    exit;
}

require 'layout/header.php';
require 'layout/navbar.php';
require 'layout/sidebar.php';
require 'api/detail_user.php';

?>
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>User</h1>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <!-- General Form Elements -->
              <form method="post" action="api/upsert_user.php">
                <div class="row mb-3">
                  <label for="inputText" class="col-sm-2 col-form-label">Username</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="username" value="<?php if(isset($user['username'])){echo $user['username'];}?>">
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="inputText" class="col-sm-2 col-form-label">Role</label>
                  <div class="col-sm-10">
                    <select required class="form-select" name="role">
                      <option disabled selected value>Pilih Role</option>
                      <option value="MASTER"
                        <?php
                        if (isset($user) && $user['role'] == "MASTER") {
                            echo ' selected';
                        }
                        ?>
                        >Master</option>';
                      <option value="ADMIN"
                        <?php
                        if (isset($user) && $user['role'] == "ADMIN") {
                            echo ' selected';
                        }
                        ?>
                      >Admin</option>';
                      <option value="MEMBER"
                        <?php
                        if (isset($user) && $user['role'] == "MEMBER") {
                            echo ' selected';
                        }
                        ?>
                      >Member</option>';
                    </select>
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="inputText" class="col-sm-2 col-form-label">Password</label>
                  <div class="col-sm-10">
                    <input type="password" class="form-control" name="password" value="">
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