<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

$conn = new mysqli("sql200.infinityfree.com", "if0_39282857", "G6wDbAohtp4I", "if0_39282857_realestate");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$users = [];
$user = null;
$message = '';

// Step 1: Search
if (isset($_POST['search'])) {
  $search_value = $conn->real_escape_string($_POST['search_value']);
  $res = $conn->query("SELECT * FROM user_details WHERE phone = '$search_value' OR plot = '$search_value'");
  if ($res && $res->num_rows > 0) {
    while ($row = $res->fetch_assoc()) $users[] = $row;
  } else {
    $message = "<div class='alert alert-danger'>No records found for <strong>$search_value</strong>.</div>";
  }
}

// Step 2: Select user
if (isset($_POST['select'])) {
  $id = (int) $_POST['user_id'];
  $res = $conn->query("SELECT * FROM user_details WHERE id = $id LIMIT 1");
  if ($res && $res->num_rows > 0) {
    $user = $res->fetch_assoc();
  } else {
    $message = "<div class='alert alert-danger'>User not found.</div>";
  }
}

// Step 3: Update
if (isset($_POST['update'])) {
  $id = (int) $_POST['user_id'];
  $name = $conn->real_escape_string($_POST['name']);
  $phone = $conn->real_escape_string($_POST['phone']);
  $plot = $conn->real_escape_string($_POST['plot']);
  $status = $conn->real_escape_string($_POST['status']);
  $status_time = $_POST['status_time'];
  $dt = DateTime::createFromFormat('Y-m-d\TH:i', $status_time);

  if ($dt) {
    $formatted = $dt->format('Y-m-d H:i:s');
    $sql = "UPDATE user_details SET name = ?, phone = ?, plot = ?, status = ?, ";
    if ($status === 'Registered') $sql .= "registered_date = ?";
    elseif ($status === 'Booked') $sql .= "booked_date = ?";
    elseif ($status === 'Agreement') $sql .= "agreement_date = ?";
    else $message = "<div class='alert alert-danger'>Invalid status selected.</div>";

    $sql .= " WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $name, $phone, $plot, $status, $formatted, $id);
    $stmt->execute();
    $message = "<div class='alert alert-success'>User details updated successfully.</div>";
  } else {
    $message = "<div class='alert alert-danger'>Invalid date/time format.</div>";
  }
}

// Step 4: Delete
if (isset($_POST['delete'])) {
  $id = (int) $_POST['user_id'];
  $del = $conn->query("DELETE FROM user_details WHERE id = $id");
  $message = $del ? "<div class='alert alert-success'>User deleted successfully.</div>" :
                    "<div class='alert alert-danger'>Failed to delete user.</div>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Edit Booking Status</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body { background: #f8f9fa; }
    .form-wrapper { max-width: 720px; margin: 40px auto; }
    .table td { vertical-align: middle; }
    .spinner-border { width: 1.5rem; height: 1.5rem; }
    .navbar-brand { font-size: 1.5rem; }
    .navbar .nav-link.active { font-weight: bold; text-decoration: underline; }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="index.php">RealEstate Portal</a>
    <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="book.php">Booking Form</a></li>
        <li class="nav-item"><a class="nav-link" href="User-data.php">User Submissions</a></li>
        <li class="nav-item"><a class="nav-link active" href="Edit.php">Edit Status</a></li>
        <li class="nav-item"><a class="nav-link  " href="add_referral.php">Add Referral</a></li>
          <li class="nav-item"><a class="nav-link  " href="referral_tree.php">View Referral</a></li>
          <li class="nav-item"><a class="nav-link   " href="manage_referrals.php">Manage Referral</a></li> 
        <li class="nav-item ms-3"><a class="btn btn-outline-light" href="logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- Toast Message -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1100">
  <div id="toastAlert" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body" id="toastMessage">Success</div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>
</div>

<!-- Main Section -->
<div class="container mt-4">
  <h2 class="mb-4">🔍 Search Booking by Phone or Plot Number</h2>
  <form method="POST" class="row g-2 mb-3" onsubmit="showSpinner()">
    <div class="col-md-9">
      <input type="text" name="search_value" class="form-control" placeholder="Enter Phone or Plot Number" required />
    </div>
    <div class="col-md-3 d-flex align-items-center gap-2">
      <button type="submit" name="search" class="btn btn-primary w-100">Search</button>
      <div id="loader" class="spinner-border text-primary d-none" role="status"></div>
    </div>
  </form>

  <?= $message ?>

  <?php if (count($users) > 0): ?>
    <div class="table-responsive">
      <table class="table table-bordered">
        <thead class="table-secondary">
          <tr>
            <th>Name</th>
            <th>Phone</th>
            <th>Plot</th>
            <th>Status</th>
            <th>Last Updated</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($users as $u): ?>
            <tr>
              <td><?= htmlspecialchars($u['name']) ?></td>
              <td><?= htmlspecialchars($u['phone']) ?></td>
              <td><?= htmlspecialchars($u['plot']) ?></td>
              <td><?= htmlspecialchars($u['status']) ?></td>
              <td><?= htmlspecialchars($u['registered_date'] ?: $u['booked_date'] ?: $u['agreement_date']) ?></td>
              <td class="d-flex gap-2">
                <form method="POST" class="d-inline">
                  <input type="hidden" name="user_id" value="<?= $u['id'] ?>">
                  <button type="submit" name="select" class="btn btn-sm btn-warning">Edit</button>
                </form>
                <form method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this user?');">
                  <input type="hidden" name="user_id" value="<?= $u['id'] ?>">
                  <button type="submit" name="delete" class="btn btn-sm btn-danger">Delete</button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>

  <?php if ($user): ?>
    <div class="card mt-4">
      <div class="card-body">
        <h4>✏️ Update Details for <strong><?= htmlspecialchars($user['name']) ?></strong></h4>
        <form method="POST">
          <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
          <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Phone</label>
            <input type="text" name="phone" value="<?= htmlspecialchars($user['phone']) ?>" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Plot</label>
            <input type="text" name="plot" value="<?= htmlspecialchars($user['plot']) ?>" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select" >
              <option value="">Select Status</option>
              <option value="Registered" <?= $user['status'] === 'Registered' ? 'selected' : '' ?>>Registered</option>
              <option value="Booked" <?= $user['status'] === 'Booked' ? 'selected' : '' ?>>Booked</option>
              <option value="Agreement" <?= $user['status'] === 'Agreement' ? 'selected' : '' ?>>Agreement</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Status Date/Time</label>
            <input type="datetime-local" name="status_time" class="form-control"  >
          </div>
          <button type="submit" name="update" class="btn btn-success">Update</button>
        </form>
      </div>
    </div>
  <?php endif; ?>
</div>

<script>
  function showSpinner() {
    document.getElementById('loader').classList.remove('d-none');
  }

  window.addEventListener('DOMContentLoaded', () => {
    const alertDiv = document.querySelector('.alert');
    if (alertDiv) {
      const message = alertDiv.textContent.trim();
      document.getElementById('toastMessage').textContent = message;
      const toast = new bootstrap.Toast(document.getElementById('toastAlert'), { delay: 4000 });
      toast.show();
      alertDiv.remove();
    }
  });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
