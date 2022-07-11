const dimension_x = 100;
const dimension_y = 100;

/**
 * Creates a static empty grid.
 */
function createGrid() {
    const table = document.getElementById("grid");
    for (let i = 0; i < dimension_x; i++) {
        const row = document.createElement("tr");
        table.appendChild(row);
        for (let j = 0; j < dimension_y; j++) {
            const cell = document.createElement("td");
            cell.setAttribute("id", "cell-" + i + "-" + j);
            row.appendChild(cell);
        }
    }
}

/**
 * Fetches the grid state from the server.
 */
function fetchGrid() {
    fetch('/api/get-state/')
        .then(response => response.json())
        .then(data => populateGrid(data['grid-state']))
}

/**
 * Updates the grid with the given state data.
 * @param grid string representation of the grid state.
 */
function populateGrid(grid) {
    for (let i = 0; i < grid.length; i++) {
        if (grid[i] === "1") {
            const pos_x = ~~(i / dimension_x); // Quotient
            const pos_y = i % dimension_y; // Remainder
            openCell(pos_x, pos_y);
        }
    }
}

/**
 * Initializes the grid by creating and fetching the grid state.
 */
function initializeGrid() {
    createGrid();
    fetchGrid();
}

/**
 * Modifies the cell at a given location to look and act opened.
 * @param x horizontal position
 * @param y vertical position
 */
function openCell(x, y) {
    const cell = document.getElementById("cell-" + x + "-" + y);
    cell.setAttribute("class", "opened");
    cell.setAttribute("onclick", "alert('This cell has already been picked!')");
}

document.onreadystatechange = function() {
    if(document.readyState === "complete") {
        initializeGrid();
    }
}