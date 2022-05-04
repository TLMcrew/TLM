<!DOCTYPE html>
<html>

<head>
    <title> Total Life manager </title>
    <meta charset="utf-8">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"
        integrity="sha512-QSkVNOCYLtj73J4hbmVoOV6KVZuMluZlioC+trLpewV8qMjsWqlIQvkn1KGX2StWvPMdWGBqim1xlC8krl1EKQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer">
        </script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js/dist/chart.min.js"></script>
    <script
        src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>
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

    <h1>Graphs page</h1>

    <div name="graph" id="myGraph">
        <canvas id="myChart" width="400" height="400"></canvas>
    </div>
    <br>

    <!-- <div class="halfPage"> -->
        <div id="bioInfo">
        <h3>Biometric Information</h3>
        <form name="bioInfo" action="javascript:updateBio();">
            <p>Height (in.):</p>
            <input id="height" type="text"></input>
            <p>Weight Goal (lbs.):</p>
            <input id="weightGoal" type="text"></input>
            <input type="submit" value="Update Information">
        </form>
        </div>
        <div id="graphInput">
        <h3>Graph Data</h3>
        <form name="graphInput" action="javascript:graph();">
            <p>Date:</p>
            <input type="date" id="inputDate" min="1903-01-20" max="">
            <p>Value:</p>
            <input type="text" id="val">
            <input type="submit" value="Add to Graph">
        </form>
        <span>Scale:</span>
        <select name="view" id="timeView">
            <option value="week" onclick="javascript:updateWeekScale(myChart)">Week View</option>
            <option value="month" onclick="javascript:updateMonthScale(myChart)">Month View</option>
            <option value="year" onclick="javascript:updateYearScale(myChart)">Year View</option>
            <option value="allTime" onclick="javascript:updateFullScale(myChart)">All Time View</option>
        </select>
        <span>Dataset</span>
        <select name="dataSet" id="dataSet">
            <option value="cal">Calories</option>
            <option value="weight">Weight</option>
            <option value="water">Water Intake</option>
            <option value="sleep">Hours Slept</option>
            <option value="exercise">Exercise Time</option>
        </select>
        </div>
        <br>
        <!-- Updates all info in the database -->
        <button type="button" onclick="saveData()">Save Changes</button>
    <!-- </div> -->
    <script>
        //used as reference for various time scale views
        let currentDate = new Date();

        let dd = currentDate.getDate();
        let mm = currentDate.getMonth() + 1;
        let yyyy = currentDate.getFullYear();

        if (dd < 10) { dd = "0" + dd; }
        if (mm < 10) { mm = "0" + mm; }

        //Sets limit on html date input to the current date
        let today = yyyy + "-" + mm + "-" + dd;
        document.getElementById("inputDate").setAttribute("max", today);

        let weekViewDate = new Date(currentDate);
        weekViewDate.setDate(weekViewDate.getDate() - 7);

        let monthViewDate = new Date(currentDate);
        monthViewDate.setDate(monthViewDate.getDate() - 31);

        let yearViewDate = new Date(currentDate);
        yearViewDate.setDate(yearViewDate.getDate() - 365);
        
        let xMin;

        //User data arrays
        let calData = [];
        let weightData = [];
        let waterData = [];
        let sleepData = [];
        let exerciseData = [];

        //Biometric info
        let height, weightGoal;

        /**
         * Code to fill these arrays and height and weightgoal with data from the database
         * goes here
         * 
        */

        //fills to find max y value and min x value
        let myValues = [];
        let myDates = [];
        for (let x of calData) { myValues.push(x.value); myDates.push(x.date);}
        for (let x of weightData) { myValues.push(x.value); myDates.push(x.date);}
        for (let x of waterData) { myValues.push(x.value); myDates.push(x.date);}
        for (let x of sleepData) { myValues.push(x.value); myDates.push(x.date);}
        for (let x of exerciseData) { myValues.push(x.value); myDates.push(x.date);}

        if(typeof height != 'undefined'){ document.getElementById("height").value = height; }
        if(typeof weightGoal != 'undefined'){ document.getElementById("weightGoal").value = weightGoal; }
        
        function updateBio(){
            let h = parseFloat(document.getElementById("height").value);
            if(!isNaN(h)){
                height = h;
            }
            let w = parseFloat(document.getElementById("weightGoal").value);
            if(!isNaN(w)){
                weightGoal = w;
            }
            console.log(height + ' ' + weightGoal);

            //send stuff to DB
        }

        //Pulls the values from the form, checks that the input is a number
        //uses switch to send to correct array
        function graph() {
            let dataSet = document.getElementById('dataSet').value;
            let myDate = document.graphInput.inputDate.value;
            let val = document.graphInput.val.value;
            let numVal = parseFloat(val);

            if (!isNaN(numVal)) {
                switch (dataSet) {
                    case "cal":
                        dataUpdateFunction(myDate, numVal, calData);
                        break;
                    case "weight":
                        dataUpdateFunction(myDate, numVal, weightData);
                        break;
                    case "water":
                        dataUpdateFunction(myDate, numVal, waterData);
                        break;
                    case "sleep":
                        dataUpdateFunction(myDate, numVal, sleepData);
                        break;
                    case "exercise":
                        dataUpdateFunction(myDate, numVal, exerciseData);
                        break;
                }

                myChart.update();
            }
        }
        
        //Got too lost in my original graph function, moved work here for clarity
        //Pushes a date and value into an array and then sorts by date
        function dataUpdateFunction(daDate, numberValue, dataSet) {
            let ind = -1;
            let inputDateCheck = new Date(daDate);
            for (let dataPoint of dataSet){
                let dateCheck = new Date(dataPoint.date);
                if(dateCheck.getTime() === inputDateCheck.getTime()){
                    ind = dataSet.indexOf(dataPoint);
                }
            }
            if(ind >= 0){
                myValues.splice(myValues.indexOf(dataSet[ind].value), 1);
                dataSet[ind].value = dataSet[ind].value + numberValue;
                myValues.push(dataSet[ind].value);
            }else{
                dataSet.push({ date: daDate, value: numberValue });
                myValues.push(numberValue);
                myDates.push(daDate);
            }
            dataDateSort(dataSet);
            
            setMax(myChart);
            setMin(myChart);
            myChart.options.scales.x.min = new Date(daDate).setDate(new Date(daDate).getDate()-7);
            myChart.update();
        }
        
        //sorts arrays by a date variable
        function dataDateSort(dataSet) {
            dataSet = dataSet.sort(function (a, b) {
                const dateA = a.date;
                const dateB = b.date;
                if (dateA < dateB) {
                    return -1;
                }
                if (dateB < dateA) {
                    return 1
                }
                return 0;
            });
        }
        
        function setMax(chart) {
            myValues.sort(function (a, b) {
                return b - a;
            });
            let max = myValues[0] + (myValues[0] / 5);
            if (!isNaN(max)) {
                let modStuff = max % 10;
                if (modStuff != 0) {
                    max = max + (10 - modStuff);
                }
                chart.options.scales.y.max = max;
                chart.update();
            }
        }

        function setMin(chart){
            //if(myDates.length != 0){
                myDates.sort(function (a, b) {
                    if (a < b) {
                    return -1;
                }
                if (b < a) {
                    return 1
                }
                return 0;
                });
                xMin = new Date(myDates[0]);
                xMin.setDate(xMin.getDate()-7);
            //}
        }

        //Functions to change the time scale view
        function updateWeekScale(chart) {
            chart.options.scales.x.min = weekViewDate;
            chart.update();
        }

        function updateMonthScale(chart) {
            chart.options.scales.x.min = monthViewDate;
            chart.update();
        }

        function updateYearScale(chart) {
            chart.options.scales.x.min = yearViewDate;
            chart.update();
        }

        function updateFullScale(chart) {
            if(isValidDate(xMin)){
                chart.options.scales.x.min = xMin;
            }else{
                chart.options.scales.x.min = weekViewDate;
            }

            chart.update();
        }

        function isValidDate(d){
            return d instanceof Date && !isNaN(d);
        }

        function saveData(){
            //sends everything to the database
        }

        //the chart itself
        const ctx = document.getElementById('myChart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'line',
            data: {
                //5 datasets
                datasets: [{
                    label: 'Calories',
                    data: calData,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                    ],
                    borderWidth: 1,
                    tension: 0.5,
                    parsing: {
                        xAxisKey: 'date',
                        yAxisKey: 'value'
                    }
                }, {
                    label: 'Weight (lbs)',
                    data: weightData,
                    backgroundColor: [
                        'rgba(255,165,0, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255,165,0, 1)',
                    ],
                    borderWidth: 1,
                    tension: 0.5,
                    parsing: {
                        xAxisKey: 'date',
                        yAxisKey: 'value'
                    }
                }, {
                    label: 'Water (Oz.)',
                    data: waterData,
                    backgroundColor: [
                        'rgba(25, 255, 255, 0.2)'
                    ],
                    borderColor: [
                        'rgba(25, 255, 255, 1)',
                    ],
                    borderWidth: 1,
                    tension: 0.5,
                    parsing: {
                        xAxisKey: 'date',
                        yAxisKey: 'value'
                    }
                }, {
                    label: 'Exercise (min)',
                    data: exerciseData,
                    backgroundColor: [
                        'rgba(255, 255, 25, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 255, 25, 1)',
                    ],
                    borderWidth: 1,
                    tension: 0.5,
                    parsing: {
                        xAxisKey: 'date',
                        yAxisKey: 'value'
                    }
                }, {
                    label: 'Sleep (hours)',
                    data: sleepData,
                    backgroundColor: [
                        'rgba(25, 25, 255, 0.2)'
                    ],
                    borderColor: [
                        'rgba(25, 25, 255, 1)',
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
                        min: weekViewDate,
                        max: currentDate,
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
                        max: 600,
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
                        labels: {
                            color: '#FFFFFF'
                        },
                        //hides the line when a legend box is clicked and removes the values from myValues to update the max
                        //reveals the line when a legend box is clicked and and adds the data back into myValues
                        onClick(e, legendItem, legend) {
                            const index = legendItem.datasetIndex, chart = legend.chart;
                            if (chart.isDatasetVisible(index)) {
                                chart.hide(index);
                                legendItem.hidden = !0;
                                for (let dataPoint of chart.data.datasets[index].data) {
                                    let ind = myValues.indexOf(dataPoint.value);
                                    myValues.splice(ind, 1);
                                    let ind2 = myDates.indexOf(dataPoint.date);
                                    myDates.splice(ind2, 1);
                                }
                            } else {
                                chart.show(index);
                                legendItem.hidden = !1;
                                for (let dataPoint of chart.data.datasets[index].data) {
                                    myValues.push(dataPoint.value);
                                    myDates.push(dataPoint.date);
                                }
                            }
                            setMax(chart);
                            setMin(chart);
                        }
                    }
                },
                //Removes single datapoint when clicked
                onClick: (evt, activeElements, chart) => {
                    if(activeElements[0] != null){
                        let dataInd = activeElements[0].datasetIndex;
                        let pointInd = activeElements[0].index;
                        let dataPoint = chart.data.datasets[dataInd].data[pointInd];

                        chart.data.datasets[dataInd].data.splice(pointInd, 1);
                        chart.update();

                        let valInd = myValues.indexOf(dataPoint.value);
                        let dateInd = myDates.indexOf(dataPoint.date);
                        myValues.splice(valInd, 1);
                        myDates.splice(dateInd, 1);
                        
                        setMax(chart);
                        setMin(chart);
                    }
                }
            }
        });
        setMax(myChart);
        setMin(myChart);
        myChart.update();
    </script>
</body>

</html>