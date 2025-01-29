document.getElementById('getWeatherBtn').addEventListener('click', function() {
    const city = document.getElementById('cityInput').value;
    const apiKey = '1d20c7f2ae1a7b2e8545831db9522907';
    const url = `https://api.openweathermap.org/data/2.5/weather?q=${city}&appid=${apiKey}&units=metric`;

    fetch(url)
        .then(response => {
            if (!response.ok) {
                throw new Error('Город не найден');
            }
            return response.json();
        })
        .then(data => {
            document.getElementById('weatherResult').innerHTML = `
                <h2>${data.name}, ${data.sys.country}</h2>
                <p>Температура: ${data.main.temp} °C</p>
                <p>Описание: ${data.weather[0].description}</p>
            `;
        })
        .catch(error => {
            document.getElementById('weatherResult').innerHTML = `
                <p>${error.message}</p>
            `;
        });
});