<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
use App\Cart;
use App\Http\View\Composers\CartComposer;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Register the CartComposer for the 'app' view
        View::composer('app', CartComposer::class);

        // Share cart data with 'layout.header' and 'checkout' views
        View::composer(['layout.header', 'checkout'], function ($view) {
            if (Session::has('cart')) {
                $oldCart = Session::get('cart');
                $cart = new Cart($oldCart);
                $view->with([
                    'cart' => $cart,
                    'productCarts' => $cart->items,
                    'totalPrice' => $cart->totalPrice,
                    'totalQty' => $cart->totalQty
                ]);
            } else {
                $view->with([
                    'cart' => null,
                    'productCarts' => [],
                    'totalPrice' => 0,
                    'totalQty' => 0
                ]);
            }
        });
    }
}
