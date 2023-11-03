const graph = dataGraph;
const dampingFactor = 0.85;
const hyperlinkMatrix = createHyperlinkMatrix(graph);
const stochasticMatrix = createStochasticMatrix(graph);
const googleMatrix = createGoogleMatrix(stochasticMatrix, dampingFactor);
const convergenceThreshold = 0.0000001; // Tolerance for convergence
const pageRank = pagerank(googleMatrix, convergenceThreshold);
const nodes = Object.keys(graph);
const sortedNodesAndPageRank = getSortedNodesAndPageRank(pageRank, nodes);
function formatValue(value) {
    // Round the value to 2 decimal places and convert it to a string
    return value.toFixed(2);
}
function createHyperlinkMatrix(graph) {
    const nodeNames = Object.keys(graph);
    const N = nodeNames.length;

    // Initialize an N x N matrix with all zeros
    const matrix = new Array(N).fill(0).map(() => new Array(N).fill(0));

    for (let i = 0; i < N; i++) {
        const fromNode = nodeNames[i];
        for (let j = 0; j < N; j++) {
            const toNode = nodeNames[j];
            if (graph[fromNode].includes(toNode)) {
                matrix[i][j] = 1;
            }
        }
    }

    return matrix;
}

function createStochasticMatrix(graph) {
    const nodeNames = Object.keys(graph);
    const N = nodeNames.length;

    // Initialize an N x N matrix with all zeros
    const matrix = new Array(N).fill(0).map(() => new Array(N).fill(0));

    // Fill in the transition probabilities
    for (let i = 0; i < N; i++) {
        const fromNode = nodeNames[i];
        const outDegree = graph[fromNode].length;

        if (outDegree === 0) {
            // Handle nodes with no outgoing edges
            for (let j = 0; j < N; j++) {
                matrix[i][j] = 1 / N;
            }
        } else {
            for (let j = 0; j < N; j++) {
                const toNode = nodeNames[j];
                if (graph[fromNode].includes(toNode)) {
                    matrix[i][j] = 1 / outDegree;
                }
            }
        }
    }

    return matrix;
}
function createGoogleMatrix(stochasticMatrix, dampingFactor) {
    const N = stochasticMatrix.length;
    const googleMatrix = new Array(N).fill(0).map(() => new Array(N).fill(0));

    for (let i = 0; i < N; i++) {
        for (let j = 0; j < N; j++) {
            const value =
                dampingFactor * stochasticMatrix[i][j] +
                (1 - dampingFactor) / N;
            // Format the value for display
            googleMatrix[i][j] = value;
        }
    }

    return googleMatrix;
}
// Example graph

function pagerank(googleMatrix, convergenceThreshold = 0.0001) {
    const numPages = googleMatrix.length;

    // Initialize the PageRank values for each page to 1/n.
    const initialPagerank = Array(numPages).fill(1 / numPages);

    let iteration = 0;
    let prevPagerank;

    const pagerankIterations = []; // Store PageRank values at each iteration
    pagerankIterations.push([...initialPagerank]); // Store initial PageRank values
    while (true) {
        const newPagerank = Array(numPages).fill(0);

        for (let i = 0; i < numPages; i++) {
            for (let j = 0; j < numPages; j++) {
                // Calculate the contribution from each linking page.
                newPagerank[i] += googleMatrix[j][i] * initialPagerank[j];
            }
        }

        pagerankIterations.push([...newPagerank]); // Store current PageRank values

        // Calculate the convergence by comparing with the previous PageRank values
        if (iteration > 0) {
            let converged = true;
            for (let i = 0; i < numPages; i++) {
                if (
                    Math.abs(newPagerank[i] - prevPagerank[i]) >
                    convergenceThreshold
                ) {
                    converged = false;
                    break;
                }
            }
            if (converged) {
                break;
            }
        }

        prevPagerank = [...newPagerank];
        initialPagerank.splice(0, numPages, ...newPagerank);

        iteration++;
    }

    return pagerankIterations;
}

