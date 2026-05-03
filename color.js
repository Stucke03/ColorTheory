document.addEventListener("DOMContentLoaded", function () {

    const grid = document.getElementById("grid");
    const n = parseInt(grid.getAttribute("data-size"));

    buildGrid(n);

    const dropdowns = document.querySelectorAll(".color-dropdown");
    const warning = document.getElementById("color-warning");
    const colorMap = {};

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

            const oldColor = drop.dataset.previous
            const newColor = drop.value.toLowerCase();

            colorMap[oldColor] = newColor;

            updatePreviews();
            recolorGrid();
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
    const coordDisplays = document.querySelectorAll(".coord-display");
    const colorData = {};
    const coordOwner = {};

    document.getElementById("grid").addEventListener("click", (cell) => {
    if (cell.target.classList.contains("inner")) {
        cell.target.style.backgroundColor = activeColor;

        const row = cell.target.dataset.row;
        const col = cell.target.dataset.col;
        const coord = `${col}${row}`

        if (coordOwner[coord] === activeColor) return;

        const previousColor = coordOwner[coord];
    if (previousColor) {
        colorData[previousColor] =
            colorData[previousColor].filter(c => c !== coord);
    }

    coordOwner[coord] = activeColor;
    if (!colorData[activeColor]){
            colorData[activeColor] = [];
        }
    colorData[activeColor].push(coord);
    cell.target.dataset.color = activeColor;
    applyColorToCell(cell.target);

    renderCoordinates();
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

                cell.dataset.row = i;
                cell.dataset.col = String.fromCharCode(64 + j);

                row.appendChild(cell);
            }

            grid.appendChild(row);
        }
    }

    function renderCoordinates() {
    radioButtons.forEach((radio, i) => {
        const color = dropdowns[i].value.toLowerCase();

        const coords = colorData[color] || [];
        const sorted = sortCoords([...coords]);

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
    const baseColor = cell.dataset.color;

    const finalColor = resolveColor(baseColor);

    cell.style.backgroundColor = finalColor;
    }

    function resolveColor(color) {
    while (colorMap[color]) {
        color = colorMap[color];
    }
    return color
}

function recolorGrid() {
    document.querySelectorAll(".inner").forEach(cell => {
        applyColorToCell(cell);
    });
}
});