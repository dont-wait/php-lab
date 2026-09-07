const form = document.getElementById("registerForm");
const message = document.getElementById("message");

form.addEventListener("submit", async (event) => {
  event.preventDefault();
  const username = document.getElementById("username").value.trim();
  const email = document.getElementById("email").value.trim();
  const password = document.getElementById("password").value;
  const confirmPassword = document.getElementById("confirmPassword").value;

  if (username.length < 3) {
    message.textContent = "Username phải có ít nhất 3 ký tự.";
    return;
  }

  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

  if (!emailRegex.test(email)) {
    message.textContent = "Email không hợp lệ.";
    return;
  }

  if (password.length < 6) {
    message.textContent = "Mật khẩu phải có ít nhất 6 ký tự.";
    return;
  }

  if (password !== confirmPassword) {
    message.textContent = "Mật khẩu nhập lại không khớp.";
    return;
  }

  try {
    const response = await fetch("register.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        username,
        email,
        password,
      }),
    });

    const result = await response.json();
    message.textContent = result.message;

    if (result.success) {
      form.reset();
    }
  } catch (error) {
    console.error(error);
    message.textContent = "Không thể kết nối đến server.";
  }
});
