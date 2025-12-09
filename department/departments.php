<?php include $_SERVER['DOCUMENT_ROOT'] . '/ShiftTrack/config.php';?>
<?php include ROOT_PATH . 'includes/navbar.php'; ?>
<?php include ROOT_PATH . 'includes/sidebar.php'; ?>
<?php include ROOT_PATH . 'database.php'; ?>


<div class="main-content">
    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-start mt-1">
            <div>
                <h3>Departments</h3>
                <p class="text-muted">Manage company departments and divisions</p>
            </div>

            <button class="btn btn-primary d-flex align-items-center mt-2" data-bs-toggle="modal" data-bs-target="#addDeptModal">
                <i class="bi bi-plus-lg me-2"></i> Add Department
            </button>
        </div>

        <!-- Search & Count -->
        <div class="card p-3 mt-3">
            <div class="d-flex justify-content-between align-items-center">

                <!-- Search Input -->
                <div class="search-input-container">
                    <i class="bi bi-search search-icon"></i>
                    <input type="text" id="deptSearch" class="form-control search-input" placeholder="Search departments...">
                </div>

            </div>
        </div>

        <!-- Departments Table -->
        <div class="card mt-3">
            <table class="table align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Department Name</th>
                        <th>Employees</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody id="deptTable">

                <?php
                    $request = $connection->query("SELECT * FROM departments ORDER BY id ASC");
                    foreach ($request as $row){
                        ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><strong><?= $row['name'] ?></strong></td>
                            <?php $empCount = $connection->query("SELECT COUNT(*) AS total FROM employees WHERE department_id = {$row['id']}")->fetch()['total'];?>
                            <td><span class="badge bg-light text-dark"><i class="bi bi-people"></i> <?= $empCount ?> Employees</span></td>
                            <td><?= date("d-m-Y", strtotime($row['created_at'])) ?></td>
                            <td><?= date("d-m-Y", strtotime($row['updated_at'])) ?></td>
                            <td>
                                <button class="btn btn-outline-primary btn-sm edit-btn" data-id="<?= $row['id'] ?>" data-name="<?= $row['name'] ?>">
                                    <i class="bi bi-pencil"></i>
                                </button>

                                <button class="btn btn-outline-danger btn-sm delete-btn" data-id="<?= $row['id'] ?>" data-name="<?= $row['name'] ?>">
                                    <i class="bi bi-trash"></i>
                                </button>

                            </td>
                        </tr>
                        
                        <?php } ?>
                </tbody>
            </table>
        </div>

        <!-- Add Department Modal -->
        <div class="modal fade" id="addDeptModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Add Department</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form method="POST" action="add_department.php">
                    <div class="modal-body">

                        <div class="d-flex justify-content-between align-items-center">
                            <label class="form-label">Department Name</label>
                            <span class="error-message text-danger small d-none"></span>
                        </div>

                        <input type="text" name="department_name" class="form-control mb-3" data-required="true" data-error="Department name is required">

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Department</button>
                    </div>
                </form>

                </div>
            </div>
        </div>

        <!-- Edit Department Modal -->
        <div class="modal fade" id="editDeptModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Edit Department</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form method="POST" action="edit_department.php">
                    <div class="modal-body">

                        <input type="hidden" name="dept_id" id="editDeptId">

                        <div class="d-flex justify-content-between align-items-center">
                            <label class="form-label">Department Name</label>
                            <span class="error-message text-danger small d-none"></span>
                        </div>

                        <input type="text" name="department_name" id="editDeptName" class="form-control mb-3" data-required="true" data-error="Department name is required">

                    </div>

                    <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>

                </div>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div class="modal fade" id="deleteDeptModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title text-danger">Delete Department</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form method="POST" action="delete_department.php">
                    <div class="modal-body">

                        <input type="hidden" name="delete_id" id="deleteDeptId">

                        <p>Are you sure you want to delete this department?</p>
                        <p class="fw-bold text-danger mb-0" id="deleteDeptName"></p>

                    </div>

                    <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </form>

                </div>
            </div>
        </div>

    </div>
</div>

<script>

    document.querySelectorAll(".edit-btn").forEach(btn => {
        btn.addEventListener("click", () => {
            const id = btn.dataset.id;
            const name = btn.dataset.name;

            document.getElementById("editDeptId").value = id;
            document.getElementById("editDeptName").value = name;

            new bootstrap.Modal(document.getElementById("editDeptModal")).show();
        });
    });

    document.querySelectorAll(".delete-btn").forEach(btn => {
        btn.addEventListener("click", () => {
            const id = btn.dataset.id;
            const name = btn.dataset.name;

            document.getElementById("deleteDeptId").value = id;
            document.getElementById("deleteDeptName").innerText = name;

            new bootstrap.Modal(document.getElementById("deleteDeptModal")).show();
        });
    });
    
    const searchInput = document.getElementById("deptSearch");
    const tableRows = document.querySelectorAll("#deptTable tr");

    searchInput.addEventListener("keyup", function () {
        const keyword = this.value.toLowerCase().trim();

        tableRows.forEach(row => {
            const deptName = row.querySelector("td:nth-child(2)").innerText.toLowerCase();
            
            if (deptName.includes(keyword)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    });

</script>
