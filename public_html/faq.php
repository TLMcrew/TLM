<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Total Life manager</title>
    <link rel="stylesheet" href="site.css" />
  </head>

  <body>
  <header>
      <nav class="navbar">
        <a href="/~logan/dashboard.php" class="navBrand">TLM</a>
        <ul class="navMenu">
          <li class="navItem">
            <a href="/~logan/dashboard.php" class="navLink"
              >Dashboard</a
            >
          </li>
          <li class="navItem">
            <a href="/~logan/graphs.php" class="navLink">Graphs</a>
          </li>
          <li class="navItem">
            <a href="/~logan/meals.php" class="navLink">Meals</a>
          </li>
          <li class="navItem">
            <a href="/~logan/calendar.php" class="navLink">Calendar</a>
          </li>
          <li class="navItem">
            <a href="/~logan/faq.php" class="navLink">FAQ</a>
          </li>
          <li class="navItem">
            <a href="/~logan/logout.php" class="navLink">Logout</a>
          </li>
        </ul>
        <div class="hamburger">
          <span class="bar"></span>
          <span class="bar"></span>
          <span class="bar"></span>
        </div>
      </nav>
    </header>
    <script src="hamburger.js"></script>
    <h1>FAQ</h1>
  </body>
</html>
