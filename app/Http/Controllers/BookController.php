<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Favorite;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{

    private $BASEUPLOAD_PATH = "uploads";

    public function index(Request $request)
    {   
        $this->releaseExpiredBooks();
        list($books, $userFavs) = $this->getBooksAndFavsWithSearch($request);

        return view('main.home', compact('books', 'userFavs'));
    }

    public function showCategories(Request $request)
    {   
        $this->releaseExpiredBooks();
        list($books, $userFavs) = $this->getBooksAndFavsWithSearch($request);

        return view('main.categories', compact('books', 'userFavs'));
    }

    public function showLibrary(Request $request)
    {   
        $this->releaseExpiredBooks();
        list($books, $userFavs) = $this->getBooksAndFavsWithSearch($request, 'usr_lib');

        return view('main.home', compact('books', 'userFavs'));
    }

    public function showFavs(Request $request)
    {   
        $this->releaseExpiredBooks();
        list($books, $userFavs) = $this->getBooksAndFavsWithSearch($request, 'usr_favs');

        return view('main.home', compact('books', 'userFavs'));
    }

    public function showPublished(Request $request)
    {   
        $this->releaseExpiredBooks();
        list($books, $userFavs) = $this->getBooksAndFavsWithSearch($request, 'usr_publish');

        return view('main.home', compact('books', 'userFavs'));
    }


    public function show($id)
    {
        // Retrieve the book along with its publisher
        $book = Book::with('publisher')->findOrFail($id);

        // Determine the availability status
        $lended = is_null($book->book_leaser) ? 'Available' : 'Lended';

        return view('books.detail', compact('book', 'lended'));
    }

    public function create(Request $request) {
        $userId = Auth::id();

        $request->validate([
            'book_name' => 'required|unique:books,book_name',
            'book_isbn' => 'required',
            'book_desc' => 'required|min:8',
            'book_category' => 'required',
            'book_cover' => 'required',
        ]);

        $bookCoverFname = $request->book_cover->hashName();  
        
        $request->book_cover->move(public_path($this->BASEUPLOAD_PATH), $bookCoverFname);

        Book::create([
            'book_name'     => $request->book_name,
            'book_isbn'     => $request->book_isbn,
            'book_desc'     => $request->book_desc,
            'book_category'     => $request->book_category,
            'book_cover'   => $this->BASEUPLOAD_PATH.'/'.$bookCoverFname,
            'book_publisher'   => $userId,
        ]);

        return redirect('/');
    }

    public function borrow(Request $request, $id)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'book_borrow_duration' => 'required|date|after:now',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        }

        // Retrieve the validated data
        $data = $validator->validated();

        // Find the book by ID
        $book = Book::findOrFail($id);

        // Update the book's leaser and lease end date
        $book->update([
            'book_leaser' => Auth::id(),
            'book_lease_end_date' => $data['book_borrow_duration'],
        ]);

        return redirect()->route('home')->with('success', 'Book borrowed successfully.');
    }


    public function toggleFavorite($bookId)
    {
        // Ensure the user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $userId = Auth::id();

        // Check if the book is already favorited
        $favorite = Favorite::where('usr_id', $userId)->where('book_id', $bookId)->first();

        if ($favorite) {
            // If it's already favorited, remove it
            $favorite->delete();
        } else {
            // Otherwise, add it to favorites
            Favorite::create([
                'usr_id' => $userId,
                'book_id' => $bookId,
            ]);
        }

        return redirect()->back();
    }

    public function showBorrow($id){

        // Find the book by ID
        $book = Book::findOrFail($id);

        // Check if the book is already borrowed
        if (!is_null($book->book_leaser)) {
            return redirect()->back()
                            ->withErrors(['book_borrow_id' => 'The book is already borrowed.'])
                            ->withInput();
        }

        return view('books.borrow', compact('id'));
    }

    private function releaseExpiredBooks()
    {
        $userId = Auth::id();
        $currentDate = Carbon::now();

        // Retrieve books leased by the current user with lease end dates in the past
        $expiredBooks = Book::whereNotNull('book_leaser')
                            ->where('book_lease_end_date', '<', $currentDate)
                            ->get();
        
        // Update the necessary fields for each expired book
        foreach ($expiredBooks as $book) {
            $book->update([
                'book_leaser' => null,
                'book_lease_end_date' => null,
            ]);
        }
    }

    public function getBooksAndFavsWithSearch($request, $filter = ''){
        // Search query
        $search = $request->input('q');

        // Get the authenticated user's ID
        $userId = Auth::id();

        if ($filter == 'usr_lib') {
            // Fetch books based on the search query
            $books = Book::when($search, function ($query, $search) {
                return $query->where('book_name', 'like', '%' . $search . '%');
            })->where('book_leaser', $userId)->get();

        } else if ($filter == 'usr_favs') {
            // Fetch books based on the search query
            $books = Favorite::with('book') // Eager load the related 'book'
            ->where('usr_id', $userId) // Filter by the authenticated user
            ->when($search, function ($query, $search) {
                $query->whereHas('book', function ($query) use ($search) {
                    $query->where('book_name', 'like', '%' . $search . '%'); // Add search filter on book name
                });
            })
            ->distinct() // Ensure distinct results
            ->get()
            ->pluck('book');
            error_log($books);

        } else if ($filter == 'usr_publish') {
            $books = Book::when($search, function ($query, $search) {
                return $query->where('book_name', 'like', '%' . $search . '%');
            })->where('book_publisher', $userId)->get();
        } else {
            // Fetch books based on the search query
            $books = Book::when($search, function ($query, $search) {
                return $query->where('book_name', 'like', '%' . $search . '%');
            })->get();
        }

        // Fetch user's favorite books
        $userFavs = Favorite::where('usr_id', $userId)->pluck('book_id')->toArray();

        return [$books, $userFavs];
    }
}
