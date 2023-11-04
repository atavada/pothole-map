<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Stylesheet -->
    @vite('resources/css/app.css')
    <title>Page Rank</title>
</head>
<body>
    <div class="px-12 py-4">
        @if(!$data)
        <div class="flex flex-col h-screen justify-center">
            <div class='mx-auto items-center justify-center text-3xl font-bold text-center'>
                <div class="mb-3">No data available.</div>
                <button onclick="location.href='{{ route('map') }}';" class="inline-flex items-center justify-center hover:bg-black/70 bg-black rounded-md h-10 px-4 py-2 text-white text-lg font-medium">add data here</button>
            </div>
        </div>
        @else
            <div id="hyperlink-matrix-container" class="p-4">
                <h2 class="text-lg font-semibold">Hyperlink Matrix</h2>
                <table id="hyperlink-matrix" class="text-center border-4"></table>
            </div>

            <div id="stochastic-matrix-container" class="p-4">
                <h2 class="text-lg font-semibold">Stochastic Matrix</h2>
                <table id="stochastic-matrix" class="text-center border-4"></table>
            </div>
            <div id="google-matrix-container" class="p-4">
                <h2 class="text-lg font-semibold">Google Matrix</h2>
                <table id="google-matrix" class="text-center border-4"></table>
            </div>
            <div id="pagerank-container" class="p-4">
                <h2 class="text-lg font-semibold">Pagerank Iteration</h2>
                <table id="pagerank-iteration" class="text-center border-4"></table>
            </div>
            <div id="sorted-nodes-container" class="ml-4 mt-4"></div>
        @endif
    </div>
    <script>
        const dataGraph = @json($data)
    </script>
    <script src="{{ asset('js/pagerankCalculation.js') }}"></script>
</body>
</html>