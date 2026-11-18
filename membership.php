
<?php include('header.php'); ?>

<main>

    <!-- Membership Hero -->
    <section class="page-hero">
        <div class="container">
            <p class="section-label">BECOME A MEMBER</p>

            <h1>
                YOUR GAME.<br>
                <span>YOUR COMMUNITY.</span>
            </h1>

            <p>
                Whether you play for fun or competition,
                there's a place for you at SmashPoint.
            </p>
        </div>
    </section>


    <!-- Membership Plans -->
    <section class="membership-section container">

        <div class="membership-heading">
            <p class="section-label">MEMBERSHIP PLANS</p>

            <h2>CHOOSE YOUR PLAY.</h2>

            <p>
                Find the membership that matches your
                playing style and goals.
            </p>
        </div>


        <!-- Returning Member Login -->
        <div class="returning-member">
            <div>
                <h3>Already part of SmashPoint?</h3>
                <p>Welcome back! Access your membership account.</p>
            </div>

            <a href="login.php" class="login-link">
                MEMBER LOGIN →
            </a>
        </div>


        <div class="membership-grid">

            <!-- Basic Membership -->
            <div class="membership-card">
                <p class="plan-type">STARTER</p>

                <h3>Casual Player</h3>

                <p class="plan-description">
                    Perfect for beginners and recreational players.
                </p>

                <div class="plan-price">
                    $25<span>/month</span>
                </div>

                <div class="plan-divider"></div>

                <ul>
                    <li>✓ Club community access</li>
                    <li>✓ Two court sessions monthly</li>
                    <li>✓ Beginner-friendly activities</li>
                    <li>✓ Member announcements</li>
                </ul>

                <a href="register.php?plan=Starter"
                   class="plan-button">
                    GET STARTED →
                </a>
            </div>


            <!-- Standard Membership -->
            <div class="membership-card featured">
                <div class="popular-label">
                    MOST POPULAR
                </div>

                <p class="plan-type">STANDARD</p>

                <h3>Active Player</h3>

                <p class="plan-description">
                    For players who want to play regularly
                    and improve their game.
                </p>

                <div class="plan-price">
                    $45<span>/month</span>
                </div>

                <div class="plan-divider"></div>

                <ul>
                    <li>✓ Unlimited club community access</li>
                    <li>✓ Eight court sessions monthly</li>
                    <li>✓ Group training opportunities</li>
                    <li>✓ Club event participation</li>
                    <li>✓ Priority court reservations</li>
                </ul>

                <a href="register.php?plan=Standard"
                   class="plan-button featured-button">
                    JOIN SMASHPOINT →
                </a>
            </div>


            <!-- Premium Membership -->
            <div class="membership-card">
                <p class="plan-type">PREMIUM</p>

                <h3>Competitive Player</h3>

                <p class="plan-description">
                    Designed for dedicated players
                    who want more from the game.
                </p>

                <div class="plan-price">
                    $70<span>/month</span>
                </div>

                <div class="plan-divider"></div>

                <ul>
                    <li>✓ All Standard membership benefits</li>
                    <li>✓ Unlimited court sessions</li>
                    <li>✓ Advanced training opportunities</li>
                    <li>✓ Tournament participation</li>
                    <li>✓ Exclusive member events</li>
                </ul>

                <a href="register.php?plan=Premium"
                   class="plan-button">
                    GO PREMIUM →
                </a>
            </div>

        </div>

        <p class="membership-note">
            * Prices are sample project pricing.
            Contact the club for membership details.
        </p>

    </section>


    <!-- Membership Benefits -->
    <section class="benefits-section">
        <div class="container">

            <p class="section-label">WHY SMASHPOINT?</p>

            <h2>MORE THAN JUST COURT TIME.</h2>

            <div class="benefits-grid">

                <div class="benefit-item">
                    <h3>01 / COMMUNITY</h3>
                    <p>
                        Meet new people and connect
                        with fellow badminton enthusiasts.
                    </p>
                </div>

                <div class="benefit-item">
                    <h3>02 / DEVELOPMENT</h3>
                    <p>
                        Improve your skills through
                        practice and training opportunities.
                    </p>
                </div>

                <div class="benefit-item">
                    <h3>03 / OPPORTUNITY</h3>
                    <p>
                        Participate in club activities,
                        events, and friendly competitions.
                    </p>
                </div>

            </div>
        </div>
    </section>


    <!-- Final Call to Action -->
    <section class="join-section container">

        <h2>LET'S GET YOU ON THE COURT.</h2>

        <p>
            Your next badminton experience starts with us.
        </p>

        <a href="register.php" class="main-button">
            REGISTER NOW →
        </a>

    </section>

</main>

<?php include('footer.php'); ?>
