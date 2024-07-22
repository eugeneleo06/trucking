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
require 'api/get_list_harga.php';

?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>List Harga</h1>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body" style="padding-top:3dvh;">
              <?php
              if ($_SESSION['role']!="MEMBER"):
              ?>
              <a href="upsert_list_harga.php" class="btn btn-primary" style="margin-bottom:20px;">Tambah Data</a>
              <?php
              endif;
              ?>
              <!-- Table with stripped rows -->
              <div class="table-responsive">
                <table class="table table-bordered table-striped  datatable" id="customDataTable">
                  <thead>
                    <tr>
                      <th>No.</th>
                      <th>Muat</th>
                      <th>Bongkar</th>
                      <th>Vendor</th>
                      <th>Mobil</th>
                      <th class="price-column">Harga</th>
                      <?php if ($_SESSION['role'] != "MEMBER"):?>
                      <th>Action</th>
                      <?php endif;?>
                    </tr>
                    <tr>
                      <th></th>
                      <th><input type="text" placeholder="Cari Muat" /></th>
                      <th><input type="text" placeholder="Cari Bongkar" /></th>
                      <th><input type="text" placeholder="Cari Vendor" /></th>
                      <th><input type="text" placeholder="Cari Mobil" /></th>
                      <th></th>
                      <?php if ($_SESSION['role'] != "MEMBER"):?>
                      <th></th>
                      <?php endif;?>
                  </tr>
                  </thead>
                  <tbody>
                    <?php
                    foreach($list_harga as $i=>$v):
                      echo '<tr>';
                        echo '<td>'.sprintf("%d", $i+1).'</td>';
                        echo '<td>'.$v['muat'].'</td>';
                        echo '<td>'.$v['bongkar'].'</td>';
                        echo '<td>'.$v['vendor'].'</td>';
                        echo '<td>'.$v['mobil'].'</td>';
                        echo '<td id="price">'.$v['harga'].'</td>';
                        if ($_SESSION['role'] != "MEMBER"):
                        echo '<td>';
                        echo '<a class="edit-btn" href="upsert_list_harga.php?q='.$v['secure_id'].'"><i class="fas fa-lg fa-pencil-alt"></i></a>';
                        echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'; 
                        echo '<a class="delete-btn" data-secure-id="'.$v['secure_id'].'"><i class="fas fa-lg fa-trash-alt"></i></a>';
                        echo '</td>';
                        endif;
                      echo '</tr>';
                    endforeach;
                    ?>
                  </tbody>
                </table>
              </div>
              
              <!-- End Table with stripped rows -->

            </div>
          </div>
          <?php if (isset($_SESSION['error'])) : ?>
              <hr>
              <p style="color: red;"><?php echo $_SESSION['error']; ?></p>
          <?php endif; ?>
          <?php
              unset($_SESSION['error']); 
          ?>
        </div>
      </div>
    </section>
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Hapus Data</h5>
                    <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> -->
                </div>
                <div class="modal-body">
                    Apakah anda yakin ingin menghapus data ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <a href="#" id="confirmDelete" class="btn btn-danger">Hapus</a>
                </div>
            </div>
        </div>
    </div>
  </main><!-- End #main -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script>
        document.addEventListener("DOMContentLoaded", function() {
            function formatNumberWithSeparator(number) {
                return new Intl.NumberFormat('id-ID').format(number);
            }

            // Select all price cells
            let priceCells = document.querySelectorAll('#price');

            // Format each price cell
            priceCells.forEach(function(cell) {
                let value = cell.textContent;
                let numericValue = parseFloat(value.replace(/\D/g, ''));
                cell.textContent = `Rp${formatNumberWithSeparator(numericValue)}`;
            });
        });

        $(document).ready(function() {
        $('.delete-btn').click(function(event) {
            event.preventDefault();
            var secureId = $(this).data('secure-id');
            var deleteUrl = 'api/delete_list_harga.php?q=' + secureId;
            $('#confirmDelete').attr('href', deleteUrl);
            $('#deleteModal').modal('show');
        });
    });
    </script>
  <!-- ======= Footer ======= -->
  <?php
  require 'layout/footer.php';
  