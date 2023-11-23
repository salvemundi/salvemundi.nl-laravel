window.generateTicketInputs = function (id, price) {
  const amountOfTickets = parseInt(
    document.getElementById("amountOfTickets" + id).value,
  );
  const ticketInputsContainer = document.getElementById("ticketInputs" + id);

  // Clear existing inputs
  ticketInputsContainer.innerHTML = "";
  for (let i = 0; i < amountOfTickets; i++) {
    // Create label element
    const label = document.createElement("label");
    label.setAttribute("for", `participant_${i}`);
    label.className = "form-label";
    label.innerText = `Naam deelnemer ${i + 1}`;

    // Create input element
    const input = document.createElement("input");
    input.required = true;
    input.type = "text";
    input.className = "form-control";
    input.id = `participant_${i}_${id}`;
    input.name = "participant[]";
    input.setAttribute("aria-describedby", "basic-addon3");

    // Append label and input to the container
    ticketInputsContainer.appendChild(label);
    ticketInputsContainer.appendChild(input);

    // Update the price on the submit button
    let newPrice = amountOfTickets * price;
    document.getElementById("submitGroupTicketSignup" + id).textContent =
      "Inschrijven € " + newPrice;
  }
};
