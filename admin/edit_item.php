<?php
$title = "Edit Tagged Tool";
include('../middleware/admin_middleware.php');
include('components/header.php');
?>

<div class="container-fluid px-4">
    <ol class="breadcrumb mb-4 mt-4">
        <li class="breadcrumb-item active"><a href="all_blog.php" class="text-black">Inventory</a></li>
        <li class="breadcrumb-item"><span><b>Edit Tagged Tool</b></span></li>
    </ol>
    <div class="row mt-3">
        <div class="col-lg-12">
            <?php
                if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                    $tbl_items = getAllItemId("tbl_items", $id);

                    if (mysqli_num_rows($tbl_items) > 0) {
                        $data = mysqli_fetch_array($tbl_items);
                        ?>
                            <div class="card">
                                <div class="card-header text-white d-flex justify-content-center" style="background-color: var(--first-color); border-bottom-left-radius: 20px; border-bottom-right-radius: 20px;">
                                    <h1 class="modal-title fs-5 text-ce" id="exampleModalLabel">Edit Tagged Tool</h1>
                                </div>
                                <div class="card-body">
                                    <form action="code.php" method="POST" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <input type="hidden" name="tbl_item_id" value="<?= $data['id'] ?>">
                                                    <label class="form-label mt-2"><b><small>Title <span style="color: red !important;">*</span></small></b></label>
                                                    <input type="text" name="item_name" value="<?= $data['item_name'] ?>" class="form-control" placeholder="Item Name" required>
                                                    
                                                    <input type="file" name="image" class="form-control mt-4" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" aria-label="Upload" required>
                                                    <input type="hidden" name="old_image" value="<?= $data['image'] ?>">
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="stock"><small><b>Stock <span style="color: red !important;">*</span></b></small></label>
                                                    <input type="number" name="stock" value="<?= $data['stock'] ?>" class="form-control" placeholder="Enter Data" required>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="text-center "><b><i class="fa-solid fa-circle-exclamation" style="color: red !important;"></i> </b><small>All fields are required.</small></p>
                                        <div class="col-lg-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary btn-sm" name="update_item_btn" title="Submit">Submit <i class="fa-solid fa-paper-plane"></i></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        <?php
                    } else {
                        redirect("inventory.php", "Tagged Tools not Found");
                    }
                } else {
                    redirect("inventory.php", "ID Missing from URL");
                }
            ?>
        </div>
    </div>
</div>
<?php include('components/footer.php'); ?>