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
require 'api/detail_list_harga.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['submit'])) {
  require 'config/db.php';
  try {
    $sql = 'SELECT * FROM list_harga WHERE 1=1 ';
    $sql = 'SELECT * FROM list_harga WHERE 1=1';
    $params = [];
    
    if (isset($_GET['muat'])) {
        $sql .= " AND muat_id = :muat_id";
        $params[':muat_id'] = $_GET['muat'];
    }
    if (isset($_GET['bongkar'])) {
        $sql .= " AND bongkar_id = :bongkar_id";
        $params[':bongkar_id'] = $_GET['bongkar'];
    }
    if (isset($_GET['vendor'])) {
        $sql .= " AND vendor_id = :vendor_id";
        $params[':vendor_id'] = $_GET['vendor'];
    }
    if (isset($_GET['mobil'])) {
        $sql .= " AND mobil_id = :mobil_id";
        $params[':mobil_id'] = $_GET['mobil'];
    }
    
    // Execute the query with prepared statements
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    $list_harga = $stmt->fetchAll();
    foreach($list_harga as $i=>$v) {
      $sql = "SELECT nama FROM muat_bongkar WHERE id = :id";
      $stmt = $db->prepare($sql);
      $stmt->bindParam(':id', $v['muat_id'], PDO::PARAM_INT);
      $stmt->execute();
      $list_harga[$i]['muat'] = $stmt->fetchColumn();  

      $sql = "SELECT nama FROM muat_bongkar WHERE id = :id";
      $stmt = $db->prepare($sql);
      $stmt->bindParam(':id', $v['bongkar_id'], PDO::PARAM_INT);
      $stmt->execute();
      $list_harga[$i]['bongkar'] = $stmt->fetchColumn();  

      $sql = "SELECT nama FROM mobil WHERE id = :id";
      $stmt = $db->prepare($sql);
      $stmt->bindParam(':id', $v['mobil_id'], PDO::PARAM_INT);
      $stmt->execute();
      $list_harga[$i]['mobil'] = $stmt->fetchColumn();

      $sql = "SELECT nama FROM vendor WHERE id = :id";
      $stmt = $db->prepare($sql);
      $stmt->bindParam(':id', $v['vendor_id'], PDO::PARAM_INT);
      $stmt->execute();
      $list_harga[$i]['vendor'] = $stmt->fetchColumn();  
    }
  } 
  catch (PDOException $e) { 
    echo $e->getMessage();
    exit;
  }
}

