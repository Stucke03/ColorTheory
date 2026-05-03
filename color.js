document.addEventListener("DOMContentLoaded", function () {

    const grid = document.getElementById("grid");
    const n = parseInt(grid.getAttribute("data-size"));

    buildGrid(n);

    const dropdowns = document.querySelectorAll(".color-dropdown");
    const warning = document.getElementById("color-warning");

    dropdowns.forEach(drop => {
        drop.dataset.previous = drop.value;

        drop.addEventListener("change", () => {

            const used = Array.from(dropdowns)
                .filter(d => d !== drop)
                .map(d => d.value);

            if (used.includes(drop.value)) {
                warning.textContent = "That color is already in use.";
                drop.value = drop.dataset.previous;
            } else {
                warning.textContent = "";
                drop.dataset.previous = drop.value;
            }

            updatePreviews();
        });
    });

    updatePreviews();

    const radioButtons = document.querySelectorAll('input[name="selected_color"]');
    let activeColor = dropdowns[0].value.toLowerCase();

    for (let i = 0; i < radioButtons.length; i++){
        if (radioButtons[i].checked){
            activeColor = dropdowns[i].value.toLowerCase();
        }
    }

    radioButtons.forEach(radio => {
        radio.addEventListener("change", () => {
            for (let i = 0; i < radioButtons.length; i++){
                if (radioButtons[i].checked){
                    activeColor = dropdowns[i].value.toLowerCase();
                }
            }
        });
    });

    document.getElementById("grid").addEventListener("click", (e) => {
    if (e.target.classList.contains("inner")) {
        console.log("click");
        e.target.style.backgroundColor = activeColor;
    }
});

    window.collectColors = function () {
        const container = document.getElementById("hidden-color-inputs");
        if (!container) return;

        container.innerHTML = "";

        document.querySelectorAll(".color-dropdown").forEach(drop => {
            const input = document.createElement("input");
            input.type = "hidden";
            input.name = "selected_colors[]";
            input.value = drop.value;
            container.appendChild(input);
        });
    };

    function updatePreviews() {
        document.querySelectorAll(".color-preview").forEach((cell, i) => {
            if (dropdowns[i]) {
                cell.style.backgroundColor = dropdowns[i].value.toLowerCase();
            }
        });
    }

    function buildGrid(n) {
        grid.innerHTML = "";

        for (let i = 0; i <= n; i++) {
            const row = document.createElement("tr");

            for (let j = 0; j <= n; j++) {
                const cell = document.createElement("td");

                if (i === 0 && j === 0) {
                    cell.textContent = "";
                    cell.classList.add("inner");
                } 
                else if (i === 0) {
                    cell.textContent = String.fromCharCode(64 + j);
                } 
                else if (j === 0) {
                    cell.textContent = i;
                } 
                else {
                    cell.textContent = "";
                    cell.classList.add("inner");
                }

                row.appendChild(cell);
            }

            grid.appendChild(row);
        }
    }
});