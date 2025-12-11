<?php 
include("internal/login_process.php")
?>

<!doctype html>
<html lang="ar">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="/static/css/login.css">
  <link href="https://fonts.googleapis.com/css2?family=BBH+Sans+Bartle&display=swap" rel="stylesheet">
  <title>Login page</title>
  
</head>
  <div class="top">
    <div class="top-bar">
      <div class="left">
        <img src="static/images/logo.png" alt="Logo" class="logo1">
        <button class="button1" onclick="location.href='#login'">Sign In</button>
        <button class="button2" onclick="location.href='#f'">Our Services</button>
      </div>
    </div>

    <!-- Center content -->
    <div class="center-content">
      <h1 class="welcome">Welcome to Domestic Airline Manager</h1>
      <p class="description">Manage your flights, bookings, and passengers efficiently.</p>
      <button class="button4" onclick="location.href='#login'">Sign In Now !</button>
      <a class="ourservices" href="#f">Check our services</a>
    </div>

    <!-- Wave at bottom -->
    <svg class="wave" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" preserveAspectRatio="none">
      <path fill="#eef6df" fill-opacity="1" 
            d="M0,224L60,213.3C120,203,240,181,360,154.7C480,128,600,96,720,106.7C840,117,960,171,1080,181.3C1200,192,1320,160,1380,144L1440,128V320H0Z"></path>
    </svg>
  </div>

  <!-- Login section -->
  <div class="bottom" id="login">
    <div class="container">
      <div class="illustration-section">
        <img src="/static/images/login.jpeg" alt="login-illustration" class="illustration">
      </div>

      <div class="form-section">
        <img src="/static/images/logo-inverted.png" alt="company-logo" class="logo">
        <h1>Login</h1>
        <p class="subtitle">Enter your email and password to access our services.</p>
        <form id="LoginForm" action="internal/login_process.php" method="POST">
          <div class="form-group">
            <label for="email">Email Address</label>
            <div class="input-wrapper">
              <input type="email" id="email" name="email" placeholder="Enter your email address" required>
            </div>
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <div class="input-wrapper">
              <input type="password" id="password" name="password" autocomplete="current-password" placeholder="Enter your password" required>
            </div>
          </div>
          <button type="submit" class="submit-btn">Login</button>
        </form>
        <div class="info-box">
          <p>Forgot your password? <a href="forgot-password.php">Reset it here</a></p>
        </div>
        <div class="feedback">
            <a href="mailto:support@airline.com?subject=Feedback">Any problem? Send a feedback</a>
        </div>
      </div>
    </div>
  </div>

  <footer class="main-footer" id="f">
    <div class="footer-col">
      <h3 class="footer-title">Our Services</h3>
      <ul class="footer-list">
        <li>Flight Booking</li>
        <li>Hotel Reservation</li>
        <li>Baggage Handling</li>
        <li>VIP Lounge Access</li>
      </ul>
    </div>

    <div class="footer-col">
      <h3 class="footer-title invisible">.</h3>
      <ul class="footer-list">
        <li>Airport Transfers</li>
        <li>Customer Support</li>
        <li>Travel Insurance</li>
        <li>Aircraft Maintenance</li>
      </ul>
    </div>

    <div class="footer-col footer-contact">
      <h3 class="footer-title">Contact Us</h3>
      <div class="contact-item">
<a href="mailto:support@airline.com?subject=Feedback"  class="email-link">
  <i class="fa fa-envelope"></i> ✉️ support@airline.com
</a>

      </div>
    </div>
  </footer>

  <script>
    let loginbutton = document.querySelector(".button4");
    let loginbutton2 = document.querySelector(".button1");
    let inputlogin = document.querySelector("#email");
    
    loginbutton.onclick = function() {
      inputlogin.focus();
    };
    
    loginbutton2.onclick = function() {
      inputlogin.focus();
    };
  </script>
</body>
</html>