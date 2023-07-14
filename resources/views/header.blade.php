<header class="p-3 mb-3 border-bottom">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            <a href="{{ route('home') }}"
                class="d-flex align-items-center mb-2 mb-lg-0 link-body-emphasis text-decoration-none">
                <span class="fs-4">Book Store</span>
            </a>

            <ul class="nav col-12 col-md-auto mb-2 ms-3 justify-content-center mb-md-0">
                <li><a href="{{ route('orders') }}" class="nav-link px-2 link-dark">Orders</a></li>
            </ul>

            <form class="col-12 col-lg-auto ms-lg-auto mb-3 mb-lg-0 me-lg-3" role="search">
                <input type="search" id="search" name="search" class="form-control" placeholder="Search..."
                    aria-label="Search">
            </form>

            <div class="text-end">
                <a href="{{ route('cart') }}" class="d-block link-body-emphasis text-decoration-none">
                    Cart
                    <span class="cart-quantity">
                        @if (App\Models\TempOrder::whereSessionId(Session::get('session_id'))->count() > 0)
                            ({{ App\Models\TempOrder::whereSessionId(Session::get('session_id'))->get()->sum('quantity') }})
                        @else
                            (0)
                        @endif
                    </span>
                </a>
            </div>
        </div>
    </div>
</header>
