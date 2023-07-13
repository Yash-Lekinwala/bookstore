@extends('app')

@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="col-md-5">
                <div class="main-img text-center">
                    <img class="img-fluid w-50" src="{{ asset('storage/books/' . $product_data->photo) }}" alt="ProductS">
                </div>
            </div>
            <div class="col-md-7">
                <div class="main-description px-2">
                    <h2 class="my-3">
                        {{ $product_data->title }}
                    </h2>
                    <div class="text-bold">
                        Author: {{ $product_data->author }}
                    </div>
                    <div class="text-bold">
                        Stock: {{ $product_data->quantity > 0 ? $product_data->quantity : 'No Stock' }}
                    </div>

                    <div class="price-area my-4">
                        <p class="new-price text-bold mb-1">{{ '₹' . $product_data->price }}</p>
                    </div>


                    @if ($product_data->quantity > 0)
                        <div class="buttons d-flex my-5">

                            <div class="block quantity">
                                <input type="number" class="form-control" id="cart_quantity" value="1" min="0"
                                    max="{{ $product_data->quantity }}" name="cart_quantity">
                            </div>
                            <div class="block ms-3">
                                <button class="btn btn-primary add-to-cart" data-id="{{ $product_data->long_id }}">Add to
                                    cart</button>
                            </div>
                        </div>
                    @endif

                </div>

            </div>
        </div>
    </div>
@endsection
@section('extra-js')
    <script>
        $(document).on('click', '.add-to-cart', function(e) {
            e.preventDefault();

            var formData = {
                product_long_id: $(this).data('id'),
                quantity: $('#cart_quantity').val()
            }

            $.ajax({
                type: "POST",
                url: "{{ route('add-to-cart') }}",
                data: formData,
                dataType: "json",
                success: function(response) {
                    $('.cart-quantity').html('(' + response.cart_quantity + ')')
                    Toastify({
                        text: response.message,
                        duration: 3000,
                        close: true,
                        gravity: "bottom",
                        position: "right",
                        backgroundColor: "#4fbe87",
                    }).showToast();
                },
                error: function(data) {
                    var errors = data.responseJSON;

                    Toastify({
                        text: errors.message,
                        duration: 3000,
                        close: true,
                        gravity: "bottom",
                        position: "left",
                        backgroundColor: "#dc3545",
                        escapeMarkup: false
                    }).showToast();
                }
            })
        })
    </script>
@endsection
