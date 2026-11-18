<?php
$additional_css = 'about.css';
include('header.php');
?>

<main>

    <!-- About Hero -->
    <section class="page-hero">
        <div class="container">
            <p class="section-label">GET TO KNOW US</p>
            <h1>MORE THAN A CLUB.<br>
                <span>WE'RE A COMMUNITY.</span>
            </h1>
            <p>
                Bringing people together through the love
                of badminton, teamwork, and competition.
            </p>
        </div>
    </section>


    <!-- Our Story -->
    <section class="story-section container">

        <div class="story-content">
            <p class="section-label">OUR STORY</p>

            <h2>WHERE PASSION MEETS PURPOSE.</h2>

            <p>
                SmashPoint Badminton Club was created by two friends with
                one simple idea: badminton should be more
                accessible and visible to more people in the Bronx because
                it's such a fun and fast pace sport.
            </p>

            <p>
                Whether you're picking up a racket for the
                first time or preparing for your next
                competition, our Smashpoint provides a place
                to learn, grow, and connect playing this beautiful sport.
            </p>
        </div>

        <div class="story-image">
            <img src="images/court1.jpg"
                 alt="SmashPoint badminton court">
        </div>

    </section>


    <!-- Our Values -->
    <section class="values-section">

        <div class="container">

            <p class="section-label">WHAT WE BELIEVE</p>

            <h2>OUR CORE VALUES.</h2>

            <div class="values-grid">

                <div class="value-card">
                    <h3>01. COMMUNITY</h3>
                    <p>
                        Creating a welcoming environment
                        where players build friendships.
                </div>

                <div class="value-card">
                    <h3>02. GROWTH</h3>
                    <p>
                        Encouraging members to improve
                        their skills and confidence. Encouraging Collabrations to build friendships and sportmanships.
                    </p>
                    </p>
                </div>

                <div class="value-card">
                    <h3>03. COMPETITION</h3>
                    <p>
                        Celebrating sportsmanship,
                        dedication, and healthy competition.
                    </p>
                </div>

            </div>

        </div>

    </section>


    <!-- Call to Action -->
    <section class="join-section container">

        <h2>YOUR NEXT CHAPTER STARTS HERE.</h2>

        <p>Come play, connect, and be part of something bigger.</p>

        <a href="membership.php" class="main-button">
            BECOME A MEMBER
        </a>

    </section>

</main>

<?php include('footer.php'); ?>
