<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- AlpineJS CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
    </style>
    <title>Posts</title>
</head>
<body class="bg-gray-100">
<header>
    <!-- Navigation -->
    <nav x-data="{ mobileMenuOpen: false, userMenuOpen: false }" class="bg-white shadow">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 justify-between">
                <div class="flex">
                    <div class="flex flex-shrink-0 items-center">
                        <a href="/">
                            <h2 class="font-bold text-2xl">Barta</h2>
                        </a>
                    </div>
                </div>
                <div class="hidden sm:ml-6 sm:flex gap-2 sm:items-center">
                    <!-- Profile dropdown -->
                    <div class="relative ml-3" x-data="{ open: false }">
                        <div>
                            <button @click="open = !open" type="button" class="flex rounded-full bg-white text-sm focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                <span class="sr-only">Open user menu</span>
                                <img class="h-8 w-8 rounded-full" src="{{ asset('storage/' . session('user')->image) }}" alt="Ahmed Shamim Hasan Shaon"/>
                            </button>
                        </div>
                        <!-- Dropdown menu -->
                        <div x-show="open" @click.away="open = false" class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                            <a href="./profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1" id="user-menu-item-0">Your Profile</a>
                            <a href="./edit-profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1" id="user-menu-item-1">Edit Profile</a>
                            <a href="/logout" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1" id="user-menu-item-2">Sign out</a>
                        </div>
                    </div>
                </div>
                <div class="-mr-2 flex items-center sm:hidden">
                    <!-- Mobile menu button -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-gray-500" aria-controls="mobile-menu" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <!-- Icon when menu is closed -->
                        <svg x-show="!mobileMenuOpen" class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                        </svg>
                        <!-- Icon when menu is open -->
                        <svg x-show="mobileMenuOpen" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>
</header>

<main class="container max-w-xl mx-auto space-y-8 mt-8 px-2 md:px-0 min-h-screen">
    <!-- Search Form -->
    <form action="{{ route('posts.index') }}" method="GET" class="mb-6">
        <div class="relative">
            <input type="text" name="search" value="{{ request('search') }}" class="block w-full p-2 pl-10 rounded-lg border-gray-300 shadow-sm focus:ring-gray-500 focus:border-gray-500" placeholder="Search by nickname, full name, or email">
            <button type="submit" class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2V3m0 9l-2-2m4 4h4m0 0h4m-4 0H3"/>
                </svg>
            </button>
        </div>
    </form>

    <!-- Barta Create Post Card -->
    <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data" class="bg-white border-2 border-black rounded-lg shadow mx-auto max-w-none px-4 py-5 sm:px-6 space-y-3">
        @csrf
        <div>
            <div class="flex items-start">
                <!-- Content -->
                <div class="text-gray-700 font-normal w-full">
                    <textarea class="block w-full p-2 pt-2 text-gray-900 rounded-lg border-none outline-none focus:ring-0 focus:ring-offset-0" name="content" rows="2" placeholder="What's going on, {{ session('user')->firstName ?? 'Guest' }}?"></textarea>
                </div>
            </div>
        </div>
        <!-- Image Upload Input -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Upload Image</label>
            <input type="file" name="image" accept="image/*" class="mt-1 block w-full">
        </div>
        <div>
            <!-- Post Button -->
            <button type="submit" class="-m-2 flex gap-2 text-xs items-center rounded-full px-4 py-2 font-semibold bg-gray-800 hover:bg-black text-white">Post</button>
        </div>
    </form>
    <!-- /Barta Create Post Card -->

    <!-- Newsfeed -->
    <section id="newsfeed" class="space-y-6">
        @if ($posts->isEmpty())
            <p>No posts found.</p>
        @else
            @foreach ($posts as $post)
                <!-- Barta Card -->
                <article class="bg-white border-2 border-black rounded-lg shadow mx-auto max-w-none px-4 py-5 sm:px-6">
                    <header>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <!-- User Info -->
                                <div class="text-gray-900 flex flex-col min-w-0 flex-1">
                                    <a href="#" class="hover:underline font-semibold line-clamp-1">{{ $post->user->firstName }} {{ $post->user->lastName }}</a>
                                    <a href="#" class="hover:underline text-sm text-gray-500 line-clamp-1">@ {{ $post->user->userName }}</a>
                                </div>
                            </div>
                        </div>
                    </header>
                    <!-- Content -->
                    <div class="py-4 text-gray-700 font-normal">
                        <p>{{ $post->content }}</p>
                    </div>
                    <!-- Show the image after the content with a fixed size. -->
                    @if ($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image" class="w-full h-64 object-cover">
                    @endif
                    <!-- Date Created & View Stat -->
                    <div class="flex items-center gap-2 text-gray-500 text-xs my-2">
                        <span>{{ $post->created_at->diffForHumans() }}</span>
                        <span class="">•</span>
                        <span>{{ $post->views }} views</span>
                    </div>
                </article>
                <!-- /Barta Card -->
            @endforeach
        @endif
    </section>
    <!-- /Newsfeed -->
</main>

<footer class="shadow bg-black mt-10">
    <div class="w-full max-w-screen-xl mx-auto p-4 md:py-8">
        <div class="sm:flex sm:items-center sm:justify-between">
            <a href="https://github.com/alnahian2003" class="flex items-center mb-4 sm:mb-0">
                <span class="self-center text-2xl font-semibold whitespace-nowrap text-white">Barta</span>
            </a>
            <ul class="flex flex-wrap items-center mb-6 text-sm font-medium sm:mb-0 text-gray-100">
                <li><a href="#" class="mr-4 hover:underline md:mr-6">About</a></li>
                <li><a href="#" class="mr-4 hover:underline md:mr-6">Privacy Policy</a></li>
                <li><a href="#" class="mr-4 hover:underline md:mr-6">Licensing</a></li>
                <li><a href="#" class="hover:underline">Contact</a></li>
            </ul>
        </div>
        <hr class="my-6 sm:mx-auto border-gray-700 lg:my-8"/>
        <span class="block text-sm sm:text-center text-gray-200">© 2023 <a href="https://github.com/alnahian2003" class="hover:underline">Barta</a>. All Rights Reserved.</span>
    </div>
</footer>
</body>
</html>
