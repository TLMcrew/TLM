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
          <canvas id="widgetGraph" width="350" height="320" class = "graphDisplay"></canvas>
        <select name="dataSet" id="dataSet" class = "graphsDropdown">
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
      document.getElementById("widgetGraph").onclick = function(e){
      window.location.href = '/~logan/graphs.php';
      };

      // let currentDate = new Date();
      // let calData = [
      //   {date: new Date(2021, 11, 19), value: 100}, {date: new Date(2021, 11, 30), value: 200},
      //   {date: new Date(), value: 1200}, {date: new Date(), value: 1000}
      // ];
      // let weightData = [{date: new Date(2021, 11, 30), value: 200}];
      // let waterData = [{date: new Date(2021, 11, 30), value: 30}];
      // let sleepData = [];
      // let exerciseData = [];
      let calData = [
            {date: new Date(2019, 2, 15), value: 1841},
            {date: new Date(2019, 4, 6), value: 1642},
            {date: new Date(2019, 10, 7), value: 1638},
            {date: new Date(2020, 0, 31), value: 2224},
            {date: new Date(2020, 6, 9), value: 1562},
            {date: new Date(2020, 8, 17), value: 1486},
            {date: new Date(2020, 10, 21), value: 1221},
            {date: new Date(2021, 0, 1), value: 1706},
            {date: new Date(2021, 1, 28), value: 1724},
            {date: new Date(2021, 2, 2), value: 2186},
            {date: new Date(2021, 3, 22), value: 2264},
            {date: new Date(2021, 4, 29), value: 1748},
            {date: new Date(2021, 5, 8), value: 1961},
            {date: new Date(2021, 6, 25), value: 1673},
            {date: new Date(2021, 8, 9), value: 1839},
            {date: new Date(2021, 9, 14), value: 1924},
            {date: new Date(2021, 10, 15), value: 1659},
            {date: new Date(2022, 0, 29), value: 2112},
            {date: new Date(2022, 1, 7), value: 1905},
            {date: new Date(2022, 1, 8), value: 2209},
            {date: new Date(2022, 2, 3), value: 1945},
            {date: new Date(2022, 3, 7), value: 2020},
            {date: new Date(2022, 3, 14), value: 1726},
            {date: new Date(2022, 3, 15), value: 1708},
            {date: new Date(2022, 3, 18), value: 2087}
        ];
        let weightData = [
            {date: new Date(2019, 4, 6), value: 172},
            {date: new Date(2019, 6, 30), value: 179},
            {date: new Date(2019, 10, 7), value: 170},
            {date: new Date(2020, 0, 31), value: 162},
            {date: new Date(2020, 2, 2), value: 173},
            {date: new Date(2020, 6, 9), value: 180},
            {date: new Date(2020, 8, 17), value: 171},
            {date: new Date(2020, 10, 21), value: 173},
            {date: new Date(2021, 0, 1), value: 161},
            {date: new Date(2021, 1, 28), value: 174},
            {date: new Date(2021, 2, 2), value: 161},
            {date: new Date(2021, 3, 22), value: 170},
            {date: new Date(2021, 4, 29), value: 169},
            {date: new Date(2021, 5, 8), value: 161},
            {date: new Date(2021, 6, 25), value: 165},
            {date: new Date(2021, 8, 9), value: 180},
            {date: new Date(2021, 9, 14), value: 177},
            {date: new Date(2021, 10, 15), value: 180},
            {date: new Date(2021, 11, 9), value: 164},
            {date: new Date(2022, 1, 8), value: 171},
            {date: new Date(2022, 2, 3), value: 180},
            {date: new Date(2022, 2, 17), value: 179},
            {date: new Date(2022, 3, 7), value: 176},
            {date: new Date(2022, 3, 15), value: 176},
            {date: new Date(2022, 3, 18), value: 173},
            {date: new Date(2022, 4, 3), value: 175},
        ];
        let waterData = [
            {date: new Date(2019, 2, 15), value: 28},
            {date: new Date(2019, 4, 6), value: 69},
            {date: new Date(2019, 6, 30), value: 50},
            {date: new Date(2019, 8, 6), value: 80},
            {date: new Date(2019, 10, 7), value: 60},
            {date: new Date(2020, 2, 2), value: 78},
            {date: new Date(2020, 4, 25), value: 69},
            {date: new Date(2020, 6, 9), value: 53},
            {date: new Date(2021, 0, 1), value: 77},
            {date: new Date(2021, 1, 28), value: 52},
            {date: new Date(2021, 2, 2), value: 69},
            {date: new Date(2021, 3, 22), value: 54},
            {date: new Date(2021, 4, 29), value: 61},
            {date: new Date(2021, 5, 8), value: 75},
            {date: new Date(2021, 6, 25), value: 37},
            {date: new Date(2021, 7, 29), value: 52},
            {date: new Date(2021, 9, 14), value: 49},
            {date: new Date(2021, 11, 9), value: 42},
            {date: new Date(2022, 0, 29), value: 77},
            {date: new Date(2022, 1, 8), value: 31},
            {date: new Date(2022, 2, 17), value: 44},
            {date: new Date(2022, 3, 14), value: 52},
            {date: new Date(2022, 3, 15), value: 42},
            {date: new Date(2022, 3, 18), value: 78},
            {date: new Date(2022, 4, 2), value: 57},
            {date: new Date(2022, 4, 3), value: 72}
        ];
        let sleepData = [
            {date: new Date(2019, 8, 6), value: 10},
            {date: new Date(2019, 10, 7), value: 11},
            {date: new Date(2020, 6, 9), value: 5},
            {date: new Date(2020, 8, 17), value: 4},
            {date: new Date(2020, 10, 21), value: 4},
            {date: new Date(2021, 1, 28), value: 9},
            {date: new Date(2021, 2, 2), value: 5},
            {date: new Date(2021, 3, 22), value: 10},
            {date: new Date(2021, 4, 29), value: 4},
            {date: new Date(2021, 6, 25), value: 12},
            {date: new Date(2021, 8, 9), value: 9},
            {date: new Date(2021, 9, 14), value: 10},
            {date: new Date(2022, 0, 29), value: 7},
            {date: new Date(2022, 1, 7), value: 5},
            {date: new Date(2022, 1, 8), value: 4},
            {date: new Date(2022, 3, 7), value: 7},
            {date: new Date(2022, 3, 14), value: 6},
            {date: new Date(2022, 3, 15), value: 9},
            {date: new Date(2022, 3, 18), value: 4},
            {date: new Date(2022, 4, 2), value: 8},
        ];
        let exerciseData = [
            {date: new Date(2019, 4, 6), value: 74},
            {date: new Date(2019, 6, 30), value: 89},
            {date: new Date(2019, 8, 6), value: 50},
            {date: new Date(2019, 10, 7), value: 87},
            {date: new Date(2020, 4, 25), value: 46},
            {date: new Date(2020, 6, 9), value: 54},
            {date: new Date(2020, 8, 17), value: 50},
            {date: new Date(2021, 0, 1), value: 71},
            {date: new Date(2021, 1, 28), value: 31},
            {date: new Date(2021, 2, 2), value: 41},
            {date: new Date(2021, 3, 22), value: 86},
            {date: new Date(2021, 6, 25), value: 39},
            {date: new Date(2021, 7, 29), value: 73},
            {date: new Date(2021, 8, 14), value: 55},
            {date: new Date(2022, 0, 29), value: 48},
            {date: new Date(2022, 1, 7), value: 39},
            {date: new Date(2022, 1, 8), value: 41},
            {date: new Date(2022, 2, 17), value: 77},
            {date: new Date(2022, 3, 7), value: 58},
            {date: new Date(2022, 3, 14), value: 79},
            {date: new Date(2022, 3, 15), value: 63},
            {date: new Date(2022, 3, 18), value: 69},
            {date: new Date(2022, 4, 2), value: 84},
            {date: new Date(2022, 4, 3), value: 78}
        ];
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
              donutArray[1] = 0;
              let color = String(donut.data.datasets[0].backgroundColor[0]);
              
              let indOfO = color.search('0');
              color = color.slice(0, indOfO) + "01)";
              donut.data.datasets[0].backgroundColor[0] = color;
            }else{
              donutArray[1] -= dataPoint.value;
            }
            donutArray[0] += dataPoint.value;
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

      function donutOnClick(chart, graphData, donutData, constant){
          let val = prompt("Enter New Value:");
          val = parseFloat(val);
          if(!isNaN(val)){
            let ind = -1;
            for(let values of graphData){
              if(values.date.getDate() == new Date().getDate()){
                ind = graphData.indexOf(values);
                values.value = val;
              }
            }

            if(ind == -1){
              graphData.push({date: new Date(), value: val});
            }

            changeGraph();
            chart.data.datasets[0].data[0] = val;
            if(constant - val <= 0){
              chart.data.datasets[0].data[1] = 0;
              let color = String(chart.data.datasets[0].backgroundColor[0]);
              let indOfO = color.search('0');
              color = color.slice(0, indOfO) + "01)";
              chart.data.datasets[0].backgroundColor[0] = color;
            }else{
              chart.data.datasets[0].data[1] = constant - val;
              let color = String(chart.data.datasets[0].backgroundColor[0]);
              let indOfO = color.search('0');
              color = color.slice(0, indOfO) + "0.2)";
              chart.data.datasets[0].backgroundColor[0] = color;
            }
            chart.update();
          }
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
          let num = chart.data.datasets[0].data[0];
          let denom;
          
          switch(chart.data.labels[0]) {
            case "Calories":
              denom = dailyCal;
              break;
            case "Water":
              denom = dailyWater;
              break;
            case "Exercise":
              denom = dailyExer;
              break;
            case "Sleep":
              denom = dailySleep;
              break;
            default:
              denom = num + chart.data.datasets[0].data[1];
          }

          ctx.fillText(num + "/" + denom, width / 2, top + (height/2));
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
            cutout: [66]
          }]
        },
        plugins: [counter],
        options:{
          onClick(evt, activeElements, chart) {
            donutOnClick(chart, calData, calDonutData, dailyCal);
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
            cutout: [66]
          }]
        },
        plugins: [counter],
        options:{
          onClick(evt, activeElements, chart) {
            donutOnClick(chart, waterData, waterDonutData, dailyWater);
          }
        }
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
            cutout: [66]
          }]
        },
        plugins: [counter],
        options:{
          onClick(evt, activeElements, chart) {
            donutOnClick(chart, exerciseData, exerciseDonutData, dailyExer);
          }
        }
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
            cutout: [66]
          }]
        },
        plugins: [counter],
        options:{
          onClick(evt, activeElements, chart) {
            donutOnClick(chart, sleepData, sleepDonutData, dailySleep);
          }
        }
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