<!--ADD SCHEDULE-->
<div class="modal fade" id="addScheduleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header text-white d-flex justify-content-center" style="background-color: var(--first-color); border-bottom-left-radius: 20px; border-bottom-right-radius: 20px;">
        <h1 class="modal-title fs-5 text-ce" id="exampleModalLabel">Schedule a class</h1>
      </div>
      <div class="modal-body">
        <form id="scheduleForm">
          <input type="hidden" name="modafl_add_sched" value="<?= $sched['id'] ?>">

          <div class="row">
            <div class="col-lg-12">
              <div class="mb-3">
                <label class="form-label"><small><b>Schedule Title<span style="color: red;">*</span></b></small></label>
                <input type="text" id="scheduleTitle" name="title" class="form-control" placeholder="Schedule Title" required>
              </div>

              <div class="mb-3">
                <label class="form-label"><small><b>Section<span style="color: red;">*</span></b></small></label>
                <input type="text" id="scheduleSection" name="section" class="form-control" placeholder="Enter Section" required>
              </div>

              <div class="mb-3">
                <label class="form-label"><small><b>Subject<span style="color: red;">*</span></b></small></label>
                <input type="text" id="scheduleSubject" name="subject" class="form-control" placeholder="Enter Subject" required>
              </div>

              <input type="hidden" id="scheduleDate" name="date">
              <input type="hidden" id="scheduleStart" name="start">
              <input type="hidden" id="scheduleEnd" name="end">
              <input type="hidden" id="auth_user" name="user_id" value="<?= $_SESSION['auth_user']['user_id'] ?? ''; ?>">
            </div>
          </div>

          <div class="row">
            <p class="text-center">
              <b><i class="fa-solid fa-circle-exclamation" style="color: red;"></i></b> <small>All fields are required.</small>
            </p>
            <div class="col-lg-12 d-flex justify-content-end">
              <button type="button" class="btn btn-success btn-sm" id="saveScheduleBtn"><small>Submit <i class="fa-solid fa-paper-plane"></i></small></button>
              <a type="button" class="btn btn-danger btn-sm ms-2" data-bs-dismiss="modal"><small>Cancel <i class="fa-solid fa-ban"></i></small></a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!--ADD SCHEDULE-->

<!--ADD ITEM-->
  <div class="modal fade" id="add_item_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header text-white d-flex justify-content-center" style="background-color: var(--first-color); border-bottom-left-radius: 20px; border-bottom-right-radius: 20px;">
          <h1 class="modal-title fs-5 text-ce" id="exampleModalLabel">Add Tagged Tool</h1>
        </div>
        <div class="modal-body">
          <form action="code.php" method="POST" enctype="multipart/form-data">
            <div class="row">
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label" for="item_name"><small><b>Item Name<span style="color: red !important;">*</span></b></small></label>
                  <input type="text" name="item_name" class="form-control" placeholder="Enter Item Name" spellcheck="true" required>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label" for="stock"><small><b>Stock <span style="color: red !important;">*</span></b></small></label>
                  <input type="number" name="stock" class="form-control" placeholder="Enter Data" required>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="input-group col-lg-12 mb-2">
                <input type="file" name="image" class="form-control" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" aria-label="Upload" required>
              </div>
            </div>
            <div class="row">
              <p class="text-center "><b><i class="fa-solid fa-circle-exclamation" style="color: red !important;"></i> </b><small>All fields are required.</small></p>
              <div class="col-lg-12 d-flex justify-content-end">
                <button type="submit" class="btn btn-success btn-sm" name="add_item_btn" title="Submit"><small>Submit <i class="fa-solid fa-paper-plane"></i></small></button>
                <a type="button" class="btn btn-danger btn-sm ms-2" title="Cancel" data-bs-dismiss="modal"><small>Cancel <i class="fa-solid fa-ban"></i></small></a>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
<!--ADD ITEM-->

