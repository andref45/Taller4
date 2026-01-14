<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CartController extends Controller
{
    use ApiResponser;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get cart items for a specific user
     * GET /cart/{user_id}
     */
    public function show($userId)
    {
        $cartItems = Cart::where('user_id', $userId)->get();

        // Calculate total
        $total = $cartItems->sum(function($item) {
            return $item->price * $item->quantity;
        });

        return $this->successResponse([
            'items' => $cartItems,
            'total' => $total,
            'item_count' => $cartItems->count()
        ]);
    }

    /**
     * Add item to cart
     * POST /cart/items
     */
    public function addItem(Request $request)
    {
        $rules = [
            'user_id' => 'required|integer|min:1',
            'book_id' => 'required|integer|min:1',
            'quantity' => 'integer|min:1',
            'price' => 'required|numeric|min:0'
        ];

        $this->validate($request, $rules);

        // Check if item already exists in cart
        $existingItem = Cart::where('user_id', $request->user_id)
                           ->where('book_id', $request->book_id)
                           ->first();

        if ($existingItem) {
            // Update quantity
            $existingItem->quantity += $request->input('quantity', 1);
            $existingItem->save();
            return $this->successResponse($existingItem, Response::HTTP_OK);
        }

        // Create new cart item
        $cart = Cart::create($request->all());

        return $this->successResponse($cart, Response::HTTP_CREATED);
    }

    /**
     * Update cart item quantity
     * PUT /cart/items/{id}
     */
    public function updateItem(Request $request, $id)
    {
        $rules = [
            'quantity' => 'required|integer|min:1'
        ];

        $this->validate($request, $rules);

        $cart = Cart::findOrFail($id);
        $cart->quantity = $request->quantity;
        $cart->save();

        return $this->successResponse($cart);
    }

    /**
     * Remove item from cart
     * DELETE /cart/items/{id}
     */
    public function removeItem($id)
    {
        $cart = Cart::findOrFail($id);
        $cart->delete();

        return $this->successResponse(['message' => 'Item removed from cart']);
    }

    /**
     * Clear all items from user's cart
     * DELETE /cart/{user_id}/clear
     */
    public function clearCart($userId)
    {
        $deleted = Cart::where('user_id', $userId)->delete();

        return $this->successResponse([
            'message' => 'Cart cleared',
            'items_removed' => $deleted
        ]);
    }

    /**
     * Process checkout (convert cart to order)
     * POST /cart/{user_id}/checkout
     */
    public function checkout($userId)
    {
        $cartItems = Cart::where('user_id', $userId)->get();

        if ($cartItems->isEmpty()) {
            return $this->errorResponse('Cart is empty', Response::HTTP_BAD_REQUEST);
        }

        // Calculate total
        $total = $cartItems->sum(function($item) {
            return $item->price * $item->quantity;
        });

        // Return checkout summary
        // In a real implementation, this would create an order and clear the cart
        return $this->successResponse([
            'message' => 'Checkout processed successfully',
            'items' => $cartItems,
            'total' => $total,
            'order_id' => rand(1000, 9999) // Simulated order ID
        ]);
    }
}
