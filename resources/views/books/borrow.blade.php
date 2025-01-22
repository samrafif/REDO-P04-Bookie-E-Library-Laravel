<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded-lg shadow-md" style="width: 50%;">
        <h2 class="text-2xl font-bold mb-6 text-center">Borrow a Book</h2>
        <form action="{{ route('books.borrow', $id) }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="book_borrow_duration" class="block text-sm font-medium text-gray-700">Borrow Duration</label>
                <input type="date" name="book_borrow_duration" id="book_borrow_duration" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                {{ $errors->first('book_borrow_duration') }}
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600">Borrow</button>
        </form>
    </div>
</body>
</html>
