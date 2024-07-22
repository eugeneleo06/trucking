<?php
ob_start();
session_start();

if (!isset($_SESSION["username"])) {
  header('Location: login.php');
  exit;
}

if ($_SESSION['role'] == "MEMBER") {
    header('Location: list_harga.php');
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
                    <select required name="muat" class="w-100" data-live-search="true" id="select-muat" >
                    <option disabled selected value>Pilih Muat</option>
                        <?php
                        foreach($muat_bongkar as $v) {
                            echo '<option value="'.$v['id'].'"';
                            if (isset($list_harga) && $v['id'] == $list_harga['muat_id']) {
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
                    <select required name="bongkar" class="w-100" data-live-search="true" id="select-bongkar">
                      <option disabled selected value>Pilih Bongkar</option>
                        <?php
                        foreach($muat_bongkar as $v) {
                            echo '<option value="'.$v['id'].'"';
                            if (isset($list_harga) && $v['id'] == $list_harga['bongkar_id']) {
                              echo 'selected';
                            }
                            echo '>'.$v['nama'].'</option>';
                        }
                        ?>
                    </select>                  
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="select" class="col-sm-2 col-form-label">Pemilik Mobil</label>
                  <div class="col-sm-10">
                    <select id="vendor" required name="vendor" class="w-100" data-live-search="true" data-mobil-vendor='<?php echo json_encode($mobil_vendor); ?>'>
                      <option disabled selected value>Pilih Pemilik Mobil</option>
                        <?php
                        foreach($vendor as $v) {
                            echo '<option value="'.$v['id'].'"';
                            if (isset($list_harga) &&  $v['id'] == $list_harga['vendor_id']) {
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
                    <select id="mobil" name="mobil" class="w-100" required data-none-selected-text="Pilih Mobil" data-live-search="true">
                    </select>
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="inputText" class="col-sm-2 col-form-label">Harga</label>
                  <div class="col-sm-10">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">Rp</div>
                      </div>
                      <input type="text" class="form-control" name="harga" oninput="formatNumber(this)" value="<?php if(isset($list_harga['harga'])){echo $list_harga['harga'];}?>">
                    </div>
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
  <!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> -->
  <script>

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
        });

        function formatNumber(input) {
          let value = input.value.replace(/\D/g, ''); // Remove non-numeric characters
          if (value) {
            input.value = new Intl.NumberFormat('id-ID').format(value);
          }
        }

        function cleanNumber(input) {
          input.value = input.value.replace(/\D/g, ''); // Remove all non-numeric characters
        }

        document.addEventListener('DOMContentLoaded', (event) => {
          const hargaInput = document.querySelector('input[name="harga"]');
          if (hargaInput && hargaInput.value) {
            formatNumber(hargaInput); // Apply formatting on page load if value exists
          }
        });


        document.addEventListener('DOMContentLoaded', function() {
          const vendorSelect = document.getElementById('vendor');
          const mobilSelect = document.getElementById('mobil');
          const mobilVendor = JSON.parse(vendorSelect.getAttribute('data-mobil-vendor'));
          const selectedMobilIds = <?php echo json_encode($mobilIds); ?>;

          function updateMobilOptions() {
              const selectedVendorId = vendorSelect.value;
              const options = mobilVendor[selectedVendorId] || [];
              mobilSelect.innerHTML = '';

              options.forEach(option => {
                  const opt = document.createElement('option');
                  opt.value = option.id;
                  opt.textContent = option.nama;
                  if (selectedMobilIds.includes(option.id)) {
                      opt.selected = true;
                  }
                  mobilSelect.appendChild(opt);
              });

              $('#mobil').selectpicker('refresh');
            }

          // Initialize Select2
          // $(mobilSelect).select2({
          //   placeholder: "Pilih Mobil",
          //   allowClear: true,
          //   theme: 'bootstrap-5'
          // });

          // Initial population of mobil options based on the default selected vendor
          updateMobilOptions();

          // Update mobil options when vendor selection changes
          vendorSelect.addEventListener('change', updateMobilOptions);
      });
</script>
  <!-- ======= Footer ======= -->
  <?php
  require 'layout/footer.php';