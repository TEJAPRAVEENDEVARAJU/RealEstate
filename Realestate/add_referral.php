<?php
include 'db_config.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}
error_reporting(E_ALL);
ini_set('display_errors', 1);

$message = "";

// ---------- Fetch all users for referrer options ----------
$referrerOptions = [];
$resAll = $conn->query("SELECT id, plot, name FROM user_details ORDER BY plot ASC");
while ($r = $resAll->fetch_assoc()) { $referrerOptions[] = $r; }

// ---------- Fetch users not yet referred ----------
$referredOptions = [];
$excludeIds = [];
$resEx = $conn->query("SELECT referred_user_id FROM referrals");
while ($e = $resEx->fetch_assoc()) { $excludeIds[] = (int)$e['referred_user_id']; }
$excludeList = $excludeIds ? implode(',', $excludeIds) : '0';
$sqlReferred = "SELECT id, plot, name FROM user_details WHERE id NOT IN ($excludeList) ORDER BY plot ASC";
$resRef = $conn->query($sqlReferred);
while ($r = $resRef->fetch_assoc()) { $referredOptions[] = $r; }

// ---------- Handle form submission ----------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['referrer_plot'])) {
    $referrerPlot = trim($_POST['referrer_plot']);

    // Resolve referrer ID
    $refStmt = $conn->prepare("SELECT id FROM user_details WHERE plot = ?");
    $refStmt->bind_param("s", $referrerPlot);
    $refStmt->execute();
    $refRow = $refStmt->get_result()->fetch_assoc();
    $referrerId = $refRow['id'] ?? 0;

    // Collect referred plots from dynamic inputs
    $referredPlots = [];
    foreach ($_POST as $key => $val) {
        if (strpos($key, 'referred_plot') === 0) {
            $val = trim($val);
            if ($val && !in_array($val, $referredPlots)) $referredPlots[] = $val;
        }
    }

    if (!$referrerId) {
        $message = "❌ Invalid referrer plot.";
    } elseif (empty($referredPlots)) {
        $message = "❌ Please select at least one referred plot.";
    } elseif (in_array($referrerPlot, $referredPlots, true)) {
        $message = "❌ Referrer plot cannot be the same as a referred plot.";
    } else {
        // Count existing referrals for this referrer
        $cntStmt = $conn->prepare("SELECT COUNT(*) AS total FROM referrals WHERE referrer_id = ?");
        $cntStmt->bind_param("i", $referrerId);
        $cntStmt->execute();
        $currentCount = (int)$cntStmt->get_result()->fetch_assoc()['total'];

        if ($currentCount >= 3) {
            $message = "❌ Max 3 referrals already reached for this referrer.";
        } else {
            $added = 0;
            foreach ($referredPlots as $referredPlot) {
                if ($currentCount + $added >= 3) break;

                // Resolve referred user id
                $rStmt = $conn->prepare("SELECT id FROM user_details WHERE plot = ?");
                $rStmt->bind_param("s", $referredPlot);
                $rStmt->execute();
                $rRow = $rStmt->get_result()->fetch_assoc();
                $referredUserId = $rRow['id'] ?? 0;

                if (!$referredUserId || $referredUserId === $referrerId) continue;

                // Ensure this user hasn't been referred by anyone
                $chk = $conn->prepare("SELECT 1 FROM referrals WHERE referred_user_id = ? LIMIT 1");
                $chk->bind_param("i", $referredUserId);
                $chk->execute();
                if ($chk->get_result()->num_rows) continue;

                $ins = $conn->prepare("INSERT INTO referrals (referrer_id, referred_user_id) VALUES (?, ?)");
                $ins->bind_param("ii", $referrerId, $referredUserId);
                if ($ins->execute()) $added++;
            }
            $message = $added > 0 ? "✅ $added referral(s) added successfully!" : "❌ No referrals added. They may already be referred or invalid.";
        }
    }

    // Refresh referred options
    $excludeIds = [];
    $resEx = $conn->query("SELECT referred_user_id FROM referrals");
    while ($e = $resEx->fetch_assoc()) { $excludeIds[] = (int)$e['referred_user_id']; }
    $excludeList = $excludeIds ? implode(',', $excludeIds) : '0';
    $referredOptions = [];
    $resRef = $conn->query("SELECT id, plot, name FROM user_details WHERE id NOT IN ($excludeList) ORDER BY plot ASC");
    while ($r = $resRef->fetch_assoc()) { $referredOptions[] = $r; }
}

