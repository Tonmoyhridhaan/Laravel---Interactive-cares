
@extends("layouts.full")

@section('home', 'active')
@section('content')
<!-- Main Content -->
<section class="bg-gradient-to-r from-blue-500 to-purple-600 text-white py-20">
        <div class="container mx-auto text-center">
            <h1 class="text-5xl font-extrabold">Hi, I'm {{$home['name']}}</h1>
            <p class="mt-4 text-xl">{{$home['info1']}}</p>
            <p class="mt-2 text-lg">{{$home['info2']}}</p>
            <a href="{{URL::to('projects')}}">
                <button class="mt-8 px-6 py-3 bg-white text-gray-900 rounded-full font-semibold shadow-md hover:bg-gray-200 transition duration-300">
                    Explore My Work
                </button>
            </a>
        </div>
    </section>
@endsection


