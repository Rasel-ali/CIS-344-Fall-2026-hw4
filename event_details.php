
<?php
require_once 'db.php';

date_default_timezone_set('America/New_York');

// Get event ID from URL
$eventId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$event = null;

if ($eventId > 0) {

    // Retrieve event only if it has not expired
    $sql = "SELECT *
            FROM community_events
            WHERE event_id = ?
              AND event_datetime > NOW()";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $eventId);
    $stmt->execute();

    $result = $stmt->get_result();
    $event = $result->fetch_assoc();

    $stmt->close();
}

include('header.php');
?>

<main>

    <section class="page-hero">
        <div class="container">
            <p class="section-label">SMASHPOINT COMMUNITY</p>
            <h1>EVENT <span>DETAILS.</span></h1>
        </div>
    </section>

    <section class="event-details-section container">

        <?php if ($event): ?>

            <div class="event-details-card">

                <p class="section-label">COMMUNITY EVENT</p>

                <h2>
                    <?php echo htmlspecialchars($event['event_name']); ?>
                </h2>

                <div class="event-detail-item">
                    <strong>LOCATION</strong>
                    <p>
                        <?php echo htmlspecialchars($event['event_location']); ?>
                    </p>
                </div>

                <div class="event-detail-item">
                    <strong>DATE</strong>
                    <p>
                        <?php echo date('F j, Y', strtotime($event['event_datetime'])); ?>
                    </p>
                </div>

                <div class="event-detail-item">
                    <strong>TIME</strong>
                    <p>
                        <?php echo date('g:i A', strtotime($event['event_datetime'])); ?>
                    </p>
                </div>

                <div class="event-detail-item">
                    <strong>ABOUT THIS EVENT</strong>
                    <p class="event-full-description">
                        <?php echo nl2br(htmlspecialchars($event['event_description'])); ?>
                    </p>
                </div>

                <a href="events.php" class="main-button">
                    ← BACK TO CALENDAR
                </a>

            </div>

        <?php else: ?>

            <div class="no-events">
                <h2>EVENT NOT FOUND.</h2>

                <p>
                    This event may have expired or may no longer be available.
                </p>

                <a href="events.php" class="main-button">
                    VIEW COMMUNITY CALENDAR →
                </a>
            </div>

        <?php endif; ?>

    </section>

</main>

<?php include('footer.php'); ?>
