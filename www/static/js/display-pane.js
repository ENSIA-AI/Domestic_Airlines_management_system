const key = "8939aa6d02b68a08f665b597809a70b8";

async function getWeather(place) {

    const url = `https://api.openweathermap.org/data/2.5/weather?q=${place}&appid=${key}&units=metric`;
    const temp = document.querySelector("#temp");

    try {
        const response = await fetch(url);
        const data = await response.json();

        temp.textContent = Math.round(data.main.temp) + "°C";

    } catch (error) {
        console.error("Error fetching data:", error);
    }
}

