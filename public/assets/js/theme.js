console.log("theme.js loaded");

document.addEventListener("DOMContentLoaded", () => {
    const btn = document.getElementById("darkModeToggle");

    console.log("Button:", btn);

    btn.addEventListener("click", () => {
        console.log("BUTTON CLICKED");

        document.body.classList.toggle("dark_mode");

        console.log("Body classes:", document.body.className);
    });
});
