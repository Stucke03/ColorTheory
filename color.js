document.addEventListener("DOMContentLoaded", function () {

    const grid = document.getElementById("grid");

    if (!grid) {
        console.warn("Grid not found");
        return;
    }

    const n = parseInt(grid.getAttribute("data-size"), 10);

    if (isNaN(n) || n < 1) {
        console.warn("Invalid grid size:", n);
        return;
    }

    buildGrid(n);

    function buildGrid(n) {
        grid.innerHTML = "";

        for (let i = 0; i <= n; i++) {
            const row = document.createElement("tr");

            for (let j = 0; j <= n; j++) {
                const cell = document.createElement("td");

                if (i === 0 && j === 0) {
                    cell.textContent = "";
                } 
                else if (i === 0) {
                    cell.textContent = String.fromCharCode(64 + j);
                } 
                else if (j === 0) {
                    cell.textContent = i;
                } 
                else {
                    cell.textContent = "";
                }

                row.appendChild(cell);
            }

            grid.appendChild(row);
        }
    }

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

    function updatePreviews() {
        document.querySelectorAll(".color-preview").forEach((cell, i) => {
            if (dropdowns[i]) {
                cell.style.backgroundColor = dropdowns[i].value.toLowerCase();
            }
        });
    }

    updatePreviews();

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

});