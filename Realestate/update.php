<?php
$conn = new mysqli("sql200.infinityfree.com", "if0_39282857", "G6wDbAohtp4I", "if0_39282857_realestate");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $phone = $_POST['phone'];
  $plot = $_POST['plot'];
  $new_status = $_POST['status'];
  $now = date("Y-m-d H:i:s");

  $sql = "UPDATE user_details SET 
          status = ?,
          registered_date = IF(? = 'Registered', ?, registered_date),
          booked_date = IF(? = 'Booked', ?, booked_date),
          agreement_date = IF(? = 'Agreement', ?, agreement_date)
          WHERE phone = ? AND plot = ?";

  $stmt = $conn->prepare($sql);
  $stmt->bind_param("sssssssss", $new_status, $new_status, $now, $new_status, $now, $new_status, $now, $phone, $plot);
  $stmt->execute();
  $message = "Status updated successfully.";
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Status</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <!-- Navigation Bar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand" href="index.php">RealEstate Portal</a>
      <div class="collapse navbar-collapse">
  <ul class="navbar-nav ms-auto">
             <li class="nav-item">
            <a class="nav-link" href="index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="book.php">Booking Form</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="User-data.php">User Submissions</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="Edit.php">Edit Status</a>
          </li>
           <li class="nav-item ms-4">
               <a class="btn btn-outline-light" href="logout.php">Logout</a>
         </li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="container mt-5">
    <h2 class="mb-4">Update User Status</h2>
    <?php if (isset($message)) echo "<div class='alert alert-success'>$message</div>"; ?>
    <form method="post" class="bg-white p-4 rounded shadow">
      <div class="mb-3">
        <label>Phone Number</label>
        <input type="text" name="phone" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Plot Number</label>
        <input type="text" name="plot" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>New Status</label>
        <select name="status" class="form-select" required>
          <option value="">Select status</option>
          <option value="Registered">Registered</option>
          <option value="Booked">Booked</option>
          <option value="Agreement">Agreement</option>
        </select>
      </div>
      <button type="submit" class="btn btn-warning">Update Status</button>
    </form>
    <a href="index.html" class="btn btn-secondary mt-3">Back to Form</a>
  </div>
</body>
</html>
