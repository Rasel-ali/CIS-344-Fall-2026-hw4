
<?php
session_start();
require_once 'db.php';

// Make sure the member is logged in
if (!isset($_SESSION['member_id'])) {
    header("Location: login.php");
    exit();
}

// Create a CSRF token for secure cancellation requests
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Retrieve the logged-in member from MySQL
$memberId = $_SESSION['member_id'];

$sql = "SELECT member_id, name, email, phone,
               membership_plan, membership_status,
               registration_date, cancellation_date
        FROM members
        WHERE member_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $memberId);
$stmt->execute();

$result = $stmt->get_result();
$member = $result->fetch_assoc();

$stmt->close();

// If the account cannot be found, log the user out
if (!$member) {
    session_unset();
    session_destroy();

    header("Location: login.php");
    exit();
}

include('header.php');
?>

<main>

<section class="register-section">

    <div class="register-container">

        <p class="section-label">MEMBER DASHBOARD</p>

        <h1>
            WELCOME BACK,
            <span><?php echo htmlspecialchars($member['name']); ?>!</span>
        </h1>

        <p>Your SmashPoint membership information.</p>

        <div class="confirmation-details">

            <p>
                <strong>Member ID:</strong>
                <?php echo htmlspecialchars($member['member_id']); ?>
            </p>

            <p>
                <strong>Email:</strong>
                <?php echo htmlspecialchars($member['email']); ?>
            </p>

            <p>
                <strong>Phone:</strong>
                <?php echo htmlspecialchars($member['phone']); ?>
            </p>

            <p>
                <strong>Membership Plan:</strong>
                <?php echo htmlspecialchars($member['membership_plan']); ?>
            </p>

            <p>
                <strong>Status:</strong>
                <?php echo htmlspecialchars($member['membership_status']); ?>
            </p>

            <p>
                <strong>Registered:</strong>
                <?php echo htmlspecialchars($member['registration_date']); ?>
            </p>

            <?php if ($member['cancellation_date']): ?>

                <p>
                    <strong>Cancellation Date:</strong>
                    <?php echo htmlspecialchars($member['cancellation_date']); ?>
                </p>

            <?php endif; ?>

        </div>

        <?php if ($member['membership_status'] === 'Active'): ?>

            <a href="cancel.php"
               class="cancel-button">
                CANCEL MEMBERSHIP
            </a>

        <?php elseif ($member['membership_status'] === 'Cancelled'): ?>

            <p style="color:#bbbbbb; margin:20px 0;">
                Your membership has been cancelled.
            </p>

        <?php else: ?>

            <p style="color:#bbbbbb; margin:20px 0;">
                Your membership status is:
                <?php echo htmlspecialchars($member['membership_status']); ?>
            </p>

        <?php endif; ?>

        <br><br>

        <a href="logout.php" class="main-button">
            LOG OUT →
        </a>

    </div>

</section>

</main>

<?php include('footer.php'); ?>
