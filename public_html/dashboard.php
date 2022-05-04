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
    <meta charset="utf-8" />
    <title>Dashboard</title>
    <link rel="stylesheet" href="site.css" />
    <script src = "/~logan/weather.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js/dist/chart.min.js"></script>
    <script
        src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>
    
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
      <div class="graphs">
        <canvas id="myChart" width="400" height="400"></canvas>
        <select name="dataSet" id="dataSet">
            <option value="cal">Calories</option>
            <option value="weight">Weight</option>
            <option value="water">Water Intake</option>
            <option value="sleep">Hours Slept</option>
            <option value="exercise">Exercise Time</option>
        </select>
      </div>
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
    </div>
    <script>
      let calData = [
        //{date: new Date(2021, 11, 19), value: 100}, {date: new Date(2021, 11, 30), value: 200}
      ];
      let weightData = [{date: new Date(2021, 11, 30), value: 200}];
      let waterData = [];
      let sleepData = [];
      let exerciseData = [];
      /**
         * Code to fill these arrays with data from the database 
        */

      function changeGraph(){
        let set = document.getElementById('dataSet').value;
        let myValues = [];
        let myDates = [];
        let stringSet = set+'Data';
        let mySet;

        eval('mySet ='+stringSet);

        if(mySet.length != 0){
        myChart.data.datasets[0].data = mySet;
        
        for (let x of mySet) { myValues.push(x.value); }
        for (let x of mySet) { myDates.push(x.date); }

        myValues.sort(function (a, b) {
          return b-a;
        });
        let yMax = myValues[0] + (myValues[0] / 5);

        myDates.sort(function (a, b) {
          return a - b;
        });
        let xMin = new Date(myDates[0]);
        xMin.setDate(xMin.getDate()-7);
        console.log(xMin);

        myChart.options.scales.y.max = yMax;
        myChart.options.scales.x.min = xMin;
        /*
        switch (dataSet) {
                    case "cal":
                        dataUpdateFunction(myDate, numVal, calData);
                        //console.log(calData);
                        break;
                    case "weight":
                        dataUpdateFunction(myDate, numVal, weightData);
                        //console.log(weightData);
                        break;
                    case "water":
                        dataUpdateFunction(myDate, numVal, waterData);
                        //console.log(waterData);
                        break;
                    case "sleep":
                        dataUpdateFunction(myDate, numVal, sleepData);
                        //console.log(sleepData);
                        break;
                    case "exercise":
                        dataUpdateFunction(myDate, numVal, exerciseData);
                        //console.log(exerciseData);
                        break;
                }*/
              }
        myChart.update();
      }

      const ctx = document.getElementById('myChart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'line',
            data: {
                datasets: [{
                    label: 'Calories',
                    data: calData,
                    backgroundColor: [
                        'rgba(245, 163, 2, 0.2)'
                    ],
                    borderColor: [
                        'rgba(245, 163, 2, 1)',
                    ],
                    borderWidth: 1,
                    tension: 0.5,
                    parsing: {
                        xAxisKey: 'date',
                        yAxisKey: 'value'
                    }
                }]
            },
            options: {
                scales: {
                    x: {
                        //default to week view
                        min: new Date().setDate(new Date().getDate() - 7),
                        max: new Date(),
                        type: 'time',
                        //formats x axis scale (one day increments) and display (month, day, year)
                        time: {
                            unti: 'day',
                            displayFormats: {
                                day: 'MM/dd/yy'
                            }
                        },
                        ticks: {
                            autoSkip: false,
                            major: {
                                enabled: true
                            },
                            color: "#FFFFFF"
                        },
                        grid: {
                            color: "#FFFFFF",
                            borderColor: "#FFFFFF"
                        }
                    },
                    y: {
                        max: 100,
                        beginAtZero: true,
                        grid: {
                            color: "#FFFFFF",
                            borderColor: "#FFFFFF"
                        },
                        ticks: {
                            color: "#FFFFFF"
                        }
                    }

                },
                plugins: {
                    legend: {
                        display: false
                    }
                },
            }
        });
        document.getElementById('dataSet').addEventListener("change", changeGraph);
        changeGraph();
    </script>
  </body>
</html>