<?php

namespace App\Http\Controllers;

use App\Book;
use App\Author;
use App\BookAuthor;
use App\Http\Requests\PostBookRequest;
use App\Http\Resources\BookResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class BooksController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth:api');
    }

    public function index(Request $request)
    {
        // @TODO implement
        
        $input = $request->all();
        $book = Book::query();

        if (!empty($input['title']))
            $book->where('title','like','%'.$input['title'].'%');

        return BookResource::collection($book->paginate() );
    }

    public function store(PostBookRequest $request)
    {
        // dd($request->all());
        // @TODO implement
        DB::beginTransaction();
        try {
            // $book = new Book();

            // $book->isbn = $request->isbn;
            // $book->title = $request->title;
            // $book->description = $request->description;
            // $book->published_year = $request->published_year;
            // $book->save();


            // $author = new Author();
            // $author->name = $request->author_name;
            // $author->surname = $request->surname;
            // $author->save();

            
            // $book_author = new BookAuthor();
            // $book_author->book_id = $book->id;
            // $book_author->author_id = $author->id;
        
            // $book_author->save();

            $input = $request->all();

            $book = new Book();
            $book->title = $input['title'];
            $book->isbn = $input['isbn'];
            $book->description = $input['description'];
            $book->published_year = $input['published_year'];
            $book->save();

            $book->authors()->attach($input['authors']);

            DB::commit();

            return new BookResource($book);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['metaData' => ['code' => 500, 'message' => $e->getMessage()]], 500);
        }
    }
}
