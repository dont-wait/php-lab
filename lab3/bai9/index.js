function getWeather() {
    let city = document.getElementById("city").value.trim();
    fetch("weather.php?city=" + encodeURIComponent(city))
        .then(res => res.json())
        .then(data => {
            document.getElementById("weather").innerHTML =
                `<h3>${city}</h3><p>Nhiet do: ${data.temp}&deg;C</p><p>${data.desc}</p>`;
        });
}
