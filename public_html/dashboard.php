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
    <script src = "./weather.js" defer></script>
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
            <a href="/~logan/dashboard.php" class="navLink">Dashboard</a>
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
        <!-- <a href="/~logan/graphs.php" class="navLink"> -->
          <canvas id="widgetGraph" width="350" height="320" class = "graphDisplay"></canvas>
        <!-- </a>  -->

        <select name="dataSet" id="dataSet" class = "dashboardData">
            <option value="cal">Calories</option>
            <option value="weight">Weight</option>
            <option value="water">Water Intake</option>
            <option value="sleep">Hours Slept</option>
            <option value="exercise">Exercise Time</option>
        </select>
      </div>
      <div class="circles">
        <div class="circleLeft">
        <div class = "donutStyle">
          <canvas id="calDonut"></canvas>
        </div>
        <div class = "donutStyle">
          <canvas id="waterDonut"></canvas>
        </div>
      </div>    
      <div class = "circleRight">
        <div class = "donutStyle">
          <canvas id="exerciseDonut" ></canvas>
        </div>
        <div class = "donutStyle">
          <canvas id="sleepDonut"></canvas>
        </div>
      </div>
      </div>
      <div class = "weatherAndCalendar">
      <div class = "weather">
        <div class = "card">
        <div class = "search">
            <input type="text" class="weatherSearch" placeholder="Search">
            <button class = "weatherSearchButton"><svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="15px" width="15px" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10.442 10.442a1 1 0 011.415 0l3.85 3.85a1 1 0 01-1.414 1.415l-3.85-3.85a1 1 0 010-1.415z" clip-rule="evenodd"></path><path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 100-11 5.5 5.5 0 000 11zM13 6.5a6.5 6.5 0 11-13 0 6.5 6.5 0 0113 0z" clip-rule="evenodd"></path></svg></button>
        </div>
        <div class = "weatherDisplay">
            <h2 class = "city">Weather in </h2>
            <!-- Clarksville -->
            <div class = "temp">°F</div>
            <!-- 70 -->
            <div class = "flex">
                <img src="" alt="" class="icon">
                <div class = "description"></div>
                <!-- Sunny -->
            </div>
            <div class = "humidity">Humidity: %</div>
            <!-- 60 -->
            <div class = "wind">Wind speed:  MPH</div>
            <!-- 6.2 -->
        </div>
        </div>
      </div>
      <div class="calendar">
        <table class = "calendarTable">
          <thead class = "calendarThead">
            <th class = "calendarTh">
              <span class = "day">1</span>
              <span class = "abrev">Sun</span>
            </th>
            <th class = "calendarTh">
              <span class = "day">2</span>
              <span class = "abrev">Mon</span>
            </th>
            <th class = "calendarTh">
              <span class = "day">3</span>
              <span class = "abrev">Tue</span>
            </th>
            <th class = "calendarTh">
              <span class = "day">4</span>
              <span class = "abrev">Wed</span>
            </th>
            <th class = "calendarTh">
              <span class = "day">5</span>
              <span class = "abrev">Thur</span>
            </th>
            <th class = "calendarTh">
              <span class = "day">6</span>
              <span class = "abrev">Fri</span>
            </th>
            <th class = "calendarTh">
              <span class = "day">7</span>
              <span class = "abrev">Sat</span>
            </th>
        </thead>
        <tbody>
          <td class = "calendarTd"></td>
          <td class = "calendarTd"></td>
          <td class = "calendarTd"></td>
          <td class = "calendarTd"></td>
          <td class = "calendarTd"></td>
          <td class = "calendarTd"></td>
          <td class = "calendarTd"></td>
        </tbody>
        </table>
      </div>
