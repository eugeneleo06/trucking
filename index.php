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

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['muat'])) {
  require 'config/db.php';
  try {
    $muat = $_GET['muat'];
    $bongkar = $_GET['bongkar'];

    $sql = 'SELECT * FROM list_harga WHERE muat_id = :muat_id AND bongkar_id = :bongkar_id';
    if (isset($_GET['mobil'])) {
      $sql .= " AND mobil_id = :mobil_id";
    }
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':muat_id', $muat, PDO::PARAM_INT);
    $stmt->bindParam(':bongkar_id', $bongkar, PDO::PARAM_INT);

    if (isset($_GET['mobil'])) {
        $mobil = $_GET['mobil'];
        $stmt->bindParam(':mobil_id', $mobil, PDO::PARAM_INT);
    }
    $stmt->execute();
    $list_harga = $stmt->fetchAll();
    foreach($list_harga as $i=>$v) {
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
              <form method="get" action="#search-result">
                <div class="row mb-3">
                    <label for="select" class="col-sm-2 col-form-label">Muat</label>
                    <div class="col-sm-10">
                      <select required name="muat" class="w-100" data-live-search="true" id="select-muat" >
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
                      <select required name="bongkar" class="w-100" data-live-search="true" id="select-bongkar">
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
                    <label for="select" class="col-sm-2 col-form-label">Mobil (Opsional)</label>
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
                  foreach($list_harga as $v){
                    echo '<div class="card-body" style="border:2px solid black;border-radius:3px;margin-bottom:3vh;">';
                      echo '<div class="row">';
                        echo '<div class="col-sm-2 col-3">';
                        echo '<strong>Mobil</strong>';
                        echo '</div>';
                        echo '<div class="col-sm-10 col-9">';
                        echo $v['mobil'];
                        echo '</div>';

                        echo '<div class="col-sm-2 col-3">';
                        echo '<strong>Pemilik Mobil</strong>';
                        echo '</div>';
                        echo '<div class="col-sm-10 col-9">';
                        echo $v['vendor'];
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
  </script>
  <!-- ======= Footer ======= -->
  <?php
  require 'layout/footer.php';