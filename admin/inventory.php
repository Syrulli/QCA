<?php
    $title = "TT ( TAGGED TOOLS) INVENTORY";
    include('../middleware/admin_middleware.php');
    include('components/header.php');
    include('components/modal.php');
?>
<section>
    <div class="container-fluid px-4 mt-4" id="all_item_table">
        <div class="row">
            <h3 class="float-start">Tagged Tools <span>Inventory</span></h3>
            <hr>
        </div>
        <button title="Add Item" type="button" class="btn btn-primary mb-3 float-end btn-sm" data-bs-toggle="modal" data-bs-target="#add_item_modal">
           <small>Add Tool <i class="fa-solid fa-circle-plus"></i></small>
        </button>
        <table style="font-size: small;" class="table table-striped table-wrapper-scroll-y my-custom-scrollbar text-center shadow p-3 mb-5 bg-body-tertiary rounded">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Stock</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

            <?php
                $items = getAllItems("tbl_items");
                if (mysqli_num_rows($items) > 0) {
                    foreach ($items as $data) {
                        ?>
                            <tr>
                                <td><small><?= $data['item_name']; ?></small></td>
                                <td><small><?= $data['stock']; ?></small></td>
                                <td>
                                    <img style="width: 30px; height: 30px; border-radius: 30%;" src="../uploaded/<?= $data['image']; ?>">
                                </td>
                                <td>
                                    <a href="edit_item.php?id=<?= $data['id']; ?>" type="button" class="me-2 text-secondary" title="Edit Tagged Tools"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <a type="button" value="<?= $data['id']; ?>" class="delete_item_btn me-2" title="Delete Tagged Tools"><i class="fa-solid fa-trash" style="color: red;"></i></a>
                                </td>
                            </tr>
                        <?php
                    }
                }else{
                    ?>
                        <tr><td colspan="6">No Tagged Tools found</td></tr>
                    <?php
                }
            ?>
              
            </tbody>
        </table>
    </div>
</section>
<?php include('components/footer.php'); ?>