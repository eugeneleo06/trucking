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
require 'api/get_mobil.php';

?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Mobil</h1>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body" style="padding-top:3dvh;">
              <a href="upsert_mobil.php" class="btn btn-primary" style="margin-bottom:20px;">Tambah Data</a>
              <!-- Table with stripped rows -->
              <table class="table datatable" id="dataTable">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>Nama</th>
                    <?php if ($_SESSION['role'] != "MEMBER"):?>
                    <th>Action</th>
                    <?php endif;?>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach($mobil as $i=>$v):
                    echo '<tr>';
                      echo '<td>'.sprintf("%d", $i+1).'</td>';
                      echo '<td>'.$v['nama'].'</td>';
                      if ($_SESSION['role'] != "MEMBER"):
                      echo '<td>';
                      echo '<a class="edit-btn" href="upsert_mobil.php?q='.$v['secure_id'].'"><i class="fas fa-lg fa-pencil-alt"></i></a>';
                      echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'; 
                      echo '<a class="delete-btn" data-secure-id="'.$v['secure_id'].'"><i class="fas fa-lg fa-trash-alt"></i></a>';
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
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                    <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> -->
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <a href="#" id="confirmDelete" class="btn btn-danger">Delete</a>
                </div>
            </div>
        </div>
      </div>
  </main><!-- End #main -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script>
        $(document).ready(function() {
        $('.delete-btn').click(function(event) {
            event.preventDefault();
            var secureId = $(this).data('secure-id');
            var deleteUrl = 'api/delete_mobil.php?q=' + secureId;
            $('#confirmDelete').attr('href', deleteUrl);
            $('#deleteModal').modal('show');
        });
    });
    </script>
  <!-- ======= Footer ======= -->
  <?php
  require 'layout/footer.php';
  