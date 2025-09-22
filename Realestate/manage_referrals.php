<?php
include 'db_config.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Handle delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $conn->query("DELETE FROM referrals WHERE id = $id");
    header("Location: manage_referrals.php?msg=Referral deleted");
    exit;
}

// Fetch all referrals with names & plots
$query = "
  SELECT r.id, 
         ur.plot AS referrer_plot, ur.name AS referrer_name, ur.phone AS referrer_phone,
         ue.plot AS referred_plot, ue.name AS referred_name, ue.phone AS referred_phone, ue.status
  FROM referrals r
  JOIN user_details ur ON r.referrer_id = ur.id
  JOIN user_details ue ON r.referred_user_id = ue.id
  ORDER BY r.id DESC
";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Referrals</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet"/>
  <link href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css" rel="stylesheet"/>
</head>
<body class="container mt-5">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand" href="index.php">RealEstate Portal</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
          <li class="nav-item"><a class="nav-link " href="book.php">Booking Form</a></li>
          <li class="nav-item"><a class="nav-link" href="User-data.php">User Submissions</a></li>
          <li class="nav-item"><a class="nav-link" href="Edit.php">Edit Status</a></li>
          <li class="nav-item"><a class="nav-link " href="add_referral.php">Add Referral</a></li>
          <li class="nav-item"><a class="nav-link " href="referral_tree.php">View Referrals</a></li> 
          <li class="nav-item"><a class="nav-link active  " href="manage_referrals.php">Manage Referral</a></li> 
          <li class="nav-item ms-4"><a class="btn btn-outline-light" href="logout.php">Logout</a></li>
        </ul>
      </div>
    </div>
  </nav>
  <br/>
  <h2 class="mb-4 text-center">📋 Manage Referrals</h2>

  <?php if (isset($_GET['msg'])): ?>
    <div class="alert alert-success"><?php echo htmlspecialchars($_GET['msg']); ?></div>
  <?php endif; ?>

  <div class="table-responsive bg-white p-3 shadow rounded">
    <table id="refTable" class="table table-bordered table-striped align-middle">
      <thead class="table-dark">
        <tr>
           
          <th>Referrer Plot</th>
          <th>Referrer Name</th>
          <th>Referrer Phone</th>
          <th>Referred Plot</th>
          <th>Referred Name</th>
          <th>Referred Phone</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            
            <td><?= htmlspecialchars($row['referrer_plot']) ?></td>
            <td><?= htmlspecialchars($row['referrer_name']) ?></td>
            <td><?= htmlspecialchars($row['referrer_phone']) ?></td>
            <td><?= htmlspecialchars($row['referred_plot']) ?></td>
            <td><?= htmlspecialchars($row['referred_name']) ?></td>
            <td><?= htmlspecialchars($row['referred_phone']) ?></td>
            <td><?= htmlspecialchars($row['status']) ?></td>
            <td>
              <a href="?delete=<?= $row['id'] ?>" 
                 class="btn btn-sm btn-danger"
                 onclick="return confirm('Are you sure you want to delete this referral?')">Delete</a>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>

  <a href="add_referral.php" class="btn btn-primary mt-3">➕ Add New Referral</a>

  <!-- Scripts -->
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
      $('#refTable').DataTable({
        dom: 'Bfrtip',
        buttons: ['copy', 'excel', 'csv', 'pdf', 'print'],
        order: [[0, 'desc']]
      });
    });
  </script>

</body>
</html>
