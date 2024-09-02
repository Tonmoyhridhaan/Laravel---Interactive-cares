
@extends("layouts.full")

@section('experiences', 'active')
@section('content')
<!-- Main Content -->
<section class="container mx-auto my-20 p-5">
        <h1 class="text-4xl font-bold text-center text-gray-800 mb-10">My Experiences</h1>
        <div class="bg-white p-8 shadow-lg rounded-lg">
            @foreach ( $experiences as $experience)
            
            <div class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-700">{{$experience['title']}} at {{$experience['company']}}</h2>
                <p class="text-gray-500">{{$experience['from']}} - {{$experience['to']}}</p>
                <p class="mt-4 text-gray-600">{{$experience['description']}}</p>
            </div>
            @endforeach
            
        </div>
    </section>
@endsection