<!--EDIT SCHEDULE-->
<div class="modal fade" id="editScheduleModal" tabindex="-1" aria-labelledby="editScheduleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header text-white d-flex justify-content-center" style="background-color: var(--first-color); border-bottom-left-radius: 20px; border-bottom-right-radius: 20px;">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Schedule</h1>
      </div>
      <div class="modal-body">
        <form id="editScheduleForm" action="code.php" method="POST">
          <input type="hidden" id="editScheduleId" name="id">

          <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" id="editScheduleTitle" name="title" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Section</label>
            <input type="text" id="editScheduleSection" name="section" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Subject</label>
            <input type="text" id="editScheduleSubject" name="subject" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Date</label>
            <input type="date" id="editScheduleDate" name="date" class="form-control" required>
          </div>


          <div class="mb-3">
            <label class="form-label">Start Time</label>
            <input type="datetime-local" id="editScheduleStart" name="start" class="form-control" required>
          </div>


          <div class="mb-3">
            <label class="form-label">End Time</label>
            <input type="datetime-local" id="editScheduleEnd" name="end" class="form-control" required>
          </div>

          <div class="row">
            <p class="text-center">
              <b><i class="fa-solid fa-circle-exclamation" style="color: red;"></i></b> <small>All fields are required.</small>
            </p>
            <div class="col-lg-12 d-flex justify-content-end">
              <button type="submit" name="update_schedule_btn" class="btn btn-success btn-sm">
                Submit <i class="fa-solid fa-paper-plane"></i>
              </button>
              <button type="button" id="deleteScheduleBtn" class="btn btn-danger btn-sm ms-2">
                Delete <i class="fa-solid fa-trash"></i>
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!--EDIT SCHEDULE-->

<!-- EDIT ADMIN PROFILE-->
  <div class="modal fade" id="update_acc">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header text-white d-flex justify-content-center" style="background-color: var(--first-color); border-bottom-left-radius: 20px; border-bottom-right-radius: 20px;">
          <h1 class="modal-title fs-5" id="exampleModalLabel">My Account</h1>
        </div>
        <div class="modal-body">
          <?php
          $users = updateAcc("tbl_users");
          if (mysqli_num_rows($users) > 0) {
            $users = mysqli_fetch_array($users);
          ?>
            <form action="code.php" method="POST" enctype="multipart/form-data">
              <div class="row">
                <div class="col-lg-12">
                  <input type="hidden" name="modal_update_acc" value="<?= $users['id'] ?>">
                  <div class="mb-3">
                    <label class="form-label"><small><b>Name</b></label></small>
                    <input type="name" name="name" class="form-control" value="<?= $users['name'] ?>" placeholder="Name" required>
                  </div>
                  <div class="mb-3">
                    <label class="form-label"><small><b>Email</b></label></small>
                    <input type="email" name="email" class="form-control" value="<?= $users['email'] ?>" placeholder="Email" required>
                  </div>

                  <div class="mb-3">
                    <label class="form-label"><small><b>New Password</b></label></small>
                    <div class="input-group">
                      <input type="password" name="password" id="password" minlength="8" maxlength="16"
                        pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*[#?!]).{8,16}"
                        class="form-control" placeholder="Enter new password (leave blank if unchanged)">
                      <button type="button" class="btn btn-outline-primary" onclick="togglePasswordVisibility()">
                        <i class="fa-solid fa-eye"></i>
                      </button>
                    </div>
                  </div>

                </div>
              </div>
              <div class="d-flex justify-content-center">
                <button type="submit" value="<?= $users['id']; ?>" class="btn btn-success btn-sm" name="update_acc_btn" title="Submit">Submit <i class="fa-solid fa-paper-plane"></i></button>
              </div>
            </form>
          <?php
          } else {
            echo "User Not Found for given ID";
          }
          ?>
        </div>
      </div>
    </div>
  </div>
<!-- EDIT ADMIN PROFILE-->