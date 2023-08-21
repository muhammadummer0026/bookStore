<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Models\book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BookController extends Controller
{
    public function addBook(BookRequest $request)                          //add the book
    {
        $imagePath = $this->saveImageFromUrl($request->file('image'));  //call the saveImageFromUrl function 

        try {

            $book = book::create([                                   
                'book_encrypted_id' => Str::uuid()->toString(),
                'image' => $imagePath,
                'title' => $request->input('title'),
                'author' => $request->input('author'),
                'price' => $request->input('price'),
                'categories' => $request->input('categories'),
                'description' => $request->input('description'),

            ]);

            if ($book) {
                return response()->json(['message' => 'book added sucessfully', 'book' => $book], 201);
            } else {
                return response()->json(['error' => 'Failed to add book'], 401);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getAllBook()
    {
        $book = book::all();                               // show all books

        return response()->json(['book' => $book]);
    }

    public function indiviualBook($id)
    {
        $book = book::where('id', $id)->get();             //get book data of specfic id

        if ($book->isEmpty()) {
            return response()->json(['error' => 'book not found'], 404);
        } else {
            return response()->json(['book' => $book]);
        }
    }

    public function searchBook($categories)              //search the book
    {
        $book = book::where('categories', 'like', "%$categories%")->get();     //get the book data where category is found

        if ($book->isEmpty()) {
            return response()->json(['message' => 'No book found for the given username'], 404);
        }

        return response()->json(['book' => $book]);
    }

    public function updateBook(Request $request, $id)                     //update the book data
    {
        $book = book::where('id', $id)->first();                          //get data of specfic id
        $imagePath = $this->saveImageFromUrl($request->file('image'));

        if (! $book) {
            return response()->json(['error' => 'book not found'], 404);
        }

        $updateData = [
            'image' => $imagePath,
            'title' => $request->input('title'),
            'author' => $request->input('author'),
            'price' => $request->input('price'),
            'categories' => $request->input('categories'),
            'description' => $request->input('description'),

        ];

        try {
            $book->update($updateData);

            return response()->json(['message' => 'book updated successfully', 'book' => $book], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    public function destroyBook($id)                 //delete the book
    {
        $book = book::where('id', $id)->first();     //get  data of specfic id
        if (! $book) {
            return response()->json(['error' => 'book not found'], 404);
        }

        $book->delete();

        return response()->json(['message' => 'book deleted successfully']);
    }

    private function saveImageFromUrl($imageUrl)
    {
        if (! empty($imageUrl)) {
            $imageData = file_get_contents($imageUrl);          //get all data of file 
            $filename = uniqid().'.png';                        //generate random id
            $userDirectory = 'images/';
            Storage::put($userDirectory.'/'.$filename, $imageData);       //save the image in store

            return $userDirectory.'/'.$filename;

        }

        return null;

    }
}
