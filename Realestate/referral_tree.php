<?php
include 'db_config.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Fetch all users/plots
$users = $conn->query("SELECT id, plot, name FROM user_details ORDER BY plot ASC");

$allData = [];

while ($user = $users->fetch_assoc()) {
    $referrerId   = $user['id'];
    $referrerPlot = $user['plot'];
    $referrerName = $user['name'];

    // Fetch referrals for this user
    $query = "SELECT u.name, u.plot, u.status
              FROM referrals r 
              JOIN user_details u ON r.referred_user_id = u.id 
              WHERE r.referrer_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $referrerId);
    $stmt->execute();
    $result = $stmt->get_result();

    $children = [];
    $calculatedBonus = 0;

    while ($row = $result->fetch_assoc()) {
        if (in_array($row['status'], ['Agreement', 'Registered'])) {
            $calculatedBonus += 100000; // 1 Lakh per eligible referral
        }
        $children[] = $row;
    }

    $allData[] = [
        "id"       => $referrerId,
        "plot"     => $referrerPlot,
        "name"     => $referrerName,
        "bonus"    => $calculatedBonus,
        "children" => $children
    ];
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Referral Summary</title>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<style>
/* Table styling */
table {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 20px;
  page-break-inside: auto;
}
th, td {
  border: 1px solid #000;
  padding: 6px;
  text-align: left;
}
tr { page-break-inside: avoid; page-break-after: auto; }
thead { background: #343a40; color: white; }

/* Container */
#referrals-container { margin-top: 20px; }

/* Search bar */
#searchInput {
  max-width: 400px;
  margin-bottom: 20px;
}
</style>
</head>
<body class="container p-3">

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
          <li class="nav-item"><a class="nav-link active" href="referral_tree.php">View Referrals</a></li>
          <li class="nav-item"><a class="nav-link  " href="manage_referrals.php">Manage Referral</a></li> 
          <li class="nav-item ms-4"><a class="btn btn-outline-light" href="logout.php">Logout</a></li>
        </ul>
      </div>
    </div>
  </nav> <br/>

<h3 class="text-center mb-4">Referral Summary</h3>

<!-- Search -->
<input type="text" id="searchInput" class="form-control" placeholder="🔎 Search by Plot or Name">

<!-- Download Button -->
<div class="text-end mb-3">
  <button onclick="downloadAllPDF()" class="btn btn-danger">Download All Data (PDF)</button>
</div>

<!-- Data Section -->
<div id="referrals-container">
  <p class="text-end"><i>Downloaded on: <?php echo date("d-m-Y h:i A"); ?></i></p>

  <?php foreach ($allData as $tree): ?>
    <div class="referral-block mb-5">
      <h5>Plot <?php echo $tree['plot']; ?> – <?php echo $tree['name']; ?></h5>
      <p>Total Bonus: <b>₹<?php echo number_format($tree['bonus']); ?></b></p>

      <?php if (!empty($tree['children'])): ?>
      <table>
        <thead>
          <tr>
            <th>S.No</th>
            <th>Referral Name</th>
            <th>Plot</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php $i=1; foreach ($tree['children'] as $child): ?>
          <tr>
            <td><?php echo $i++; ?></td>
            <td><?php echo htmlspecialchars($child['name']); ?></td>
            <td><?php echo htmlspecialchars($child['plot']); ?></td>
            <td><?php echo htmlspecialchars($child['status']); ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <?php else: ?>
        <p><i>No referrals</i></p>
      <?php endif; ?>

      <hr>
    </div>
  <?php endforeach; ?>
</div>

<script>
// PDF Download
function downloadAllPDF() {
  const element = document.getElementById('referrals-container');
  const opt = {
    margin: 0.5,
    filename: 'referrals_summary.pdf',
    image: { type: 'jpeg', quality: 0.98 },
    html2canvas: { scale: 2 },
    jsPDF: { unit: 'in', format: 'a4', orientation: 'portrait' }
  };
  html2pdf().set(opt).from(element).save();
}

// Search Filter
document.getElementById('searchInput').addEventListener('keyup', function () {
  const val = this.value.toLowerCase();
  document.querySelectorAll('.referral-block').forEach(block => {
    block.style.display = block.innerText.toLowerCase().includes(val) ? '' : 'none';
  });
});
</script>
</body>
</html>
