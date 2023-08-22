<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Models\book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BookController extends Controller
{
    public function addBook(BookRequest $request)
    {
        $imagePath = $this->saveImageFromFile($request->file('image'));

        try {
            // Create the book
            $book = Book::create([
                'book_encrypted_id' => Str::uuid()->toString(),
                'image' => $imagePath,
                'title' => $request->input('title'),
                'author' => $request->input('author'),
                'price' => $request->input('price'),
                'category' => $request->input('category'), // Save category name
                'description' => $request->input('description'),
            ]);

            // Get or create the categories and associate them with the book
            Category::create([
                'name' => $request->input('category'),
                'book_id' => $book->id,
            ]);

            if ($book) {
                return response()->json(['message' => 'Book added successfully', 'book' => $book], 201);
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

    public function searchBook($category)              //search the book
    {
        $book = book::where('category', 'like', "%$category%")->get();     //get the book data where category is found

        if ($book->isEmpty()) {
            return response()->json(['message' => 'No book found for the given username'], 404);
        }

        return response()->json(['book' => $book]);
    }

    public function updateBook(Request $request, $id)                     //update the book data
    {
        $book = book::where('id', $id)->first();                          //get data of specfic id
        $imagePath = $this->saveImageFromFile($request->file('image'));

        if (! $book) {
            return response()->json(['error' => 'book not found'], 404);
        }

        $updateData = [
            'image' => $imagePath,
            'title' => $request->input('title'),
            'author' => $request->input('author'),
            'price' => $request->input('price'),
            'category' => $request->input('category'),
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

    private function saveImageFromFile($imageFile)
    {

        if (! empty($imageFile)) {
            $imageData = file_get_contents($imageFile->path());          //get all data of file
            $filename = uniqid().'.png';                        //generate random id
            $userDirectory = 'images/';
            Storage::put($userDirectory.'/'.$filename, $imageData);       //save the image in store

            return $userDirectory.'/'.$filename;

        }

        return null;
    }

    public function updateOrCreateImage(Request $request)
    {
        $bookId = $request->input('book_id');
        $imagePath = $this->saveImageFromFile($request->file('image'));  // Call the saveImageFromUrl function

        try {
            $book = Book::where('id', $bookId)->first();

            if (! $book) {
                return response()->json(['message' => 'Book not found'], 404);
            }

            if ($imagePath) {
                // Delete previous image if it exists
                if ($book->image) {
                    Storage::delete($book->image);
                }

                // Update the image path
                $book->image = $imagePath;
                $book->save();
            }

            return response()->json(['message' => 'Image updated successfully', 'book' => $book], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
