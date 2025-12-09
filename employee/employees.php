<?php include $_SERVER['DOCUMENT_ROOT'] . '/ShiftTrack/config.php';?>
<?php include ROOT_PATH . 'includes/navbar.php'; ?>
<?php include ROOT_PATH . 'includes/sidebar.php'; ?>
<?php include ROOT_PATH . 'database.php'; ?>


<div class="main-content">
    <div class="container-fluid">

        <!-- Header Row -->
        <div class="d-flex justify-content-between align-items-start mt-1">
            <div>
                <h3>Employees</h3>
                <p class="text-muted">Manage employee records and profiles</p>
            </div>

            <button class="btn btn-primary d-flex align-items-center mt-2" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">
                <i class="bi bi-person-plus me-2"></i> Add Employee
            </button>
        </div>

        <!-- Search & Filter -->
        <div class="card p-3 mt-3">
            <div class="row g-2">

                <!-- Search Input -->
                <div class="col-md-6">
                    <div class="search-input-container w-100">
                        <i class="bi bi-search search-icon"></i>
                        <input type="text" id="employeeSearch" class="form-control search-input" placeholder="Search by name, email, or phone...">
                    </div>
                </div>
            </div>
        </div>

        <!-- Employees Table -->
        <div class="card mt-3">
            <table class="table align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Employee</th>
                        <th>Department</th>
                        <th>Contact</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody id="employeeTable">
                    <?php
                            $query = $connection->query(
                                "SELECT e.*, d.name AS department_name 
                                     FROM employees e 
                                     JOIN departments d ON e.department_id = d.id
                                     ORDER BY e.id DESC");

                            foreach ($query as $row){?>
                                <tr>
                                <td><?= $row['id'] ?></td>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div>
                                            <strong><?= $row['name'] ?></strong><br>
                                            <small class="text-muted"><?= $row['email'] ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge bg-light text-dark"><?= $row['department_name'] ?></span></td>
                                <td><?= $row['phone'] ?></td>
                                <td>
                                    <button class="btn btn-outline-primary btn-sm edit-btn"
                                        data-id="<?= $row['id'] ?>"
                                        data-name="<?= $row['name'] ?>"
                                        data-email="<?= $row['email'] ?>"
                                        data-phone="<?= $row['phone'] ?>"
                                        data-dept="<?= $row['department_id'] ?>">
                                        <i class="bi bi-pencil"></i>
                                    </button>

                                    <button class="btn btn-outline-danger btn-sm delete-btn"
                                        data-id="<?= $row['id'] ?>"
                                        data-name="<?= $row['name'] ?>">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php } ?>

                </tbody>
            </table>
        </div>

        <!-- Add Employee Modal -->
        <div class="modal fade" id="addEmployeeModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Add Employee</h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <form action="add_employee.php" method="POST">
                        <div class="modal-body">

                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control mb-3" required>

                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control mb-3" required>

                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control mb-3" required>

                            <select name="department" class="form-select" required>
                                <option disabled selected>Select Department</option>
                                <?php
                                    $dep = $connection->query("SELECT id,name FROM departments ORDER BY name ASC");
                                    foreach ($dep as $d) {
                                        echo "<option value='{$d['id']}'>{$d['name']}</option>";
                                    }
                                ?>
                            </select>


                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Add Employee</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

        <!-- Edit Employee Modal -->
        <div class="modal fade" id="editEmployeeModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Edit Employee</h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <form action="edit_employee.php" method="POST">
                        <div class="modal-body">

                            <input type="hidden" name="id" id="editId">

                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" id="editName" class="form-control mb-3" required>

                            <label class="form-label">Email</label>
                            <input type="email" name="email" id="editEmail" class="form-control mb-3" required>

                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" id="editPhone" class="form-control mb-3" required>

                            <label class="form-label">Department</label>
                            <select name="department" id="editDept" class="form-select" required>
                                <?php
                                    $dep = $connection->query("SELECT id, name FROM departments ORDER BY name ASC");
                                    foreach ($dep as $d) {
                                        echo "<option value='{$d['id']}'>{$d['name']}</option>";
                                    }
                                ?>
                            </select>


                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>


        <!-- Delete Employee Modal -->
        <div class="modal fade" id="deleteEmployeeModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title text-danger">Delete Employee</h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <form action="delete_employee.php" method="POST">
                        <div class="modal-body">

                            <input type="hidden" name="id" id="deleteId">

                            <p>Are you sure you want to delete this employee?</p>
                            <p class="fw-bold text-danger" id="deleteName"></p>

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

            document.getElementById("editId").value = btn.dataset.id;
            document.getElementById("editName").value = btn.dataset.name;
            document.getElementById("editEmail").value = btn.dataset.email;
            document.getElementById("editPhone").value = btn.dataset.phone;
            document.getElementById("editDept").value = btn.dataset.dept;

            new bootstrap.Modal(document.getElementById("editEmployeeModal")).show();
        });
    });


    document.querySelectorAll(".delete-btn").forEach(btn => {
        btn.addEventListener("click", () => {

            document.getElementById("deleteId").value = btn.dataset.id;
            document.getElementById("deleteName").innerText = btn.dataset.name;

            new bootstrap.Modal(document.getElementById("deleteEmployeeModal")).show();
        });
    });

    const searchInput = document.getElementById("employeeSearch");
    const rows = document.querySelectorAll("#employeeTable tr");

    function filterEmployees() {
        const searchText = searchInput.value.toLowerCase().trim();

        rows.forEach(row => {
            const name = row.querySelector("td:nth-child(2) strong").innerText.toLowerCase();
            const email = row.querySelector("td:nth-child(2) small").innerText.toLowerCase();
            const phone = row.querySelector("td:nth-child(4)").innerText.toLowerCase();

            const matchesSearch =
                name.includes(searchText) ||
                email.includes(searchText) ||
                phone.includes(searchText);

            row.style.display = matchesSearch ? "" : "none";
        });
    }

    searchInput.addEventListener("keyup", filterEmployees);

</script>

