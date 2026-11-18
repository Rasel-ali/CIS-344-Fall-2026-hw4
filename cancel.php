
<?php
session_start();
require_once 'db.php';

// Make sure the member is logged in
if (!isset($_SESSION['member_id'])) {
    header("Location: login.php");
    exit();
}

// Create a security token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$error = '';
$success = '';

// Process cancellation after confirmation
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $submittedToken = $_POST['csrf_token'] ?? '';

    if (!hash_equals($_SESSION['csrf_token'], $submittedToken)) {
        $error = "Invalid request. Please try again.";
    } else {

        $memberId = $_SESSION['member_id'];

        // Only cancel the currently logged-in member's account
        $sql = "UPDATE members
                SET membership_status = 'Cancelled',
                    cancellation_date = NOW()
                WHERE member_id = ?
                AND membership_status = 'Active'";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $memberId);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $success = "Your SmashPoint membership has been successfully cancelled.";
        } else {
            $error = "Your membership is already cancelled or is no longer active.";
        }

        $stmt->close();

        // Generate a new token after processing
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
}

include('header.php');
?>

<main>
<section class="register-section">

    <div class="register-container">

        <p class="section-label">MEMBERSHIP MANAGEMENT</p>

        <?php if ($success): ?>

            <h1>MEMBERSHIP <span>CANCELLED.</span></h1>

            <p><?php echo htmlspecialchars($success); ?></p>

            <p style="margin-top:20px;">
                Your account and membership history have been retained.
            </p>

            <a href="dashboard.php" class="main-button">
                RETURN TO DASHBOARD →
            </a>

        <?php elseif ($error): ?>

            <h1>REQUEST <span>NOTICE.</span></h1>

            <p class="form-error">
                <?php echo htmlspecialchars($error); ?>
            </p>

            <a href="dashboard.php" class="main-button">
                RETURN TO DASHBOARD →
            </a>

        <?php else: ?>

            <h1>CANCEL <span>MEMBERSHIP?</span></h1>

            <p>
                Are you sure you want to cancel your SmashPoint membership?
            </p>

            <p style="margin-top:15px; color:#bbbbbb;">
                Your membership status will change to Cancelled.
                Your account information and registration history
                will remain in our database.
            </p>

            <form action="cancel.php" method="POST"
                  style="margin-top:30px;">

                <input type="hidden" name="csrf_token"
                       value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">

                <button type="submit" class="register-button">
                    YES, CANCEL MY MEMBERSHIP
                </button>

            </form>

            <p style="margin-top:20px;">
                <a href="dashboard.php" style="color:#b7f36b;">
                    No, take me back to my dashboard
                </a>
            </p>

        <?php endif; ?>

    </div>

</section>
</main>

<?php include('footer.php'); ?>