?>
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Home</h1>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <!-- General Form Elements -->
              <form method="get" action="" onsubmit="return validateForm()">
                <div class="row mb-3">
                    <label for="select" class="col-sm-2 col-form-label">Muat</label>
                    <div class="col-sm-10">
                      <select name="muat" class="w-100" data-live-search="true" id="select-muat" >
                      <option disabled selected value>Pilih Muat</option>
                          <?php
                          foreach($muat_bongkar as $v) {
                              echo '<option value="'.$v['id'].'"';
                              echo '>'.$v['nama'].'</option>';
                          }
                          ?>
                      </select>                  
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="select" class="col-sm-2 col-form-label">Bongkar</label>
                    <div class="col-sm-10">
                      <select name="bongkar" class="w-100" data-live-search="true" id="select-bongkar">
                        <option disabled selected value>Pilih Bongkar</option>
                          <?php
                          foreach($muat_bongkar as $v) {
                              echo '<option value="'.$v['id'].'"';
                              echo '>'.$v['nama'].'</option>';
                          }
                          ?>
                      </select>                  
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="select" class="col-sm-2 col-form-label">Pemilik Mobil</label>
                    <div class="col-sm-10">
                      <select name="vendor" class="w-100" data-live-search="true" id="vendor">
                        <option disabled selected value>Pilih Pemilik Mobil</option>
                          <?php
                          foreach($vendor as $v) {
                              echo '<option value="'.$v['id'].'"';
                              echo '>'.$v['nama'].'</option>';
                          }
                          ?>
                      </select>                  
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="select" class="col-sm-2 col-form-label">Mobil</label>
                    <div class="col-sm-10">
                      <select name="mobil" class="w-100" data-live-search="true" id="mobil">
                        <option disabled selected value>Pilih Mobil</option>
                          <?php
                          foreach($mobil as $v) {
                              echo '<option value="'.$v['id'].'"';
                              echo '>'.$v['nama'].'</option>';
                          }
                          ?>
                      </select>                  
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-10">
                      <input type="hidden" name="submit" value='1'>
                        <?php if (isset($_SESSION['error'])) : ?>
                            <p style="color: red;"><?php echo $_SESSION['error']; ?></p>
                        <?php endif; ?>
                        <?php
                        unset($_SESSION['error']); 
                        ?>
                      <button type="submit" class="btn btn-primary" style="width: 100px;">Cari</button>
                  </div>
                </div>
              </form><!-- End General Form Elements -->
              <hr>
              <div id="search-result">
                <?php
                if(isset($list_harga)):
                  if (count($list_harga) == 0) {
                    echo '<h5 style="text-align:center">Data tidak ditemukan</h5>';
                  }
                  foreach($list_harga as $v){
                    echo '<div class="card-body" style="border:2px solid black;border-radius:3px;margin-bottom:3vh;">';
                      echo '<div class="row">';
                        echo '<div class="col-sm-2 col-3">';
                        echo '<strong>Muat</strong>';
                        echo '</div>';
                        echo '<div class="col-sm-10 col-9">';
                        echo $v['muat'];
                        echo '</div>';

                        echo '<div class="col-sm-2 col-3">';
                        echo '<strong>Bongkar</strong>';
                        echo '</div>';
                        echo '<div class="col-sm-10 col-9">';
                        echo $v['bongkar'];
                        echo '</div>';

                        echo '<div class="col-sm-2 col-3">';
                        echo '<strong>Pemilik Mobil</strong>';
                        echo '</div>';
                        echo '<div class="col-sm-10 col-9">';
                        echo $v['vendor'];
                        echo '</div>';

                        echo '<div class="col-sm-2 col-3">';
                        echo '<strong>Mobil</strong>';
                        echo '</div>';
                        echo '<div class="col-sm-10 col-9">';
                        echo $v['mobil'];
                        echo '</div>';

                        echo '<div class="col-sm-2 col-3">';
                        echo '<strong>Harga</strong>';
                        echo '</div>';
                        echo '<div class="col-sm-10 col-9">';
                ?>
                <span class="harga-span">
                <?php echo $v['harga'];?>
                </span>
                <?php
                        echo '</div>';
                      echo '</div>';
                    echo '</div>';
                  }
                endif;
                ?>
              </div>

            </div>
          </div>

        </div>
      </div>
    </section>

  </main><!-- End #main -->
  <div class="modal fade" id="validationModal" tabindex="-1" aria-labelledby="validationModalLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="validationModalLabel">Terjadi kesalahan</h5>
            </div>
            <div class="modal-body">
              Pilih salah satu filter pada pencarian
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
          </div>
      </div>
  </div>
  <script src="vendor/jquery/jquery.min.js"></script>
  <script>
    function formatNumberWithSeparator(number) {
      return new Intl.NumberFormat('id-ID').format(number);
    }
    document.addEventListener('DOMContentLoaded', function() {
      const selectMuat = document.getElementById('select-muat');
      const selectBongkar = document.getElementById('select-bongkar');

      function updateOptions() {
        const muatValue = selectMuat.value;
        const bongkarValue = selectBongkar.value;

        for (let i = 0; i < selectBongkar.options.length; i++) {
          const option = selectBongkar.options[i];
          option.disabled = (option.value === muatValue || option.value == "");
        }

        for (let i = 0; i < selectMuat.options.length; i++) {
          const option = selectMuat.options[i];
          option.disabled = (option.value === bongkarValue || option.value == "");
        }

        $('#select-muat').selectpicker('refresh');
        $('#select-bongkar').selectpicker('refresh');
      }

      selectMuat.addEventListener('change', updateOptions);
      selectBongkar.addEventListener('change', updateOptions);

      // Initialize the options on page load
      updateOptions();

      const harga = document.getElementsByClassName('harga-span');
      for (let i =0; i<harga.length;i++) {
        harga[i].innerHTML = 'Rp'+formatNumberWithSeparator(harga[i].innerHTML);
      }
    });

    function validateForm() {
        var selects = document.querySelectorAll('select');
        var isAnySelected = false;

        selects.forEach(function(select) {
          if (select.value !== "") {
            isAnySelected = true;
            }
        });

        console.log(isAnySelected);

        if (!isAnySelected) {
            $('#validationModal').modal('show');
            return false;
        }

        return true;
    }
  </script>
  <!-- ======= Footer ======= -->
  <?php
  require 'layout/footer.php';