<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Graph</title>
    <style>
        .node {
            fill: #1f77b4;
            stroke: #fff;
            stroke-width: 2px;
        }
        .link {
            stroke: #000000;
            stroke-opacity: 0.6;
        }
        .node-label {
            font-size: 14px;
            text-anchor: middle;
            dominant-baseline: middle;
        }
    </style>
    <script src="https://d3js.org/d3.v7.min.js"></script>

    <!-- Stylesheet -->
    @vite('resources/css/app.css')
</head>
<body>
    @if(!$data)
        <div class="flex flex-col h-screen justify-center">
            <div class='mx-auto items-center justify-center text-3xl font-bold text-center'>
                <div class="mb-3">No data available.</div>
                <button onclick="location.href='{{ route('map') }}';" class="inline-flex items-center justify-center hover:bg-black/70 bg-black rounded-md h-10 px-4 py-2 text-white text-lg font-medium">add data here</button>
            </div>
        </div>
    @else  
    <div class="flex flex-col h-screen justify-center"><div id="graph-container" class='mx-auto items-center justify-center text-3xl font-bold text-center'></div></div>
    @endif
    <script>
        var dataGraph = @json($data)
    </script>
    <script src="{{ asset('js/graph.js') }}"></script>
</body>
</html>