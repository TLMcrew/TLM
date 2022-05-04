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
    <meta charset="utf=8" />
    <title>Dashboard</title>
    <link rel="stylesheet" href="site.css" />
    <script src = "/~logan/weather.js" defer></script>
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
    
    <!-- Widgets -->
    <div class="widgets">
      <div class="graphs"></div>
      <div class="circles"></div>
      <div class = "weather">
        <div class = "card">
        <div class = "search">
            <input type="text" class="weatherSearch" placeholder="Search">
            <button class = "weatherSearchButton"><svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="15px" width="15px" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10.442 10.442a1 1 0 011.415 0l3.85 3.85a1 1 0 01-1.414 1.415l-3.85-3.85a1 1 0 010-1.415z" clip-rule="evenodd"></path><path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 100-11 5.5 5.5 0 000 11zM13 6.5a6.5 6.5 0 11-13 0 6.5 6.5 0 0113 0z" clip-rule="evenodd"></path></svg></button>
        </div>
        <div class = "weatherDisplay">
            <h2 class = "city">Weather in Clarksville</h2>
            <div class = "temp">70°F</div>
            <div class = "flex">
                <img src="" alt="" class="icon">
                <div class = "description">Sunny</div>
            </div>
            <div class = "humidity">Humidity: 60%</div>
            <div class = "wind">Wind speed: 6.2 MPH</div>
        </div>
        </div>

      <!-- <div class="weatherAndCalendar">
        <div class="weather">
          <div class = "search">
            <input type="text" class="weatherSearch">
            <button>I</button>
            

        </div>
        <div class="calendar"></div>
      </div>
    </div> -->
  </body>
</html>