<div class="sidebar mobile-hidden">
    <div class="top">
        <h2><img class="logo-sidebar" src="/static/images/logo.png"></h2>
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
            <a href="/login.php">Log in</a>
        <?php endif; ?>
    </div>
    <script>
        addEventListener('load', () => {
            const menuBtn = document.getElementById("menu-btn");
            const sidebar = document.getElementsByClassName('sidebar')[0];
            const main = document.getElementsByTagName('main')[0];
            menuBtn.addEventListener('click', () => {
                main.classList.toggle('mobile-hidden');
                sidebar.classList.toggle('mobile-hidden');
                document.querySelectorAll('#menu-btn .fa').forEach(element => {
                    element.classList.toggle('hidden');
                });
            });
        });
    </script>
</div>