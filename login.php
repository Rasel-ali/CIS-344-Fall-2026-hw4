
<?php
/* What the code here does are four important concepts:
1. session_start() creates or resumes a member session.
2. The SQL query searches for a member using their email.
3. password_verify() checks their password against the stored password hash.
4. header("Location: dashboard.php") redirects successful members to their dashboard.*/


// so here start the member session
session_start();

// Connect to MySQL database
require_once 'db.php';

$error = '';
$email = '';


// Process login form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {

        $error = 'Please enter your email and password.';

    } else {

        // Find member using their email
        $sql = "SELECT member_id, name, email, password,
                       membership_plan, membership_status
                FROM members
                WHERE email = ?";

        $stmt = $conn->prepare($sql);

        $stmt->bind_param("s", $email);

        $stmt->execute();

        $result = $stmt->get_result();

        if ($member = $result->fetch_assoc()) {

            // Verify submitted password against stored hash
            if (password_verify($password, $member['password'])) {

                // Prevent session fixation
                session_regenerate_id(true);

                // Store member information in session
                $_SESSION['member_id'] = $member['member_id'];
                $_SESSION['member_name'] = $member['name'];

                // Redirect to member dashboard
                header("Location: dashboard.php");
                exit();

            } else {

                $error = 'Incorrect email or password.';

            }

        } else {

            $error = 'Incorrect email or password.';

        }

        $stmt->close();
    }
}

include('header.php');

?>

<main>

<section class="register-section">

    <div class="register-container">

        <div class="register-heading">

            <p class="section-label">MEMBER ACCESS</p>

            <h1>WELCOME <span>BACK.</span></h1>

            <p>
                Log in to view and manage your
                SmashPoint membership.
            </p>

        </div>


        <?php if ($error): ?>

            <p class="form-error">
                <?php echo htmlspecialchars($error); ?>
            </p>

        <?php endif; ?>


        <form action="login.php"
              method="POST"
              class="registration-form">

            <label for="email">Email Address</label>

            <input
                type="email"
                id="email"
                name="email"
                placeholder="Enter your registered email"
                value="<?php echo htmlspecialchars($email); ?>"
                autocomplete="username"
                required
            >


            <label for="password">Password</label>

            <input
                type="password"
                id="password"
                name="password"
                placeholder="Enter your password"
                autocomplete="current-password"
                required
            >


            <button type="submit" class="register-button">
                LOG IN TO MY ACCOUNT →
            </button>

        </form>

        <p class="privacy-note">
            Don't have an account?
            <a href="register.php"
               style="color: #b7f36b;">
                Register here.
            </a>
        </p>

    </div>

</section>

</main>

<?php include('footer.php'); ?>
