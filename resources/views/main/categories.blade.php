<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet"
  href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
  </head>
<body>
  <aside class="sidebar fixed top-0 left-0 h-full w-20 flex flex-col overflow-x-hidden bg-gray-900 p-6 transition-all ease-in-out duration-400 hover:w-64">
    <div class="sidebar-header flex items-center">
      <img src="{{ asset('/images/BookieLogo.png') }}" alt="logo" class="w-10 rounded-full" />
      <h2 class="text-white text-lg font-semibold ml-6 whitespace-nowrap">Bookie</h2>
    </div>
    <ul class="sidebar-links mt-5 h-full overflow-y-auto scrollbar-hidden" style="overflow: hidden;">
      <h4 class="text-white font-medium whitespace-nowrap mt-4 relative">
        <span class="opacity-0 transition-opacity duration-200">Main Menu</span>
        <div class="menu-separator absolute left-0 top-1/2 w-full h-px bg-indigo-600 transform translate-y-[-50%] scale-x-100 transition-all duration-200"></div>
      </h4>
      <li>
        <a href="{{ route('home') }}" class="flex items-center gap-6 text-white font-medium py-4 px-2 text-sm hover:text-gray-900 hover:bg-white rounded transition duration-200">
          <span class="material-symbols-outlined">home</span> Discover
        </a>
      </li>
      <li>
        <a href="{{ route('categories') }}" class="flex items-center gap-6 text-white font-medium py-4 px-2 text-sm hover:text-gray-900 hover:bg-white rounded transition duration-200">
          <span class="material-symbols-outlined">lists</span> Category
        </a>
      </li>
      <li>
        <a href="{{ route('library') }}" class="flex items-center gap-6 text-white font-medium py-4 px-2 text-sm hover:text-gray-900 hover:bg-white rounded transition duration-200">
          <span class="material-symbols-outlined">book</span> My Library
        </a>
      </li>
      <li>
        <a href="{{ route('favorites') }}" class="flex items-center gap-6 text-white font-medium py-4 px-2 text-sm hover:text-gray-900 hover:bg-white rounded transition duration-200">
          <span class="material-symbols-outlined">favorite</span> Favorites
        </a>
      </li>
      @if (Auth::user()->role == "publisher")
      <li>
        <a href="{{ route('books.add') }}" class="flex items-center gap-6 text-white font-medium py-4 px-2 text-sm hover:text-gray-900 hover:bg-white rounded transition duration-200">
          <span class="material-symbols-outlined">upload</span> Publish a Book
        </a>
      </li>
      @endif
      <h4 class="text-white font-medium whitespace-nowrap mt-4 relative">
        <span class="opacity-0 transition-opacity duration-200">Account</span>
        <div class="menu-separator absolute left-0 top-1/2 w-full h-px bg-indigo-600 transform translate-y-[-50%] scale-x-100 transition-all duration-200"></div>
      </h4>
      <li>
        <a href="#" class="flex items-center gap-6 text-white font-medium py-4 px-2 text-sm hover:text-gray-900 hover:bg-white rounded transition duration-200">
          <span class="material-symbols-outlined">account_circle</span> Profile
        </a>
      </li>
      <li>
        <a href="#" class="flex items-center gap-6 text-white font-medium py-4 px-2 text-sm hover:text-gray-900 hover:bg-white rounded transition duration-200">
          <span class="material-symbols-outlined">settings</span> Settings
        </a>
      </li>
      <li>
        <a href="/logout" class="flex items-center gap-6 text-white font-medium py-4 px-2 text-sm hover:text-gray-900 hover:bg-white rounded transition duration-200">
          <span class="material-symbols-outlined">logout</span> Logout
        </a>
      </li>
    </ul>
    <div class="user-account mt-auto py-3 px-2 ml-[-2.5px]">
      <div class="user-profile flex items-center text-gray-900">
        <img src="{{ asset('/images/profile-img-resized.png') }}" alt="Profile Image" class="w-10 h-10 rounded-full border-2 border-white" />
        <div class="user-detail ml-6">
          <h3 class="font-semibold text-base text-white truncate">{{ Auth::user()->name }}</h3>
          <span class="font-semibold text-sm text-gray-500 truncate">{{ Auth::user()->email }}</span>
        </div>
      </div>
    </div>
  </aside>
  
  <div class="main-content">
    <div class="header w-full p-6 bg-gray-200 flex justify-between items-center">
      <input 
        type="text" 
        id="query" 
        placeholder="Search your favorite books" 
        class="ml-24 w-1/5 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
      />
      <div class="user-profile flex items-center">
        <div class="w-10 h-10 rounded-full overflow-hidden">
          <img src="{{ asset('/images/profile-img-resized.png') }}" alt="Profile Image" class="w-full h-full object-cover" />
        </div>
        <div class="user-detail ml-4 text-gray-800">
          <h3 class="text-base font-semibold">{{ Auth::user()->name }}</h3>
          <p class="text-sm text-gray-500">
            {{ Auth::user()->email }}
          </p>
        </div>
      </div>
    </div>
    <div class="content">
      <div class="card">
        <div class="card-head">
          <h3>Recomended</h3>
          <a href="">See all</a>
        </div>          
          <div class="card-lol">
            @php
              $current_cat = "";
            @endphp
            @foreach ($books as $book)
              @if ($book->book_category != $current_cat)
                  </div> 
                  <b><h3 class='text-xl'>{{ $book->book_category }}</h3></b>
                  <div class="card-content">
              @endif
              <div class="card">
                  <img src="{{ asset($book->book_cover) }}" alt="">
                  <div class="card-head">
                      <a href="{{ url('books', ['book' => $book->id]) }}">
                          <b>{{ $book->book_name }}</b>
                      </a>
                      <p>{{ $book->book_isbn }}</p>
                  </div>
                  <div class="card-head">
                      <p class="{{ $book->book_leaser ? 'Lended' : 'Available' }}">
                          {{ $book->book_leaser ? 'Lended' : 'Available' }}
                      </p>
                      <a href="{{ route('books.favorite', $book->id) }}">
                          <button class="like-btn">
                              <span class="material-symbols-outlined {{ in_array($book->id, $userFavs) ? 'filled' : '' }}">
                                  favorite
                              </span>
                          </button>
                      </a>
                  </div>
              </div>
            @endforeach
      </div>
    </div>
  </div>
  

</body>