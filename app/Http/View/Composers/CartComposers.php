<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Session;

class CartComposer
{
    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        // Get the cart from the session
        $cart = Session::has('cart') ? Session::get('cart') : null;
        // Extract the cart items (default to an empty array if cart is null)
        $productCarts = $cart ? ($cart->items ?? []) : [];

        // Pass the variables to the view
        $view->with('cart', $cart);
        $view->with('productCarts', $productCarts);
    }
}
