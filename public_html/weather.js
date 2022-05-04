let weather = {
    apiKey: "1892ca513ed75a39bb5b9a447572045b",
    fetchWeather: function(city) {
        fetch(
        "https://api.openweathermap.org/data/2.5/weather?q="
        + city 
        + "&units=imperial&appid=" 
        + this.apiKey
    )
        .then((response) => response.json())
        .then((data) => this.displayWeather(data));
    },
    displayWeather: function(data) {
        const { name } = data;
        const { icon, description } = data.weather[0];
        const { temp, humidity } = data.main;
        const { speed } = data.wind;
        //console.log(name,icon,description,temp,humidity,speed);
        document.querySelector(".city").innerText =  "Weather in " + name;
        document.querySelector(".icon").src = "http://openweathermap.org/img/wn/" + icon + ".png";
        document.querySelector(".temp").innerText = temp + "°F";
        document.querySelector(".description").innerText = description;
        document.querySelector(".humidity").innerText = "Humidity: " + humidity + "%";
        document.querySelector(".wind").innerText = "Wind Speed: " + speed + " MPH";
    },
    search: function() {
        this.fetchWeather(document.querySelector(".weatherSearch").value);
    }
};
document.querySelector(".search button").addEventListener("click", function() {
    weather.search();
})

document.querySelector(".weatherSearch").addEventListener("keyup", function(event) {
    if (event.key == "Enter") {
        weather.search();
    }
})