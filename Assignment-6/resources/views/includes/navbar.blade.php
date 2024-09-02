<nav class="bg-gray-900 p-5 shadow-lg sticky top-0 z-50">
    <div class="container mx-auto flex justify-between items-center">
        
        <a href="{{URL::to('/')}}" class="text-white text-2xl font-bold flex items-center">
            <img src="{{ asset('image/Tonmoy Barua.png') }}" alt="Logo" class="h-8 w-8 mr-2">
            My Portfolio
        </a>
        <ul class="flex space-x-6">
            <li><a href="{{URL::to('/')}}" class="@yield('home', '') nav-link text-gray-300 hover:text-white transition duration-300">Home</a></li>
            <li><a href="{{URL::to('experiences')}}" class="@yield('experiences', '') nav-link text-gray-300 hover:text-white transition duration-300">Experiences</a></li>
            <li><a href="{{URL::to('projects')}}" class="@yield('projects', '') nav-link text-gray-300 hover:text-white transition duration-300">Projects</a></li>
        </ul>
        <div class="hidden md:flex space-x-4">
            <a href="https://github.com/Tonmoyhridhaan" target="_blank" class="text-gray-300 hover:text-white transition duration-300">
                <i class="fab fa-github text-xl"></i>
            </a>
            <a href="https://www.linkedin.com/in/Tonmoy-Barua-/" target="_blank" class="text-gray-300 hover:text-white transition duration-300">
                <i class="fab fa-linkedin text-xl"></i>
            </a>
            <a href="mailto:tonmoy.cse.ctg@gmail.com" class="text-gray-300 hover:text-white transition duration-300">
                <i class="fas fa-envelope text-xl"></i>
            </a>
        </div>
    </div>
</nav>