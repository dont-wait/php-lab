// Câu 1.3 — Lab 3 bài 2: Event, createElement, appendChild.
// Ref: lab3/bai2/index.js. textContent hiển thị chữ, không thực thi HTML.
document.getElementById('device-form').addEventListener('submit', (event) => {
    event.preventDefault();
    const input = document.getElementById('device-name');
    const name = input.value.trim();
    const message = document.getElementById('message');
    if (name === '') { message.textContent = 'Tên thiết bị không được rỗng.'; return; }
    const li = document.createElement('li');
    li.textContent = name;
    document.getElementById('device-list').appendChild(li);
    input.value = '';
    input.focus();
    message.textContent = '';
});
