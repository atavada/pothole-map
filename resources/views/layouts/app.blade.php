<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pothole Map</title>

    <!-- Stylesheet -->
    @vite('resources/css/app.css')

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
</head>
<body>
    <div class="fixed inset-x-0 top-0 z-10 flex justify-between bg-white p-4 transition lg:px-12 shadow">
        <a href="/waypoints" class="inline-flex">
            <img src="/img/logo.png" alt="logo" width=50 height=50 class="w-14 object-contain" >
        </a>
        <div class="hidden items-center gap-4 md:inline-flex">
            <a href="/" class="rounded-lg px-3 py-2 text-sm font-semibold hover:bg-zinc-100">Beranda</a>
            <a href="/map" class="rounded-lg px-3 py-2 text-sm font-semibold hover:bg-zinc-100">Map</a>
            <a href="/graph" class="rounded-lg px-3 py-2 text-sm font-semibold hover:bg-zinc-100">Graph</a>
            <a href="/pagerank" class="rounded-lg px-3 py-2 text-sm font-semibold hover:bg-zinc-100">Page Rank</a>
            <a href="/map" class="rounded-lg px-3 py-2 text-sm font-semibold text-white bg-black hover:bg-black/80">Try Now</a>
        </div>
        <div class='flex md:hidden justify-center items-center'>
            <Image
            src="/img/burger.png"
            alt="menu"
            width=100
            height=100
            class=" w-8 h-8"
            />
        </div>
    </div>

    <div>
        @yield('content')
    </div>

    <footer class="mt-20 bg-white fixed bottom-0 right-0 left-0 shadow px-4">
        <div class="w-full p-4 md:flex md:items-center md:justify-between md:p-6">
            <span class="text-sm text-gray-500 dark:text-gray-400 sm:text-center">© 2023 <a href="https://github.com/atavada/pothole-map" class="hover:underline">Pothole</a>. All Rights Reserved.
            </span>
            <ul class="mt-3 flex flex-wrap items-center text-sm text-gray-500 dark:text-gray-400 sm:mt-0">
            <li>
                <Link href="/privacyandpolicy" class="mr-4 hover:underline md:mr-6">Privacy Policy</Link>
            </li>
            </ul>
        </div>
    </footer>
</body>
</html>
