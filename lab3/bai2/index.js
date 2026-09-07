function changeBg() {
    document.body.style.backgroundColor = "#" + Math.floor(Math.random() * 16777215).toString(16);
}
function showText() {
    document.getElementById("output").innerText = document.getElementById("txt").value;
}
function addItem() {
    let val = document.getElementById("item").value;
    if (val.trim() !== "") {
        let li = document.createElement("li");
        li.innerText = val;
        li = document.getElementById("list").appendChild(li);
    }
} 
