
@extends("layouts.full")
@section('projects', 'active')
@section('content')
<section class="container mx-auto my-20 p-5">
        <h1 class="text-4xl font-bold text-center text-gray-800 mb-10">{{$project['title']}}</h1>
        <h1 class="text-2xl font-bold text-center text-gray-800 mb-10">{{$project['type']}}</h1>
        <div class="bg-white p-8 shadow-lg rounded-lg">
            <p class="text-gray-600 leading-relaxed">{{$project['description']}}</p>
            <p class="text-gray-600 mt-4">Key features include:</p>
            <ul class="list-disc list-inside mt-4 text-gray-600">
                @foreach ($project['features'] as $feature)
                <li>{{$feature}}</li>
                @endforeach
            </ul>
        </div>
    </section>
    @endsection