</div>
    </div>
    </div>
    <script>
      let currentDate = new Date();
      let calData = [
        {date: new Date(2021, 11, 19), value: 100}, {date: new Date(2021, 11, 30), value: 200},
        {date: new Date(), value: 1200}, {date: new Date(), value: 400}
      ];
      let weightData = [{date: new Date(2021, 11, 30), value: 200}];
      let waterData = [{date: new Date(), value: 30}];
      let sleepData = [];
      let exerciseData = [];

      /**
         * Code to fill these arrays with data from the database 
        */

      const dailyCal = 2000;
      const dailyWater = 64;
      const dailyExer = 60;
      const dailySleep = 8;

      let calDonutData = [0, dailyCal];
      let waterDonutData = [0, dailyWater];
      let exerciseDonutData = [0, dailyExer];
      let sleepDonutData = [0, dailySleep];

      function fillDonut(dataArray, donutArray, donut, constant){
        for (let dataPoint of dataArray){
          let dateCheck = new Date(dataPoint.date);
          
          if(dateCheck.getDate() == new Date().getDate()){
            if((donutArray[0] + dataPoint.value) >= constant){
              donutArray[0] = constant;
              donutArray[1] = 0;
              let color = String(donut.data.datasets[0].backgroundColor[0]);
              
              let indOfO = color.search('0');
              color = color.slice(0, indOfO) + "1)";
              donut.data.datasets[0].backgroundColor[0] = color;
            }else{
              donutArray[0] += dataPoint.value;
              donutArray[1] -= dataPoint.value;
            }
          }
        }
        donut.update();
      }
      
      function changeGraph(){
        let set = document.getElementById('dataSet').value;
        let myValues = [];
        let myDates = [];
        let stringSet = set+'Data';
        let mySet;

        eval('mySet ='+stringSet);

        if(mySet.length != 0){
        widgetGraph.data.datasets[0].data = mySet;
        
        for (let x of mySet) { myValues.push(x.value); }
        for (let x of mySet) { myDates.push(x.date); }

        myValues.sort(function (a, b) {
          return b-a;
        });
        let yMax = myValues[0] + (myValues[0] / 5);

        myDates.sort(function (a, b) {
          if (a < b) {
            return -1;
          }
          if (b < a) {
            return 1
          }
          return 0;
        });

        let xMin = new Date(myDates[0]);
        xMin.setDate(xMin.getDate()-7);

          widgetGraph.options.scales.y.max = yMax;
          widgetGraph.options.scales.x.min = xMin;
        }
        widgetGraph.update();
      }

      const ctx = document.getElementById('widgetGraph').getContext('2d');
      const widgetGraph = new Chart(ctx, {
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
              // onClick: (evt, activeElements, chart) => {
                
              // }
            }
        });
      
      const counter = {
        id: 'counter',
        beforeDraw(chart, args, options){
          const { ctx, chartArea: {top, right, bottom, left, width, height}} = chart;
          ctx.save();
          ctx.font = '30px "Gill Sans", "Gill Sans MT", Calibri, "Trebuchet MS", sans-serif';
          ctx.textAlign = 'center';
          ctx.fillStyle = chart.data.datasets[0].borderColor[0];
          ctx.fillText(chart.data.datasets[0].data[0], width / 2, top + (height/2));
          ctx.restore();
        }
      }

      const ctx2 = document.getElementById('calDonut').getContext('2d');
      const calDonutGraph = new Chart(ctx2, {
        type: 'doughnut',
        data: {
          labels: ['Calories'],
          datasets: [{
            label: "Calories",
            data: calDonutData,
            backgroundColor: [
              'rgba(255, 99, 132, 0.2)',
              'rgba(0, 0, 0, 0)'
            ],
            borderColor: ['rgba(255, 99, 132, 1)'],
            borderWidth: 1,
            cutout: [60]
          }]
        },
        plugins: [counter],
        onClick: (evt, activeElements, chart) => {
          if(activeElements[0] != null){
             console.log(activeElements[0]);
          }
        }
      });

      const ctx3 = document.getElementById('waterDonut').getContext('2d');
      const waterDonutGraph = new Chart(ctx3, {
        type: 'doughnut',
        data: {
          labels: ['Water'],
          datasets: [{
            label: "Ounces",
            data: waterDonutData,
            backgroundColor: [
              'rgba(25, 255, 255, 0.2)',
              'rgba(0, 0, 0, 0)'
            ],
            borderColor: ['rgba(25, 255, 255, 1)'],
            borderWidth: 1,
            cutout: [60]
          }]
        },
        plugins: [counter]
      });
      const ctx4 = document.getElementById('exerciseDonut').getContext('2d');
      const exerciseDonutGraph = new Chart(ctx4, {
        type: 'doughnut',
        data: {
          labels: ['Exercise'],
          datasets: [{
            label: "Minutes",
            data: exerciseDonutData,
            backgroundColor: [
              'rgba(255, 255, 25, 0.2)',
              'rgba(0, 0, 0, 0)'
            ],
            borderColor: ['rgba(255, 255, 25, 1)'],
            borderWidth: 1,
            cutout: [60]
          }]
        },
        plugins: [counter]
      });

      const ctx5 = document.getElementById('sleepDonut').getContext('2d');
      const sleepDonutGraph = new Chart(ctx5, {
        type: 'doughnut',
        data: {
          labels: ['Sleep'],
          datasets: [{
            label: "Hours",
            data: sleepDonutData,
            backgroundColor: [
              'rgba(25, 25, 255, 0.2)',
              'rgba(0, 0, 0, 0)'
            ],
            borderColor: ['rgba(25, 25, 255, 1)'],
            borderWidth: 1,
            cutout: [60]
          }]
        },
        plugins: [counter]
      });

      fillDonut(calData, calDonutData, calDonutGraph, dailyCal);
      fillDonut(waterData, waterDonutData, waterDonutGraph, dailyWater);
      fillDonut(exerciseData, exerciseDonutData, exerciseDonutGraph, dailyExer);
      fillDonut(sleepData, sleepDonutData, sleepDonutGraph, dailySleep);

      document.getElementById('dataSet').addEventListener("change", changeGraph);
      changeGraph();
    </script>
  </body>
</html>