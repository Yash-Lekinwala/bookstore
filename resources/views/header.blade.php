<header class="p-3 mb-3 border-bottom">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            <a href="{{ route('home') }}"
                class="d-flex align-items-center mb-2 mb-lg-0 link-body-emphasis text-decoration-none">
                <span class="fs-4">Book Store</span>
            </a>

            <form class="col-12 col-lg-auto ms-lg-auto mb-3 mb-lg-0 me-lg-3" role="search">
                <input type="search" id="search" name="search" class="form-control" placeholder="Search..."
                    aria-label="Search">
            </form>

            <div class="text-end">
                <a href="{{ route('cart') }}" class="d-block link-body-emphasis text-decoration-none">
                    Cart
                </a>
            </div>
        </div>
    </div>
</header>
