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
        <a href="/~logan/dashboard.html" class="navBrand">TLM</a>
        <ul class="navMenu">
          <li class="navItem">
            <a href="/~logan/dashboard.html" class="navLink"
              >Dashboard</a
            >
          </li>
          <li class="navItem">
            <a href="/~logan/graphs.html" class="navLink">Graphs</a>
          </li>
          <li class="navItem">
            <a href="/~logan/meals.html" class="navLink">Meals</a>
          </li>
          <li class="navItem">
            <a href="/~logan/calendar.html" class="navLink">Calendar</a>
          </li>
          <li class="navItem">
            <a href="/~logan/faq.html" class="navLink">FAQ</a>
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
    <h1>Calendar page</h1>
  </body>
</html>
