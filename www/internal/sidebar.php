<div class="sidebar">
    <div class="top">
        <h2><img style="width:100%" src="/static/images/logo.png"></h2>
        <a href="/">Home</a>
        <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']): ?>
            <span class="nav-title">AIRPORT CREW</span>
            <hr>
            <a href="/check-in.php">Check-in</a>
            <a href="/boarding.php">Boarding</a>
            <a href="/display-pane.php">Flights Schedule</a>
            <span class="nav-title">ADMINISTRATION</span>
            <hr>
            <a href="/admin/bookings.php">Booking Management</a>
            <a href="/admin/passengers.php">Passenger Management</a>
            <a href="/admin/users.php">User Management</a>
            <a href="/admin/airports.php">Airport Management</a>
            <a href="/admin/flights.php">Flight Management</a>
            <a href="/admin/aircrafts.php">Aircraft Management</a>
        <?php endif; ?>
    </div>
    <div>
        <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']): ?>
            <a href="/?log-in=no">Log out</a>
        <?php else: ?>
            <a href="/?log-in=yes">Log in</a>
        <?php endif; ?>
    </div>
</div>