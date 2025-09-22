<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Plot Booking Form</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
  <style>/* style.css */

body {
  background: #f8f9fa;
  /* font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; */
}

.form-wrapper {
  max-width: 650px;
  margin: 40px auto;
}

.form-card {
  background: #fff;
  border-radius: 12px;
  padding: 30px;
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
  transition: 0.3s ease-in-out;
}

.form-card:hover {
  transform: scale(1.01);
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
<body class="bg-light">

  <!-- Navigation Bar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand" href="index.php">RealEstate Portal</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
          <li class="nav-item"><a class="nav-link active" href="book.php">Booking Form</a></li>
          <li class="nav-item"><a class="nav-link" href="User-data.php">User Submissions</a></li>
          <li class="nav-item"><a class="nav-link" href="Edit.php">Edit Status</a></li>
          <li class="nav-item"><a class="nav-link " href="add_referral.php">Add Referral</a></li>
          <li class="nav-item"><a class="nav-link " href="referral_tree.php">View Referral</a></li>
          <li class="nav-item"><a class="nav-link " href="manage_referrals.php">Manage Referral</a></li> 
          <li class="nav-item ms-4"><a class="btn btn-outline-light" href="logout.php">Logout</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Main Form Section -->
  <div class="container mt-5">
    <h2 class="mb-4 text-center">Plot Registration / Booking Form</h2>

    <form id="userForm" class="p-4 bg-white shadow rounded">
      <div class="mb-3">
        <label for="name" class="form-label">Full Name</label>
        <input type="text" class="form-control" id="name" required />
      </div>

      <div class="mb-3">
        <label for="phone" class="form-label">Phone Number</label>
        <input type="tel" class="form-control" id="phone" required />
      </div>

      <div class="mb-3">
        <label for="plot" class="form-label">Plot Number</label>
        <input type="text" class="form-control" id="plot" required />
      </div>

      <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <select class="form-select" id="status" required>
          <option value="">Select status</option>
          <option value="Registered">Registered</option>
          <option value="Booked">Booked</option>
          <option value="Agreement">Agreement</option>
        </select>
      </div>

      <div class="mb-3">
        <label for="date" class="form-label">Date</label>
        <input type="date" class="form-control" id="date" required />
      </div>

      <div class="d-grid">
        <!-- ✅ Ensure type="submit" is present -->
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>

    <div id="responseMsg" class="mt-3"></div>

    <div class="row mt-4 g-2">
      <div class="col-12 col-md-6 d-grid">
        <a href="User-data.php" class="btn btn-success">View Submissions</a>
      </div>
      <div class="col-12 col-md-6 d-grid">
        <a href="Edit.php" class="btn btn-warning">Edit User Status</a>
      </div>
    </div>
  </div>

  <!-- JS Submission Logic -->
  <script>
    document.getElementById('userForm').addEventListener('submit', async (e) => {
      e.preventDefault();

      const name = document.getElementById('name').value.trim();
      const phone = document.getElementById('phone').value.trim();
      const plot = document.getElementById('plot').value.trim();
      const status = document.getElementById('status').value;
      const date = document.getElementById('date').value;

      if (!name || !phone || !plot || !status || !date) {
        document.getElementById('responseMsg').innerHTML =
          `<div class="alert alert-danger">All fields are required.</div>`;
        return;
      }

      try {
        const res = await fetch('Submit.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ name, phone, plot, status, date })
        });

        const result = await res.json();

        document.getElementById('responseMsg').innerHTML =
          `<div class="alert alert-${res.ok ? 'success' : 'danger'}">${result.message}</div>`;

        if (res.ok) {
          setTimeout(() => {
            window.location.href = "User-data.php";
          }, 1500);
        }

      } catch (error) {
        document.getElementById('responseMsg').innerHTML =
          `<div class="alert alert-danger">Error submitting data.</div>`;
      }
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
