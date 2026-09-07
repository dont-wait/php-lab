function loadChat() {
    fetch("chat.php")
        .then(res => res.json())
        .then(data => {
            document.getElementById("chat").value = data.join("\n");
        });
}

function send() {
    let input = document.getElementById("msg");
    let message = input.value.trim();
    if (message === "") {
        return;
    }

    let formData = new FormData();
    formData.append("msg", message);
    fetch("chat.php", {
        method: "POST",
        body: formData
    }).then(() => {
        input.value = "";
        loadChat();
    });
}

setInterval(loadChat, 2000);
loadChat();
