<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        .node {
            fill: #1f77b4;
            stroke: #fff;
            stroke-width: 2px;
        }
        .link {
            stroke: #999;
            stroke-opacity: 0.6;
        }
        .node-label {
            font-size: 14px;
            text-anchor: middle;
            dominant-baseline: middle;
        }
    </style>
    <script src="https://d3js.org/d3.v7.min.js"></script>
</head>
<body>
    <div id="graph-container">
    </div>
    <script>
        var dataGraph = @json($data)
    </script>
    <script src="{{ asset('js/graph.js') }}"></script>
</body>
</html>