@extends('app')

@section('content')
    <main id="cart">
        <div class="container">
            <h1>My Cart</h1>
            <div class="row align-items-start">
                <div class="col-12 col-sm-8 items">
                    <!--1-->
                    <div class="cartItem row align-items-start">
                        <div class="col-3 mb-2">
                            <img class="w-100" src="https://badux.co/smc/codepen/birdcage-posters.jpg" alt="art image">
                        </div>
                        <div class="col-5 mb-2">
                            <h6 class="">Dark Art 1</h6>
                            <p class="pl-1 mb-0">20 x 24</p>
                            <p class="pl-1 mb-0">Matte Print</p>
                        </div>
                        <div class="col-2">
                            <p class="cartItemQuantity p-1 text-center">1</p>
                        </div>
                        <div class="col-2">
                            <p id="cartItem1Price">$66</p>
                        </div>
                    </div>
                    <hr>
                    <!--2-->
                    <div class="cartItem row align-items-start">
                        <div class="col-3 mb-2">
                            <img class="w-100" src="https://badux.co/smc/codepen/birdcage-posters.jpg" alt="art image">
                        </div>
                        <div class="col-5 mb-2">
                            <h6 class="">Dark Art 2</h6>
                            <p class="pl-1 mb-0">20 x 24</p>
                            <p class="pl-1 mb-0">Matte Print</p>
                        </div>
                        <div class="col-2">
                            <p class="cartItemQuantity p-1 text-center">1</p>
                        </div>
                        <div class="col-2">
                            <p id="cartItem1Price">$66</p>
                        </div>
                    </div>
                    <hr>
                </div>
                <div class="col-12 col-sm-4 p-3 proceed form">
                    <div class="row m-0">
                        <div class="col-sm-8 p-0">
                            <h6>Subtotal</h6>
                        </div>
                        <div class="col-sm-4 p-0">
                            <p id="subtotal">$132.00</p>
                        </div>
                    </div>
                    <div class="row m-0">
                        <div class="col-sm-8 p-0 ">
                            <h6>Tax</h6>
                        </div>
                        <div class="col-sm-4 p-0">
                            <p id="tax">$6.40</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row mx-0 mb-2">
                        <div class="col-sm-8 p-0 d-inline">
                            <h5>Total</h5>
                        </div>
                        <div class="col-sm-4 p-0">
                            <p id="total">$138.40</p>
                        </div>
                    </div>
                    <a href="#"><button id="btn-checkout" class="shopnow"><span>Checkout</span></button></a>
                </div>
            </div>
        </div>
        </div>
    </main>
@endsection
