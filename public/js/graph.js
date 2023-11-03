const graph = dataGraph;

// Set up the SVG container
var width = 800;
var height = 600;
var svg = d3
    .select("#graph-container")
    .append("svg")
    .attr("width", width)
    .attr("height", height);

// Create an array of nodes
var nodes = Object.keys(graph).map(function (node) {
    return { id: node };
});

// Create an array of links (edges)
var links = [];
Object.keys(graph).forEach(function (sourceNode) {
    graph[sourceNode].forEach(function (targetNode) {
        links.push({ source: sourceNode, target: targetNode });
    });
});

// Create a force simulation
var simulation = d3
    .forceSimulation(nodes)
    .force(
        "link",
        d3
            .forceLink(links)
            .id((d) => d.id)
            .distance(200)
    )
    .force("charge", d3.forceManyBody())
    .force("center", d3.forceCenter(width / 2, height / 2));

// Define the arrowhead marker
svg.append("defs")
    .append("marker")
    .attr("id", "arrowhead")
    .attr("viewBox", "0 -5 10 10")
    .attr("refX", 10)
    .attr("refY", 0)
    .attr("markerWidth", 6)
    .attr("markerHeight", 6)
    .attr("orient", "auto")
    .append("path")
    .attr("d", "M0,-5L10,0L0,5")
    .attr("fill", "#f02");

// Create links with arrowheads
var link = svg
    .selectAll(".link")
    .data(links)
    .enter()
    .append("line")
    .attr("class", "link")
    .attr("stroke", "#999")
    .attr("stroke-opacity", 0.6)
    .attr("marker-end", "url(#arrowhead)"); // Attach arrowhead marker

// Create nodes
var node = svg
    .selectAll(".node")
    .data(nodes)
    .enter()
    .append("circle")
    .attr("class", "node")
    .attr("r", 30);

// Create node labels
var nodeLabel = svg
    .selectAll(".node-label")
    .data(nodes)
    .enter()
    .append("text")
    .attr("class", "node-label")
    .text((d) => d.id);
// Define tick functions
simulation.on("tick", () => {
    link.attr("x1", (d) => d.source.x)
        .attr("y1", (d) => d.source.y)
        .attr("x2", (d) => d.target.x)
        .attr("y2", (d) => d.target.y);

    node.attr("cx", (d) => d.x).attr("cy", (d) => d.y);
    nodeLabel.attr("x", (d) => d.x).attr("y", (d) => d.y);
});

console.log(graph);
console.log(node);
console.log(link);
