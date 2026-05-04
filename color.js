document.addEventListener("DOMContentLoaded", function () {

    const grid = document.getElementById("grid");
    const n = parseInt(grid.getAttribute("data-size"));

    buildGrid(n);

    const dropdowns = document.querySelectorAll(".color-dropdown");
    const warning = document.getElementById("color-warning");

    dropdowns.forEach(drop => {
        drop.dataset.previous = drop.value;

        drop.addEventListener("change", () => {
            const previous = drop.dataset.previous;

            const used = Array.from(dropdowns)
                .filter(d => d !== drop)
                .map(d => d.value);

            if (used.includes(drop.value)) {
                warning.textContent = "That color is already in use.";
                drop.value = previous;
                return;
            }

            warning.textContent = "";

            drop.dataset.previous = drop.value;

            updatePreviews();
            recolorGrid();
        });
    });

    updatePreviews();

    const radioButtons = document.querySelectorAll('input[name="selected_color"]');
    let activeColor = dropdowns[0].value.toLowerCase();

    for (let i = 0; i < radioButtons.length; i++) {
        if (radioButtons[i].checked) {
            activeColor = dropdowns[i].value.toLowerCase();
        }
    }

    radioButtons.forEach(radio => {
        radio.addEventListener("change", () => {
            for (let i = 0; i < radioButtons.length; i++) {
                if (radioButtons[i].checked) {
                    activeColor = dropdowns[i].value.toLowerCase();
                }
            }
        });
    });

    const coordOwner = {};

    document.getElementById("grid").addEventListener("click", (cell) => {
        if (cell.target.classList.contains("inner")) {

            const owner = getActiveIndex();
            const row = cell.target.dataset.row;
            const col = cell.target.dataset.col;
            const coord = `${col}${row}`;

            if (coordOwner[coord] === owner) return;

            coordOwner[coord] = owner;

            cell.target.dataset.owner = owner;
            applyColorToCell(cell.target);

            renderCoordinates();
        }
    });

    window.preparePrintData = function () {
        const container = document.getElementById("hidden-color-inputs");
        const form = document.getElementById("print-form");

        if (!container || !form) return;

        container.innerHTML = "";

        const rowCoords = {};

        dropdowns.forEach((_, i) => {
            rowCoords[i] = [];
        });

        Object.keys(coordOwner).forEach(coord => {
            const owner = coordOwner[coord];
            rowCoords[owner].push(coord);
        });

        dropdowns.forEach((drop, i) => {
            const color = drop.value.toLowerCase();
            const coords = sortCoords(rowCoords[i]).join(", ");

            const input = document.createElement("input");
            input.type = "hidden";
            input.name = "row_" + i;
            input.value = color + "|" + coords;

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
                } else if (i === 0) {
                    cell.textContent = String.fromCharCode(64 + j);
                } else if (j === 0) {
                    cell.textContent = i;
                } else {
                    cell.textContent = "";
                    cell.classList.add("inner");
                }

                cell.dataset.row = i;
                cell.dataset.col = String.fromCharCode(64 + j);

                row.appendChild(cell);
            }

            grid.appendChild(row);
        }
    }

    function renderCoordinates() {
        const coordDisplays = document.querySelectorAll(".coord-display");
        const rowCoords = {};

        dropdowns.forEach((_, i) => {
            rowCoords[i] = [];
        });

        Object.keys(coordOwner).forEach(coord => {
            const owner = coordOwner[coord];
            rowCoords[owner].push(coord);
        });

        dropdowns.forEach((_, i) => {
            const sorted = sortCoords(rowCoords[i]);
            coordDisplays[i].textContent = sorted.join(", ");
        });
    }

    function sortCoords(coords) {
        return coords.sort((a, b) => {
            const [aLetter, aNum] = [a[0], parseInt(a.slice(1))];
            const [bLetter, bNum] = [b[0], parseInt(b.slice(1))];

            if (aLetter === bLetter) {
                return aNum - bNum;
            }
            return aLetter.localeCompare(bLetter);
        });
    }

    function applyColorToCell(cell) {
        const owner = cell.dataset.owner;
        if (owner !== undefined) {
            const color = dropdowns[owner].value.toLowerCase();
            cell.style.backgroundColor = color;
        }
    }

    function recolorGrid() {
        document.querySelectorAll(".inner").forEach(cell => {
            applyColorToCell(cell);
        });
    }

    function getActiveIndex() {
        for (let i = 0; i < radioButtons.length; i++) {
            if (radioButtons[i].checked) {
                return i;
            }
        }
        return 0;
    }

});