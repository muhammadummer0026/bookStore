<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlaceOrderRequest;
use App\Models\order;
use Illuminate\Http\Request;
use Mail;


class OrderController extends Controller
{
    public function addOrder(PlaceOrderRequest $request)           //add order
    {
        try {
            $order = Order::create([
                'user_id' => $request->user_id,
                'books' => json_encode($request->input('books')),
                'quantity' => (int) $request->input('quantity'),
                'email' => $request->input('email'),
                'name' => $request->input('name'),
                'phone_number' => $request->input('phone_number'),
                'billing_address' => $request->input('billing_address'),
                'status' => 'pending',
                'grand_total' => (float) $request->input('grand_total'),
            ]);

            $message = 'Hello Dear User, Your Order has been placed successfully on Booklet. Will be arriving soon. Thank you!';
            $email = $request->input('email'); // Extract the email from the request
            Mail::raw($message, function ($messages) use ($email) {          //send email if order successflly summit
                $messages->to($email);
                $messages->subject('Order placement confirmation');
            });

            return response()->json(['message' => 'Email sent successfully and order has been placed!', 'order' => $order]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while processing the order. Please try again later.'], 500);
        }
    }

    public function getAllOrder()                       
    {
        $order = Order::all();             //show all order

        return response()->json(['order' => $order]);
    }

    public function indiviualOrder($id)               //get order of specfic person
    { 
        $order = Order::where('id', $id)->get();      //get data of specfic id

        if ($order->isEmpty()) {
            return response()->json(['error' => 'Order not found'], 404);
        } else {
            return response()->json(['order' => $order]);
        }
    }

    public function searchOrder($status)             //search the order
    {
        $order = Order::where('status', 'like', "%$status%")->get();      //get the book data where status is found

        if ($order->isEmpty()) {
            return response()->json(['message' => 'No order found that are pending'], 404);
        }

        return response()->json(['order' => $order]);
    }

    public function updateOrder(PlaceOrderRequest $request, $id)          //update the order data
    {
        $order = Order::where('id', $id)->first();          //get order of specfic id

        if (! $order) {
            return response()->json(['error' => 'order not found'], 404);
        }

        $updateData = [
            'books' => json_encode($request->input('books')),
            'quantity' => (int) $request->input('quantity'),
            'email' => $request->input('email'),
            'name' => $request->input('name'),
            'phone_number' => $request->input('phone_number'),
            'billing_address' => $request->input('billing_address'),
            'status' => 'pending',
            'grand_total' => (float) $request->input('grand_total'),

        ];

        try {
            $message = 'Hello Dear User, Your Order has been updated successfully on Booklet. Will be arriving soon. Thank you!';
            $email = $request->input('email'); // Extract the email from the request
            Mail::raw($message, function ($messages) use ($email) {
                $messages->to($email);
                $messages->subject('Order updateds confirmation');
            });
            $order->update($updateData);

            return response()->json(['message' => 'order updated successfully', 'order' => $order], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    public function destroyOrder($id)                   //delete the book
    {
        $order = Order::where('id', $id)->first();      //get  data of specfic id
        if (! $order) {
            return response()->json(['error' => 'order not found'], 404);
        }

        $order->delete();

        return response()->json(['message' => 'order deleted successfully']);
    }
}
