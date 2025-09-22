<?php
include 'db_config.php';

$userId = intval($_POST['user_id']);
$newStatus = $_POST['status'];

// Update the user status
$stmt = $conn->prepare("UPDATE user_details SET status = ? WHERE id = ?");
$stmt->bind_param("si", $newStatus, $userId);
$stmt->execute();

// If status changed to Agreement → credit referrer
if ($newStatus === "Agreement") {
    $findRef = $conn->prepare("SELECT referrer_id FROM referrals WHERE referred_user_id = ?");
    $findRef->bind_param("i", $userId);
    $findRef->execute();
    $findRef->bind_result($referrerId);

    if ($findRef->fetch()) {
        $bonus = $conn->prepare("UPDATE user_details SET referral_bonus = referral_bonus + 100000 WHERE id = ?");
        $bonus->bind_param("i", $referrerId);
        $bonus->execute();
    }
}

echo "Status updated successfully!";
?>
