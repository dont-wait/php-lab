function validateEmail() {
    var emailInput = document.getElementById("email");
    var message = document.getElementById("msg");
    var email = emailInput.value.trim();
    var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (emailPattern.test(email)) {
        message.textContent = "Email hop le";
        message.style.color = "green";
    } else {
        message.textContent = "Email khong hop le";
        message.style.color = "red";
    }
    return false;
}
function updateClock() {
    let now = new Date();
    document.getElementById("clock").innerText = now.toLocaleTimeString()
}
setInterval(updateClock, 1000);
updateClock();
