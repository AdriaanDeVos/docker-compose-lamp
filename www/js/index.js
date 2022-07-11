const dimension_x = 100;
const dimension_y = 100;

// As there is no authentication required by the case description, we generate a random username.
const username = (Math.random() + 1).toString(36).substring(3);

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
            cell.setAttribute("onclick", "postGuess(" + i + ", " + j + ")");
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

/**
 * Posts a guess to the server.
 * @param x horizontal position
 * @param y vertical position
 */
function postGuess(x, y) {
    fetch('/api/post-guess/', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({
            'username': username,
            'pos_x': x + 1,
            'pos_y': y + 1
        })
    })
        .then(response => response.json())
        .then(data => guessResponse(data, x, y));
}

/**
 * Handles the response from the server after a guess has been posted.
 * Returns the outcome of the guess to the user, and updates the grid accordingly.
 * @param data JSON response data
 * @param x horizontal position
 * @param y vertical position
 */
function guessResponse(data, x, y) {
    alert(data['message']);
    if (data['status'] === 200) {
        openCell(x, y);
    }
}

document.onreadystatechange = function() {
    if(document.readyState === "complete") {
        initializeGrid();
    }
}