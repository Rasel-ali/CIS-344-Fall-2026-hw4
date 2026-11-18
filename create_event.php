
<?php
require_once 'db.php';

$error = '';
$success = false;

$eventName = '';
$eventLocation = '';
$eventDateTime = '';
$eventDescription = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $eventName = trim($_POST['event_name'] ?? '');
    $eventLocation = trim($_POST['event_location'] ?? '');
    $eventDateTime = trim($_POST['event_datetime'] ?? '');
    $eventDescription = trim($_POST['event_description'] ?? '');

    // Check required fields
    if (
        $eventName === '' ||
        $eventLocation === '' ||
        $eventDateTime === '' ||
        $eventDescription === ''
    ) {
        $error = 'Please complete all fields.';
    } elseif (
        strlen($eventName) > 150 ||
        strlen($eventLocation) > 255
    ) {
        $error = 'The event name or location is too long.';
    } else {

        // Validate the date and time
        $eventDate = DateTime::createFromFormat(
            'Y-m-d\TH:i',
            $eventDateTime
        );

        $dateErrors = DateTime::getLastErrors();

        if (
            !$eventDate ||
            ($dateErrors !== false &&
            ($dateErrors['warning_count'] > 0 ||
             $dateErrors['error_count'] > 0)) ||
            $eventDate->format('Y-m-d\TH:i') !== $eventDateTime
        ) {
            $error = 'Please enter a valid event date and time.';
        } elseif ($eventDate <= new DateTime()) {
            $error = 'Your event must be scheduled for a future date and time.';
        } else {

            // Convert datetime-local format for MySQL
            $mysqlDateTime = $eventDate->format('Y-m-d H:i:s');

            // Save event to database
            $sql = "INSERT INTO community_events
                    (event_name, event_location, event_datetime,
                     event_description)
                    VALUES (?, ?, ?, ?)";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param(
                "ssss",
                $eventName,
                $eventLocation,
                $mysqlDateTime,
                $eventDescription
            );

            if ($stmt->execute()) {
                $success = true;

                // Clear form fields
                $eventName = '';
                $eventLocation = '';
                $eventDateTime = '';
                $eventDescription = '';
            } else {
                $error = 'Something went wrong. Please try again.';
            }

            $stmt->close();
        }
    }
}

include('header.php');
?>

<main>

    <!-- Page Hero -->
    <section class="page-hero">
        <div class="container">
            <p class="section-label">SMASHPOINT COMMUNITY</p>

            <h1>
                CREATE YOUR<br>
                <span>OWN EVENT.</span>
            </h1>

            <p>
                Organizing a tournament, casual game, or badminton
                meetup? Bring the community together.
            </p>
        </div>
    </section>


    <!-- Event Submission Form -->
    <section class="register-section">

        <div class="register-container">

            <div class="register-heading">
                <p class="section-label">EVENT SUBMISSION</p>

                <h2>POST AN EVENT.</h2>

                <p>
                    Share your next badminton event with everyone.
                    No membership required.
                </p>
            </div>


            <?php if ($success): ?>

                <div class="event-success">
                    <h3>EVENT POSTED SUCCESSFULLY!</h3>

                    <p>
                        Your event has been added to the
                        SmashPoint community calendar.
                    </p>

                    <a href="events.php" class="register-button">
                        VIEW COMMUNITY EVENTS →
                    </a>
                </div>

            <?php else: ?>

                <?php if ($error): ?>
                    <p class="form-error">
                        <?php echo htmlspecialchars($error); ?>
                    </p>
                <?php endif; ?>


                <form action="create_event.php"
                      method="POST"
                      class="registration-form">

                    <label for="event_name">Event Name</label>

                    <input
                        type="text"
                        id="event_name"
                        name="event_name"
                        placeholder="e.g. Saturday Badminton Meetup"
                        maxlength="150"
                        value="<?php echo htmlspecialchars($eventName); ?>"
                        required
                    >


                    <label for="event_location">Event Location</label>

                    <input
                        type="text"
                        id="event_location"
                        name="event_location"
                        placeholder="e.g. Bronx, NY - St. Mary's Park"
                        maxlength="255"
                        value="<?php echo htmlspecialchars($eventLocation); ?>"
                        required
                    >


                    <label for="event_datetime">Date and Time</label>

                    <input
                        type="datetime-local"
                        id="event_datetime"
                        name="event_datetime"
                        value="<?php echo htmlspecialchars($eventDateTime); ?>"
                        min="<?php echo date('Y-m-d\TH:i'); ?>"
                        required
                    >


                    <label for="event_description">Event Description</label>

                    <textarea
                        id="event_description"
                        name="event_description"
                        rows="6"
                        placeholder="Tell people what your event is about, who can join, and what they should bring..."
                        required
                    ><?php echo htmlspecialchars($eventDescription); ?></textarea>


                    <button type="submit" class="register-button">
                        POST MY EVENT →
                    </button>

                </form>

            <?php endif; ?>

        </div>

    </section>

</main>

<?php include('footer.php'); ?>
