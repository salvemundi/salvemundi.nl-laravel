function generateTicketInputs() {
    const amountOfTickets = parseInt(document.getElementById("amountOfTickets").value);
    const ticketInputsContainer = document.getElementById("ticketInputs");

    // Clear existing inputs
    ticketInputsContainer.innerHTML = "";

    for (let i = 0; i < amountOfTickets; i++) {
        // Create label element
        const label = document.createElement("label");
        label.setAttribute("for", `participant_${i}`);
        label.className = "form-label";
        label.innerText = `Naam deelenemer ${i + 1}`;

        // Create input element
        const input = document.createElement("input");
        input.required = true;
        input.type = "text";
        input.className = "form-control";
        input.id = `participant_${i}`;
        input.name = "participant[]";
        input.setAttribute("aria-describedby", "basic-addon3");

        // Append label and input to the container
        ticketInputsContainer.appendChild(label);
        ticketInputsContainer.appendChild(input);
    }
}
document.getElementById("amountOfTickets").addEventListener("input", generateTicketInputs);

document.getElementById("ticketForm").addEventListener("submit", function(event) {
    event.preventDefault();
    // Handle the form submission here
});