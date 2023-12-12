document.addEventListener("DOMContentLoaded", function () {
    const snowflakesContainer = document.querySelector(".snowflakes");
    const numberOfSnowflakes = 400;

    for (let i = 0; i < numberOfSnowflakes; i++) {
        createSnowflake();
    }

    function createSnowflake() {
        const snowflake = document.createElement("div");
        snowflake.className = "snowflake";
        snowflakesContainer.appendChild(snowflake);

        // Set initial position for each snowflake
        snowflake.style.left = `${Math.random() * 100}vw`; // Allow snowflakes to cover the entire width
        snowflake.style.top = `${Math.random() * 100}vh`;

        // Set a random animation duration for each snowflake
        snowflake.style.animationDuration = `${Math.random() * 5 + 5}s`;

        // Trigger animation immediately
        snowflake.style.animationDelay = `-${Math.random() * 5}s`;
    }
});