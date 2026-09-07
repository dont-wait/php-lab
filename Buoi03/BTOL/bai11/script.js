const rateTable = document.getElementById("rateTable");
const loading = document.getElementById("loading");
const error = document.getElementById("error");
const lastUpdate = document.getElementById("lastUpdate");

async function loadExchangeRates() {
    loading.textContent = "Đang tải dữ liệu...";
    error.textContent = "";
    try {
        const response = await fetch("api.php");
        if (!response.ok) {
            throw new Error("HTTP Error: " + response.status);
        }

        const data = await response.json();
        if (!data.success) {
            throw new Error(data.message);
        }

        renderRates(data.rates);
        lastUpdate.textContent = data.time;
    } catch (err) {
        error.textContent = "Lỗi: " + err.message;
    } finally {
        loading.textContent = "";
    }
}

function renderRates(rates) {
    rateTable.innerHTML = "";
    const currencies = Object.entries(rates);
    currencies.forEach(([currency, rate], index) => {
        const row = document.createElement("tr");
        row.innerHTML = `
            <td>${index + 1}</td>
            <td>${currency}</td>
            <td>${Number(rate).toLocaleString("vi-VN")}</td>
        `;
        rateTable.appendChild(row);
    });
}

loadExchangeRates();
setInterval(loadExchangeRates, 10 * 60 * 1000);