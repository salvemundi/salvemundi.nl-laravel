let counter = 0;

function addInputField() {
    let div = document.getElementById('associationInputs');
    const inputContainer = document.createElement('div');
    inputContainer.className = "d-flex";
    inputContainer.id = `association${counter}`;

    const input = document.createElement("input");
    input.required = true;
    input.type = "text";
    input.className = "form-control mb-2";
    input.name = "associationName[]";
    input.setAttribute("aria-describedby", "basic-addon3");

    const removeButton = document.createElement('a');
    removeButton.className = "btn btn-primary mb-2";
    removeButton.innerHTML = `<i class="fas fa-minus fa-sm"></i>`;
    removeButton.onclick = function () {
        removeInputField(inputContainer.id);
    }

    inputContainer.appendChild(input);
    inputContainer.appendChild(removeButton);

    div.appendChild(inputContainer);

    counter++;
}

document.getElementById("addInputField").addEventListener("click", addInputField);

function removeInputField(id) {
    document.getElementById(id).remove();
}
