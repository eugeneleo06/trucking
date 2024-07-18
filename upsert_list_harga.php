<?php
ob_start();
session_start();

if (!isset($_SESSION["username"])) {
  header('Location: login.php');
  exit;
}

if ($_SESSION['role'] == "MEMBER") {
    header('Location: index.php');
    exit;
}

require 'layout/header.php';
require 'layout/navbar.php';
require 'layout/sidebar.php';
require 'api/detail_list_harga.php';

?>
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>List Harga</h1>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <!-- General Form Elements -->
              <form method="post" action="api/upsert_list_harga.php">
                <div class="row mb-3">
                  <label for="select" class="col-sm-2 col-form-label">Muat</label>
                  <div class="col-sm-10">
                    <select required name="muat" class="form-select" id="select-muat">
                        <?php
                        foreach($muat_bongkar as $v) {
                            echo '<option value="'.$v['id'].'"';
                            if ($v['id'] == $list_harga['muat_id']) {
                              echo 'selected';
                            }
                            echo '>'.$v['nama'].'</option>';
                        }
                        ?>
                    </select>                  
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="select" class="col-sm-2 col-form-label">Bongkar</label>
                  <div class="col-sm-10">
                    <select required name="bongkar" class="form-select" id="select-bongkar">
                        <?php
                        foreach($muat_bongkar as $v) {
                            echo '<option value="'.$v['id'].'"';
                            if ($v['id'] == $list_harga['bongkar_id']) {
                              echo 'selected';
                            }
                            echo '>'.$v['nama'].'</option>';
                        }
                        ?>
                    </select>                  
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="select" class="col-sm-2 col-form-label">Vendor</label>
                  <div class="col-sm-10">
                    <select required name="vendor" class="form-select">
                        <?php
                        foreach($vendor as $v) {
                            echo '<option value="'.$v['id'].'"';
                            if ($v['id'] == $list_harga['bongkar_id']) {
                              echo 'selected';
                            }
                            echo '>'.$v['nama'].'</option>';
                        }
                        ?>
                    </select>                  
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="select" class="col-sm-2 col-form-label">Mobil</label>
                  <div class="col-sm-10">
                    <select required id="multi-select" name="mobil[]" multiple="multiple" class="form-select" required>
                        <?php
                        foreach($mobil as $v) {
                            echo '<option value="'.$v['id'].'"';
                            if (isset($mobilIds)){
                                foreach($mobilIds as $mobilId) {
                                    if ($v['id'] == $mobilId) {
                                        echo ' selected';
                                    }
                                }
                            }
                            echo '>'.$v['nama'].'</option>';
                        }
                        ?>
                    </select>
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
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script>
        $(document).ready(function() {
            $('#multi-select').select2({
                placeholder: "Pilih mobil",
                allowClear: true
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
          const selectMuat = document.getElementById('select-muat');
          const selectBongkar = document.getElementById('select-bongkar');
          console.log(selectMuat);
          console.log(selectBongkar);

          function updateOptions() {
            const muatValue = selectMuat.value;
            const bongkarValue = selectBongkar.value;

            for (let i = 0; i < selectBongkar.options.length; i++) {
              const option = selectBongkar.options[i];
              option.disabled = (option.value === muatValue);
            }

            for (let i = 0; i < selectMuat.options.length; i++) {
              const option = selectMuat.options[i];
              option.disabled = (option.value === bongkarValue);
            }
          }

          selectMuat.addEventListener('change', updateOptions);
          selectBongkar.addEventListener('change', updateOptions);

          // Initialize the options on page load
          updateOptions();
        });
  </script>
  <!-- ======= Footer ======= -->
  <?php
  require 'layout/footer.php';