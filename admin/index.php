<?php
    $title = "Dashboard - KV Dental ";
    include('../middleware/admin_middleware.php');
    include('components/header.php');
    include('components/modal.php');
?>

<section>
    <div class="container-fluid px-4 mt-5">
        <div class="row float-end mb-3">
            <form class="d-flex" role="search">
                <input id="searchInput" class="form-control me-2" type="search" placeholder="Search..." aria-label="Search">
            </form>
        </div>
        <table style="font-size: small;" class="table table-striped table-wrapper-scroll-y my-custom-scrollbar text-center shadow p-3 mb-5 bg-body-tertiary rounded">
            <thead>
                <tr>
                    <th><small>Student Name</small></th>
                    <th><small>Item Name</small></th>
                    <th><small>Total Item</small></th>
                    <th><small>Section</small></th>
                    <th><small>Date Borrowed</small></th>
                    <th><small>Return Date</small></th>
                </tr>
            </thead>
            <tbody id="searchPatientName">
                
            </tbody>
        </table>
        
    </div>
</section>
<?php include('components/footer.php'); ?>