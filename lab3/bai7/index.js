function search() {
    let q = document.getElementById("kw").value;
    fetch("search.php?q=" + encodeURIComponent(q))
        .then(res => res.json())
        .then(data => {
            document.getElementById("result").innerHTML = data
                .map(p => `<li>${p.name} - ${p.price.toLocaleString("vi-VN")} dong</li>`)
                .join("");
        });
}
