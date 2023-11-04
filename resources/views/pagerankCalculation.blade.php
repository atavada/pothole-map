<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Stylesheet -->
    @vite('resources/css/app.css')
    <title>Document</title>
</head>
<body>
    <div id="hyperlink-matrix-container" class="p-4">
        <h2 class="text-lg font-semibold">Hyperlink Matrix</h2>
        <table id="hyperlink-matrix" class="table-fixed border"></table>
    </div>

    <div id="stochastic-matrix-container" class="p-4">
        <h2 class="text-lg font-semibold">Stochastic Matrix</h2>
        <table id="stochastic-matrix" class="table-fixed border"></table>
    </div>
    <div id="google-matrix-container" class="p-4">
        <h2 class="text-lg font-semibold">Google Matrix</h2>
        <table id="google-matrix" class="table-fixed border"></table>
    </div>
    <div id="pagerank-container" class="p-4">
        <h2 class="text-lg font-semibold">Pagerank Iteration</h2>
        <table id="pagerank-iteration" class="table-fixed border"></table>
    </div>
    <div id="sorted-nodes-container"></div>
    <script>
        const dataGraph = @json($data)
    </script>
    <script src="{{ asset('js/pagerankCalculation.js') }}"></script>
</body>
</html>