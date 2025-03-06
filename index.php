<?php
$title = "Quezon City Academy";
include('functions/userfunction.php');
include('./includes/header.php');
include('email.php');
?>

<section style="background-image: url('img/dummy_img_1.png') !important; background-repeat: no-repeat; background-position: center !important; background-size: cover; background-attachment: fixed;">
  <div class="container home-container1-content">
    <div class="row min-vh-100 align-items-center">
      <div class="col-lg-12 col-sm-12 text-start mt-sm-5">
        <h3 style="color: var(--text-color); font-size: 60px; font-size: clamp(2rem, 5vw, 5rem);">Quezon City Academy</h3>
        <p style="color:white;">Direct its curriculum and programs to technology and community oriented projects and activities that should enhance moral and spiritual values, critical thinking and better livelihood opportunities to meet the educational challenges of today and life in the future.</p>
      </div>
    </div>
  </div>
</section>
<section class="position-relative pb-5">
  <div class="container mt-5">
    <div class="row">
      <div class="col-lg-12" style="display: block;">
        <div class="card mt-lg-3 shadow bg-body-tertiary rounded">
          <form id="borrowForm" class="active">
            <div class="card-header text-center text-white" style="background-color: var(--first-color); border-bottom-left-radius: 20px; border-bottom-right-radius: 20px;">Borrow Preference</div>
            <div class="card-body">
              <div class="mb-3">
                <label class="form-label" for="student_name"><small>Full Name</small></label>
                <input type="text" id="student_name" name="student_name" class="form-control" placeholder="Enter full name." required autocomplete="on">
              </div>

              <label for="section" class="form-label"><small>Section</small></label>
              <select class="form-select mb-3" id="section" name="section" required>
                <option selected>Select Section</option>
                <option value="Stem A">Stem A</option>
                <option value="Stem B">Stem B</option>
                <option value="Stem C">Stem C</option>
              </select>

              <div class="mb-3">
                <label for="borrowed_date" class="form-label"><small>Borrow Date</small></label>
                <input type="date" id="borrowed_date" name="borrowed_date" class="form-control" required>
              </div>

              <div class="mb-3">
                <label for="return_date" class="form-label"><small>Return Date</small></label>
                <input type="date" id="return_date" name="return_date" class="form-control" required>
              </div>

              <label for="item" class="form-label"><small>Tagged Tools</small></label>
              <select id="item" name="item" class="form-select mb-3" required>
                <option selected>Select Tagged Tool</option>
                <?php
                $items = getAllAvailableItems("tbl_items");
                if (mysqli_num_rows($items) > 0) {
                  foreach ($items as $data) {
                    echo '<option value="' . intval($data['id']) . '" data-stock="' . intval($data['stock']) . '">' . htmlspecialchars($data['item_name']) . '</option>';
                  }
                } else {
                  echo '<option disabled>No Items Available</option>';
                }
                ?>
              </select>

              <div class="mb-3">
                <label class="form-label" for="qty"><small>Quantity</small></label>
                <input type="number" id="qty" name="qty" class="form-control" placeholder="Enter Quantity">
              </div>

              <div class="mb-3">
                <label class="form-label" for="stock"><small>Stock</small></label>
                <input type="number" id="stock" value="0" name="stock" class="form-control" readonly disabled>
              </div>
            </div>
            <div class="card-footer text-body-secondary text-center">
              <button type="button" id="btn_borrow" class="btn btn-primary btn-sm">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" class="position-absolute bottom-0 start-0" style="z-index: -1;">
    <path fill="#e4e4e45a" fill-opacity="1" d="M0,64L34.3,80C68.6,96,137,128,206,154.7C274.3,181,343,203,411,213.3C480,224,549,224,617,202.7C685.7,181,754,139,823,106.7C891.4,75,960,53,1029,53.3C1097.1,53,1166,75,1234,90.7C1302.9,107,1371,117,1406,122.7L1440,128L1440,320L1405.7,320C1371.4,320,1303,320,1234,320C1165.7,320,1097,320,1029,320C960,320,891,320,823,320C754.3,320,686,320,617,320C548.6,320,480,320,411,320C342.9,320,274,320,206,320C137.1,320,69,320,34,320L0,320Z"></path>
  </svg>
</section>
<?php include('./includes/footer.php'); ?>