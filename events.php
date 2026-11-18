
<?php
require_once 'db.php';

date_default_timezone_set('America/New_York');

// Get selected month and year
$month = isset($_GET['month']) ? (int)$_GET['month'] : (int)date('n');
$year = isset($_GET['year']) ? (int)$_GET['year'] : (int)date('Y');

// Validate month and year
if ($month < 1 || $month > 12 || $year < 2020 || $year > 2100) {
    $month = (int)date('n');
    $year = (int)date('Y');
}

// Calculate calendar dates
$firstDay = new DateTime("$year-$month-01");
$daysInMonth = (int)$firstDay->format('t');
$startingWeekday = (int)$firstDay->format('N'); // Monday = 1

$monthStart = $firstDay->format('Y-m-01 00:00:00');
$nextMonth = (clone $firstDay)->modify('first day of next month');
$monthEnd = $nextMonth->format('Y-m-01 00:00:00');

// Get upcoming events for the selected month
$sql = "SELECT event_id, event_name, event_location,
               event_datetime
        FROM community_events
        WHERE event_datetime >= ?
          AND event_datetime < ?
          AND event_datetime > NOW()
        ORDER BY event_datetime ASC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $monthStart, $monthEnd);
$stmt->execute();

$result = $stmt->get_result();

// Organize events by calendar date
$eventsByDate = [];

while ($event = $result->fetch_assoc()) {
    $eventDate = date('Y-m-d', strtotime($event['event_datetime']));
    $eventsByDate[$eventDate][] = $event;
}

$stmt->close();

// Previous and next month
$previousMonth = (clone $firstDay)->modify('-1 month');
$nextMonthDate = (clone $firstDay)->modify('+1 month');

include('header.php');
?>

<main>

    <!-- Calendar Hero -->
    <section class="page-hero">
        <div class="container">
            <p class="section-label">SMASHPOINT COMMUNITY</p>

            <h1>
                FIND YOUR<br>
                <span>NEXT GAME.</span>
            </h1>

            <p>
                Discover badminton meetups, tournaments,
                and casual games happening in your community.
            </p>

            <a href="create_event.php" class="main-button">
                + CREATE AN EVENT
            </a>
        </div>
    </section>


    <!-- Community Calendar -->
    <section class="community-calendar-section container">

        <div class="calendar-heading">
            <div>
                <p class="section-label">COMMUNITY EVENTS</p>
                <h2>THE EVENT CALENDAR.</h2>
            </div>

            <a href="create_event.php" class="calendar-create-button">
                + POST AN EVENT
            </a>
        </div>


        <!-- Month Navigation -->
        <div class="calendar-navigation">

            <a href="events.php?month=<?php echo $previousMonth->format('n'); ?>&year=<?php echo $previousMonth->format('Y'); ?>"
               class="calendar-arrow">
                ←
            </a>

            <form action="events.php" method="GET" class="calendar-date-form">

                <select name="month" aria-label="Choose month">
                    <?php for ($m = 1; $m <= 12; $m++): ?>
                        <option value="<?php echo $m; ?>"
                            <?php echo ($m === $month) ? 'selected' : ''; ?>>
                            <?php echo date('F', mktime(0, 0, 0, $m, 1)); ?>
                        </option>
                    <?php endfor; ?>
                </select>

                <select name="year" aria-label="Choose year">
                    <?php
                    $currentYear = (int)date('Y');
                    for ($y = $currentYear - 2; $y <= $currentYear + 5; $y++):
                    ?>
                        <option value="<?php echo $y; ?>"
                            <?php echo ($y === $year) ? 'selected' : ''; ?>>
                            <?php echo $y; ?>
                        </option>
                    <?php endfor; ?>
                </select>

                <button type="submit">GO</button>

            </form>

            <a href="events.php?month=<?php echo $nextMonthDate->format('n'); ?>&year=<?php echo $nextMonthDate->format('Y'); ?>"
               class="calendar-arrow">
                →
            </a>

        </div>


        <!-- Calendar Grid -->
        <div class="calendar-grid">

            <?php
            $weekdays = ['MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT', 'SUN'];

            foreach ($weekdays as $day):
            ?>
                <div class="calendar-weekday">
                    <?php echo $day; ?>
                </div>
            <?php endforeach; ?>


            <?php
            // Empty spaces before the first day
            for ($i = 1; $i < $startingWeekday; $i++):
            ?>
                <div class="calendar-day empty-day"></div>
            <?php endfor; ?>


            <?php for ($day = 1; $day <= $daysInMonth; $day++): ?>

                <?php
                $dateKey = sprintf('%04d-%02d-%02d', $year, $month, $day);
                $dayEvents = $eventsByDate[$dateKey] ?? [];
                $isToday = $dateKey === date('Y-m-d');
                ?>

                <div class="calendar-day <?php echo $isToday ? 'today' : ''; ?>">

                    <span class="calendar-day-number">
                        <?php echo $day; ?>
                    </span>

                    <div class="calendar-day-events">

                        <?php foreach ($dayEvents as $event): ?>

                            <a href="event_details.php?id=<?php echo (int)$event['event_id']; ?>"
                               class="calendar-event">

                                <?php echo htmlspecialchars($event['event_name']); ?>

                                <small>
                                    <?php echo date('g:i A', strtotime($event['event_datetime'])); ?>
                                </small>

                            </a>

                        <?php endforeach; ?>

                    </div>

                </div>

            <?php endfor; ?>

        </div>


        <!-- Empty Calendar Message -->
        <?php if (empty($eventsByDate)): ?>

            <div class="no-events">
                <h3>NO EVENTS THIS MONTH.</h3>

                <p>
                    Nothing scheduled just yet.
                    Why not organize the next game?
                </p>

                <a href="create_event.php" class="main-button">
                    CREATE AN EVENT →
                </a>
            </div>

        <?php endif; ?>

    </section>

</main>

<?php include('footer.php'); ?>
