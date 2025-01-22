<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded-lg shadow-md" style="width: 50%;">
        <h2 class="text-2xl font-bold mb-6 text-center">Publish Book</h2>
        <form action="{{ route('books.add') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="book_name" class="block text-sm font-medium text-gray-700">Book Name</label>
                <input type="text" name="book_name" id="book_name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                {{ $errors->first('book_name') }}
            </div>
            <div class="mb-4">
                <label for="book_isbn" class="block text-sm font-medium text-gray-700">ISBN</label>
                <input type="text" name="book_isbn" id="book_isbn" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                {{ $errors->first('book_isbn') }}
              </div>
            <div class="mb-6">
                <label for="book_desc" class="block text-sm font-medium text-gray-700">Book Description</label>
                <textarea name="book_desc" id="book_desc" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required></textarea>
                {{ $errors->first('book_desc') }}
            </div>
            <div class="mb-4">
              <label for="book_category" class="block text-sm font-medium text-gray-700">Book Category</label>
              <input type="text" name="book_category" id="book_category" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
              {{ $errors->first('book_category') }}
            </div>
          <div class="mb-4">
            <label for="book_cover" class="block text-sm font-medium text-gray-700">Book Cover</label>
            <input type="file" name="book_cover" id="book_cover" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
            {{ $errors->first('book_cover') }}
          </div>
            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600">Publish</button>
        </form>
        {{-- <p class="mt-4 text-center">Don't have an account? <a href="{{ route('register') }}" class="text-blue-500 hover:underline">Register</a></p> --}}
    </div>
</body>
</html>
