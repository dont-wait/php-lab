function createCheckButton(li, todo) {
    let checkButton = document.createElement("input");
    checkButton.type = "checkbox";
    checkButton.checked = todo.isDone;
    checkButton.addEventListener("change", () => {
        let formData = new FormData();
        formData.append("action", "toggle");
        formData.append("id", todo.id);
        formData.append("isDone", checkButton.checked);

        fetch("todo.php", {
            method: "POST",
            body: formData
        })
            .then(res => res.json())
            .then(data => loadData(data));
    });
    li.appendChild(checkButton);
}

function createDeleteButton(li, todo) {
    let deleteButton = document.createElement("button");
    deleteButton.innerText = "Xoa";
    deleteButton.addEventListener("click", () => {
        let formData = new FormData();
        formData.append("action", "delete");
        formData.append("id", todo.id);

        fetch("todo.php", {
            method: "POST",
            body: formData
        })
            .then(res => res.json())
            .then(data => loadData(data));
    });
    li.appendChild(deleteButton);
}

function createTodoItem(todo) {
    let li = document.createElement("li");
    if (todo.isDone) {
        li.classList.add("done");
    }

    let todoText = document.createElement("span");
    todoText.innerText = todo.todo;
    li.appendChild(todoText);
    createCheckButton(li, todo);
    createDeleteButton(li, todo);
    document.getElementById("list").appendChild(li);
}

function loadData(data) {
    document.getElementById("list").innerHTML = "";
    if (data) {
        data.forEach(todo => createTodoItem(todo));
        return;
    }

    fetch("todo.php")
        .then(res => res.json())
        .then(data => data.forEach(todo => createTodoItem(todo)));
}

function send() {
    let input = document.getElementById("todo");
    let todo = input.value.trim();
    if (todo === "") {
        return;
    }

    let formData = new FormData();
    formData.append("action", "create");
    formData.append("todo", todo);
    fetch("todo.php", {
        method: "POST",
        body: formData
    })
        .then(res => res.json())
        .then(data => {
            input.value = "";
            loadData(data);
        });
}

loadData();
