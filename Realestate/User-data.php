<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}
$conn = new mysqli("sql200.infinityfree.com", "if0_39282857", "G6wDbAohtp4I", "if0_39282857_realestate");
$result = $conn->query("SELECT * FROM user_details ORDER BY id");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>User Submissions</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
  <link href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="style.css" />
  <style>
    .badge-Registered { background-color: #0d6efd; }
    .badge-Booked     { background-color: #ffc107; color: black; }
    .badge-Agreement  { background-color: #198754; }
    .table-wrapper {
      background: #fff;
      padding: 25px;
      border-radius: 16px;
      box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
    }
    td, th {
      vertical-align: middle !important;
    }
    /* style.css */

body {
  background: #f8f9fa;
  /* font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; */
}

h2 {
  font-weight: 600;
  color: #333;
}

label {
  font-weight: 500;
}

.navbar-brand {
  font-size: 1.5rem;
}

.navbar .nav-link.active {
  font-weight: bold;
  text-decoration: underline;
}

  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold" href="index.php">🏡 RealEstate Portal</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto gap-3">
        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="book.php">Booking Form</a></li>
        <li class="nav-item"><a class="nav-link active" href="User-data.php">User Submissions</a></li>
        <li class="nav-item"><a class="nav-link" href="Edit.php">Edit Status</a></li>
        <li class="nav-item"><a class="nav-link  " href="add_referral.php">Add Referral</a></li>
          <li class="nav-item"><a class="nav-link  " href="referral_tree.php">View Referral</a></li>
          <li class="nav-item"><a class="nav-link   " href="manage_referrals.php">Manage Referral</a></li> 
        <li class="nav-item"><a class="btn btn-outline-light" href="logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- Page Content -->
<div class="container mt-5 mb-5">
  <h2 class="text-center mb-4">📄 User Submissions</h2>

  <!-- Exact Match Filter -->
  <div class="mb-3">
    <input type="text" id="searchExact" class="form-control form-control-lg" placeholder="🔎 Search by Plot or Phone (Exact)" />
  </div>

  <!-- Table -->
  <div class="table-responsive table-wrapper">
    <table id="userTable" class="table table-bordered table-hover align-middle">
      <thead class="table-dark">
        <tr>
          <th>S.No</th>
          <th>Name</th>
          <th>Phone</th>
          <th>Plot</th>
          <th>Status</th>
          <th>Registered Date</th>
          <th>Booked Date</th>
          <th>Agreement Date</th>
        </tr>
      </thead>
      <tbody>
        <?php $i = 1; while($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= $i++ ?></td>
          <td><?= htmlspecialchars($row['name']) ?></td>
          <td><?= htmlspecialchars($row['phone']) ?></td>
          <td><?= htmlspecialchars($row['plot']) ?></td>
          <td><span class="badge badge-<?= htmlspecialchars($row['status']) ?>"><?= htmlspecialchars($row['status']) ?></span></td>
          <td><?= $row['registered_date'] ? date("d-m-Y h:i A", strtotime($row['registered_date'])) : '-' ?></td>
          <td><?= $row['booked_date'] ? date("d-m-Y h:i A", strtotime($row['booked_date'])) : '-' ?></td>
          <td><?= $row['agreement_date'] ? date("d-m-Y h:i A", strtotime($row['agreement_date'])) : '-' ?></td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

<script>
$(document).ready(function () {
  const table = $('#userTable').DataTable({
    dom: 'Bfrtip',
    buttons: [
      'copy', 'excel', 'csv', 'pdf',
      {
        extend: 'print',
        text: 'Print',
        customize: function (win) {
          $(win.document.body)
            .css('font-size', '14px')
            .prepend('<h3 class="text-center">User Submissions</h3>');

          $(win.document.body).find('table')
            .addClass('table table-bordered table-sm')
            .css('font-size', 'inherit');
        }
      }
    ],
    order: [[0, 'asc']]
  });

  // Exact match for plot or phone
  $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
    const searchVal = $('#searchExact').val().trim();
    const phone = data[2].trim();
    const plot = data[3].trim();
    return !searchVal || searchVal === phone || searchVal === plot;
  });

  $('#searchExact').on('keyup change', function () {
    table.draw();
  });
});
</script>
</body>
</html>
