<?php
$title = "Borrowed History ";
include('../middleware/admin_middleware.php');
include('components/header.php');
include('components/modal.php');
?>

<section>
    <div class="container-fluid px-4 mt-4" id="table_borrowed_history">
        <div class="row">
            <h3 class="float-start"><span>Borrowed History</span></h3>
            <hr>
        </div>
        <div class="row float-end mb-3">
            <form class="d-flex" role="search" method="GET">
                <input id="searchInput" class="form-control me-2" type="search" name="search" placeholder="Search student name..." aria-label="Search" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            </form>
        </div>
        <table style="font-size: small;" class="table table-striped table-wrapper-scroll-y my-custom-scrollbar text-center shadow p-3 mb-5 bg-body-tertiary rounded">
            <thead>
                <tr>
                    <th><small>Approved By</small></th>
                    <th><small>Student Name</small></th>
                    <th><small>Item Name</small></th>
                    <th><small>Total Item</small></th>
                    <th><small>Section</small></th>
                    <th><small>Date Borrowed</small></th>
                    <th><small>Return Date</small></th>
                </tr>
            </thead>
            <tbody id="searchStudentName">
                <?php
                $items = getAllBorrowedHistory();
                if (!empty($items)) {
                    foreach ($items as $data) {
                ?>
                        <tr>
                            <td><small><?= htmlspecialchars($data['approved_by']); ?></small></td>
                            <td><small><?= htmlspecialchars($data['student_name']); ?></small></td>
                            <td><small><?= htmlspecialchars($data['item_name']); ?></small></td>
                            <td><small><?= htmlspecialchars($data['qty']); ?></small></td>
                            <td><small><?= htmlspecialchars($data['section']); ?></small></td>
                            <td><small><?= htmlspecialchars($data['borrowed_date']); ?></small></td>
                            <td><small><?= htmlspecialchars($data['return_date']); ?></small></td>
                        </tr>
                    <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="6">No past return dates found</td>
                    </tr>
                <?php
                }
                ?>
            </tbody>

        </table>
    </div>
</section>
<?php include('components/footer.php'); ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('input', function() {

                const searchText = this.value.toLowerCase();
                const rows = searchStudentName.getElementsByTagName('tr');
                let matchFound = false;

                for (let row of rows) {
                    const nameColumn = row.getElementsByTagName('td')[0];
                    if (nameColumn) {
                        const nameText = nameColumn.textContent.toLowerCase();
                        if (nameText.includes(searchText)) {
                            row.style.display = '';
                            matchFound = true;
                        } else {
                            row.style.display = 'none';
                        }
                    }
                }

                const existingNoNameRow = searchStudentName.querySelector('.no-name-row');
                if (existingNoNameRow) {
                    existingNoNameRow.remove();
                }

                if (!matchFound) {
                    const noNameRow = document.createElement('tr');
                    noNameRow.classList.add('no-name-row');
                    const noNameCell = document.createElement('td');
                    noNameCell.setAttribute('colspan', '6');
                    noNameCell.textContent = 'No name found';
                    noNameRow.appendChild(noNameCell);
                    searchStudentName.appendChild(noNameRow);
                }

            });
        } else {
            console.error("Element with ID 'searchInput' not found.");
        }
    });
</script>