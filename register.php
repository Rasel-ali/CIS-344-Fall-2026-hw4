
<?php

// Connect to the database
require_once 'db.php';

// Available membership plans
$plans = ['Starter', 'Standard', 'Premium'];

$selectedPlan = $_GET['plan'] ?? 'Standard';

if (!in_array($selectedPlan, $plans, true)) {
    $selectedPlan = 'Standard';
}

$success = false;
$error = '';

$name = '';
$email = '';
$phone = '';


// Process registration
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Collect form information
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $selectedPlan = $_POST['plan'] ?? '';

    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';


    // Validate information
    if (
        $name === '' ||
        !filter_var($email, FILTER_VALIDATE_EMAIL) ||
        $phone === '' ||
        !in_array($selectedPlan, $plans, true)
    ) {

        $error = 'Please enter valid information in all fields.';

    } elseif (strlen($password) < 8) {

        $error = 'Your password must contain at least 8 characters.';

    } elseif ($password !== $confirmPassword) {

        $error = 'Your passwords do not match.';

    } else {

        try {

            // Securely hash the password
            $hashedPassword = password_hash(
                $password,
                PASSWORD_DEFAULT
            );

            // Prepare SQL statement
            $sql = "INSERT INTO members
                    (name, email, phone, password, membership_plan)
                    VALUES (?, ?, ?, ?, ?)";

            $stmt = $conn->prepare($sql);

            // Connect form values to SQL placeholders
            $stmt->bind_param(
                "sssss",
                $name,
                $email,
                $phone,
                $hashedPassword,
                $selectedPlan
            );

            // Save member information
            $stmt->execute();

            $success = true;

            // Clear submitted form values
            $name = '';
            $email = '';
            $phone = '';

            $stmt->close();

        } catch (mysqli_sql_exception $e) {

            if ($e->getCode() === 1062) {

                $error = 'This email is already registered. Please log in.';

            } else {

                $error = 'Registration could not be completed. Please try again.';

                error_log($e->getMessage());
            }
        }
    }
}

include('header.php');

?>

<main>

<section class="register-section">

    <div class="register-container">

        <?php if ($success): ?>

            <!-- Successful Registration -->

            <div class="success-message">

                <div class="success-icon">✓</div>

                <p class="section-label">
                    REGISTRATION RECEIVED
                </p>

                <h1>WELCOME TO SMASHPOINT!</h1>

                <p>
                    Thank you, <?php echo htmlspecialchars($name ?: $_POST['name']); ?>!
                    Your membership information has been
                    successfully saved.
                </p>

                <div class="confirmation-details">

                    <p>
                        <strong>Membership:</strong>
                        <?php echo htmlspecialchars($selectedPlan); ?>
                    </p>

                    <p>
                        <strong>Email:</strong>
                        <?php echo htmlspecialchars($email ?: $_POST['email']); ?>
                    </p>

                    <p>
                        <strong>Status:</strong> Active
                    </p>

                </div>

                <a href="login.php" class="main-button">
                    LOG IN TO YOUR ACCOUNT →
                </a>

            </div>

        <?php else: ?>

            <!-- Registration Form -->

            <div class="register-heading">

                <p class="section-label">JOIN SMASHPOINT</p>

                <h1>LET'S GET YOU <span>REGISTERED.</span></h1>

                <p>
                    Create your membership account
                    and become part of our community.
                </p>

            </div>


            <?php if ($error): ?>

                <p class="form-error">
                    <?php echo htmlspecialchars($error); ?>
                </p>

            <?php endif; ?>


            <form action="register.php"
                  method="POST"
                  class="registration-form">

                <label for="name">Full Name</label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    placeholder="Enter your full name"
                    value="<?php echo htmlspecialchars($name); ?>"
                    maxlength="100"
                    autocomplete="name"
                    required
                >


                <label for="email">Email Address</label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    placeholder="Enter your email address"
                    value="<?php echo htmlspecialchars($email); ?>"
                    maxlength="150"
                    autocomplete="email"
                    required
                >


                <label for="phone">Phone Number</label>

                <input
                    type="tel"
                    id="phone"
                    name="phone"
                    placeholder="Enter your phone number"
                    value="<?php echo htmlspecialchars($phone); ?>"
                    maxlength="25"
                    autocomplete="tel"
                    required
                >


                <label for="plan">Membership Plan</label>

                <select id="plan" name="plan" required>

                    <option value="Starter"
                        <?php echo $selectedPlan === 'Starter' ? 'selected' : ''; ?>>
                        Starter Membership - $25/month
                    </option>

                    <option value="Standard"
                        <?php echo $selectedPlan === 'Standard' ? 'selected' : ''; ?>>
                        Standard Membership - $45/month
                    </option>

                    <option value="Premium"
                        <?php echo $selectedPlan === 'Premium' ? 'selected' : ''; ?>>
                        Premium Membership - $70/month
                    </option>

                </select>


                <label for="password">Create Password</label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Minimum 8 characters"
                    minlength="8"
                    autocomplete="new-password"
                    required
                >


                <label for="confirm_password">Confirm Password</label>

                <input
                    type="password"
                    id="confirm_password"
                    name="confirm_password"
                    placeholder="Re-enter your password"
                    minlength="8"
                    autocomplete="new-password"
                    required
                >


                <p class="privacy-note">
                    Your contact information will be used
                    for membership communication and account
                    management.
                </p>


                <button type="submit" class="register-button">
                    CREATE MY MEMBERSHIP →
                </button>

            </form>

        <?php endif; ?>

    </div>

</section>

</main>

<?php include('footer.php'); ?>
