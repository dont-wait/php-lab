function getTime() {
    fetch('time.php')
        .then(res => res.text())
        .then(data => document.getElementById("time").innerText = data);
}

getTime();
setInterval(getTime, 5000);
