// Lab 3 Fetch/JSON; render bằng textContent. POST JSON dùng CSRF header.
async function request(url, options) {
    const response = await fetch(url, options);
    const data = await response.json();
    if (!response.ok) throw new Error(data.error || JSON.stringify(data.errors));
    return data;
}
let searchVersion = 0;
document.getElementById('search').addEventListener('submit', async (event) => {
    event.preventDefault();
    const version = ++searchVersion;
    const list = document.getElementById('devices');
    const message = document.getElementById('message');
    list.replaceChildren();
    try {
        const params = new URLSearchParams({keyword: document.getElementById('keyword').value.trim()});
        const data = await request('api.php?' + params);
        if (version !== searchVersion) return;
        for (const device of data) {
            const li = document.createElement('li');
            li.textContent = device.device_name + ' — ' + device.price;
            list.appendChild(li);
        }
        message.textContent = data.length ? data.length + ' kết quả.' : 'Không có dữ liệu.';
    } catch (error) { if (version === searchVersion) message.textContent = error.message; }
});
document.getElementById('send').addEventListener('submit', async (event) => {
    event.preventDefault();
    try {
        const data = await request('api.php', {method: 'POST',
            headers: {'Content-Type': 'application/json', 'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').content},
            body: JSON.stringify({name: document.getElementById('name').value.trim()})});
        document.getElementById('message').textContent = data.message + ': ' + data.name;
    } catch (error) { document.getElementById('message').textContent = error.message; }
});