function getSortedNodesAndPageRank(pagerankIterations, nodeNames) {
    // Get the last iteration (the final PageRank values)
    const lastIteration = pagerankIterations[pagerankIterations.length - 1];

    // Create an array of objects to associate nodes with PageRank values
    const nodePageRankPairs = nodeNames.map((nodeName, index) => ({
        node: nodeName,
        pagerank: lastIteration[index],
    }));

    // Sort the array based on PageRank values (largest to smallest)
    nodePageRankPairs.sort((a, b) => b.pagerank - a.pagerank);

    return nodePageRankPairs;
}

function createMatrixTable(
    matrix,
    nodeNames,
    containerId,
    tableId,
    tableClass
) {
    const container = document.getElementById(containerId);
    const table = document.getElementById(tableId);

    for (let i = 0; i <= matrix.length; i++) {
        const row = document.createElement("tr");
        for (let j = 0; j <= matrix[0].length; j++) {
            const cell = document.createElement(
                i === 0 || j === 0 ? "th" : "td"
            );
            cell.textContent =
                i === 0
                    ? j === 0
                        ? ""
                        : nodeNames[j - 1]
                    : j === 0
                    ? nodeNames[i - 1]
                    : matrix !== googleMatrix
                    ? matrix[i - 1][j - 1]
                    : matrix[i - 1][j - 1].toFixed(3);
            // Apply Tailwind CSS classes to the cells
            cell.classList.add("border", "p-2"); // You can adjust the classes as needed
            row.appendChild(cell);
        }
        table.appendChild(row);
    }

    // Add table class if provided
    if (tableClass) {
        table.classList.add(tableClass);
    }

    container.appendChild(table);
}

function createPagerankTable(
    pagerank,
    nodeNames,
    containerId,
    tableId,
    tableClass
) {
    const container = document.getElementById(containerId);
    const table = document.getElementById(tableId);

    for (let i = 0; i <= pagerank.length; i++) {
        const row = document.createElement("tr");
        for (let j = 0; j <= pagerank[0].length; j++) {
            const cell = document.createElement(
                i === 0 || j === 0 ? "th" : "td"
            );
            cell.textContent =
                i === 0
                    ? j === 0
                        ? "Iteration"
                        : nodeNames[j - 1]
                    : j === 0
                    ? `Iteration ${i - 1}`
                    : pagerank[i - 1][j - 1].toFixed(6);
            // Apply Tailwind CSS classes to the cells
            cell.classList.add("border", "p-2"); // You can adjust the classes as needed
            row.appendChild(cell);
        }
        table.appendChild(row);
    }

    // Add table class if provided
    if (tableClass) {
        table.classList.add(tableClass);
    }

    container.appendChild(table);
}

function displayListSortedNodesAndPageRank(
    sortedNodesAndPageRank,
    containerId
) {
    const container = document.getElementById(containerId);
    const ul = document.createElement("ul");

    sortedNodesAndPageRank.forEach((item, i) => {
        const li = document.createElement("li");
        const ordinal = i + 1;
        li.textContent = `Rank ke-${ordinal} adalah titik ${
            item.node
        } dengan nilai Pagerank: ${item.pagerank.toFixed(6)}`;
        li.classList.add("mb-2", "text-lg", "font-semibold"); // Add Tailwind CSS classes
        ul.appendChild(li);
    });

    container.appendChild(ul);
}

displayListSortedNodesAndPageRank(
    sortedNodesAndPageRank,
    "sorted-nodes-container"
);
// Create tables with Tailwind CSS classes
createMatrixTable(
    hyperlinkMatrix,
    nodes,
    "hyperlink-matrix-container",
    "hyperlink-matrix",
    "table-fixed"
);
createMatrixTable(
    stochasticMatrix,
    nodes,
    "stochastic-matrix-container",
    "stochastic-matrix",
    "table-fixed"
);
createMatrixTable(
    googleMatrix,
    nodes,
    "google-matrix-container",
    "google-matrix",
    "table-fixed"
);
createPagerankTable(
    pageRank,
    nodes,
    "pagerank-container",
    "pagerank-iteration",
    "table-fixed"
);

// Print the transition matrix
console.log(graph);
console.log(hyperlinkMatrix);
console.log(stochasticMatrix);
console.log(googleMatrix);
console.log(nodes);
for (let iteration = 0; iteration <= pageRank.length; iteration++) {
    console.log(`Iteration ${iteration}:`, pageRank[iteration]);
}
console.log("Nodes and PageRank Values (Sorted):", sortedNodesAndPageRank);
