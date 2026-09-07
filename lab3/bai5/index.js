function sayHello() {
    let formData = new FormData();
    formData.append('name', document.getElementById('name').value);
    fetch('hello.php', {
        method: 'POST',
        body: formData
    })
        .then(res => res.text())
        .then(data => document.getElementById("msg").innerText = data);
}