// ---------- Fetch existing referrals for selected referrer ----------
$existingReferrals = [];
$remainingSlots = 3;
if (!empty($_POST['referrer_plot'])) {
    $referrerPlot = $_POST['referrer_plot'];
    $refStmt = $conn->prepare("SELECT id FROM user_details WHERE plot = ?");
    $refStmt->bind_param("s", $referrerPlot);
    $refStmt->execute();
    $refRow = $refStmt->get_result()->fetch_assoc();
    $referrerId = $refRow['id'] ?? 0;

    if ($referrerId) {
        $exStmt = $conn->prepare("
            SELECT ud.plot 
            FROM referrals r 
            JOIN user_details ud ON r.referred_user_id = ud.id 
            WHERE r.referrer_id = ? 
            ORDER BY r.id ASC
        ");
        $exStmt->bind_param("i", $referrerId);
        $exStmt->execute();
        $resExRef = $exStmt->get_result();
        while ($row = $resExRef->fetch_assoc()) {
            $existingReferrals[] = $row['plot'];
        }
        $remainingSlots = max(0, 3 - count($existingReferrals));
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Referral</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
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
          <li class="nav-item"><a class="nav-link active " href="add_referral.php">Add Referral</a></li>
          <li class="nav-item"><a class="nav-link " href="referral_tree.php">View Referrals</a></li> 
          <li class="nav-item"><a class="nav-link " href="manage_referrals.php">Manage Referral</a></li> 
          <li class="nav-item ms-4"><a class="btn btn-outline-light" href="logout.php">Logout</a></li>
        </ul>
      </div>
    </div>
  </nav>
  <br/>
  <h3 class="mb-3">Add Referral</h3>

  <?php if (!empty($message)): ?>
    <div class="alert alert-info"><?php echo $message; ?></div>
  <?php endif; ?>

  <form method="POST" class="card p-3 shadow-sm">
    <!-- Referrer -->
    <div class="mb-3">
      <label class="form-label">Referrer Plot No</label>
      <select class="form-select" name="referrer_plot" required onchange="this.form.submit()">
        <option value="">-- Select Referrer Plot --</option>
        <?php foreach ($referrerOptions as $p): ?>
          <option value="<?php echo htmlspecialchars($p['plot']); ?>" 
            <?php echo (($_POST['referrer_plot'] ?? '') == $p['plot']) ? 'selected' : ''; ?>>
            <?php echo "Plot " . htmlspecialchars($p['plot']) . " - " . htmlspecialchars($p['name']); ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <!-- Existing referrals display -->
    <?php foreach ($existingReferrals as $index => $plot): ?>
      <div class="mb-3">
        <label class="form-label">Referred Plot <?php echo ($index + 1); ?> (Already Added)</label>
        <input type="text" class="form-control" value="<?php echo htmlspecialchars($plot); ?>" disabled>
      </div>
    <?php endforeach; ?>

    <!-- Remaining referral slots -->
    <?php for ($i = 0; $i < $remainingSlots; $i++): ?>
      <div class="mb-3">
        <label class="form-label">Add Referred Plot</label>
        <select class="form-select referred-select" name="referred_plot<?php echo $i+1; ?>">
          <option value="">-- Select Plot --</option>
          <?php foreach ($referredOptions as $p): ?>
            <option value="<?php echo htmlspecialchars($p['plot']); ?>">
              <?php echo "Plot " . htmlspecialchars($p['plot']) . " - " . htmlspecialchars($p['name']); ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
    <?php endfor; ?>

    <button type="submit" class="btn btn-primary">Add Referral(s)</button>
    <a href="referral_tree.php" class="btn btn-secondary">View Referrals</a>
  </form>

  <script>
    // Prevent selecting the same referred plot in multiple dropdowns
    const selects = Array.from(document.querySelectorAll('.referred-select'));
    function refreshDisables() {
      const chosen = new Set(selects.map(s => s.value).filter(v => v));
      selects.forEach(sel => {
        Array.from(sel.options).forEach(opt => {
          if (!opt.value) return;
          opt.disabled = (chosen.has(opt.value) && sel.value !== opt.value);
        });
      });
    }
    selects.forEach(sel => sel.addEventListener('change', refreshDisables));
    refreshDisables();
  </script>
</body>
</html>
