
@extends("layouts.full")

@section('projects', 'active')
@section('content')
<!-- Main Content -->
<section class="container mx-auto my-20 p-5">
    <h1 class="text-4xl font-bold text-center text-gray-800 mb-10">My Projects</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

        @foreach ($projects as $project)
            
    
            <a href="{{ URL::to('/project-single/' . $project['id']) }}" class="bg-white p-8 shadow-lg rounded-lg hover:shadow-2xl transition duration-300">
                <h2 class="text-2xl font-semibold text-gray-700">{{$project['title']}}</h2>
                <p class="text-gray-500">{{$project['type']}}</p>
                <p class="mt-4 text-gray-600">{{$project['description']}}</p>
            </a>
        @endforeach
        
    </div>
</section>

@endsection


