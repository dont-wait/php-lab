const form = document.getElementById("registerForm");
const message = document.getElementById("message");

form.addEventListener("submit", event => {
    event.preventDefault();
    let username = document.getElementById("username").value.trim();
    let email = document.getElementById("email").value.trim();
    let password = document.getElementById("password").value;
    let confirmPassword = document.getElementById("confirmPassword").value;

    if (username.length < 3) {
        message.innerText = "Ten dang nhap phai co it nhat 3 ky tu";
        return;
    }
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        message.innerText = "Email khong hop le";
        return;
    }
    if (password.length < 6) {
        message.innerText = "Mat khau phai co it nhat 6 ky tu";
        return;
    }
    if (password !== confirmPassword) {
        message.innerText = "Mat khau nhap lai khong khop";
        return;
    }

    fetch("register.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ username, email, password })
    })
        .then(res => res.json())
        .then(data => {
            message.innerText = data.message;
            message.style.color = data.success ? "green" : "red";
            if (data.success) {
                form.reset();
            }
        })
        .catch(() => {
            message.innerText = "Khong the ket noi den server";
            message.style.color = "red";
        });
});
