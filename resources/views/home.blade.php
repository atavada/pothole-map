@extends('layouts.app')

@section('content')
    <div class="mt-52 flex flex-col items-center justify-center w-full">
        <Image
        src="/img/home.png"
        alt="home"
        width=100
        height=100
        class="w-32 object-contain mb-8"
        />
        
        <a href="/waypoints" class="mb-3 elative h-14 inline-flex items-center justify-center hover:bg-black/80 bg-black rounded-md px-4 py-2 text-white text-sm font-medium">
            Try Now
        </a>

        <span class='opacity-75'>Powered by: <span class='font-bold'>OpenStreetMap</span></span>
        <div class='mt-6 flex w-5/6 flex-row items-center justify-center gap-10 sm:w-2/6'>
            <Image src="/img/laravel.png" alt="logo-1" width=100 height=100 quality=100 class="w-16 object-contain grayscale" />
            <Image src="/img/tailwind.png" alt="logo-1" width=100 height=100 quality=100 class="w-16 object-contain grayscale" />
        </div>
    </div>
@endsection