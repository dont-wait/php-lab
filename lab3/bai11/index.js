const rateTable = document.getElementById("rateTable");
const loading = document.getElementById("loading");
const error = document.getElementById("error");
const lastUpdate = document.getElementById("lastUpdate");

function renderRates(rates) {
    rateTable.innerHTML = "";
    Object.entries(rates).forEach(([currency, rate], index) => {
        let row = document.createElement("tr");
        row.innerHTML = `
            <td>${index + 1}</td>
            <td>${currency}</td>
            <td>${Number(rate).toLocaleString("vi-VN")}</td>
        `;
        rateTable.appendChild(row);
    });
}

function loadExchangeRates() {
    loading.innerText = "Dang tai du lieu...";
    error.innerText = "";
    fetch("api.php")
        .then(res => res.json())
        .then(data => {
            if (!data.success) {
                throw new Error(data.message);
            }
            renderRates(data.rates);
            lastUpdate.innerText = data.time;
        })
        .catch(err => error.innerText = "Loi: " + err.message)
        .finally(() => loading.innerText = "");
}

loadExchangeRates();
setInterval(loadExchangeRates, 10 * 60 * 1000);
