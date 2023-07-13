@extends('app')

@section('content')
    <main id="cart">
        <div class="container">
            <h1>My Cart</h1>
            @php
                $total_amount = 0;
            @endphp
            <div class="row align-items-start">
                <div class="col-md-12">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Author</th>
                                <th>Quantity</th>
                                <th class="text-center">Price</th>
                                <th class="text-center">Total</th>
                                <th> </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rows as $id => $row)
                                <tr>
                                    <td class="col-sm-8 col-md-6">
                                        <div class="media">
                                            <a class="thumbnail pull-left" href="#"> <img class="img-fluid"
                                                    src="{{ asset('storage/books/' . $row->product_data->photo) }}"> </a>
                                            <div class="media-body">
                                                <h4 class="media-heading"><a
                                                        href="{{ route('product-page', $row->product_data->long_id) }}">{{ $row->product_data->title }}</a>
                                                </h4>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="col-md-1 text-left"><strong
                                            class="label label-danger">{{ $row->product_data->author }}</strong></td>
                                    <td class="col-sm-1 col-md-1" style="text-align: center">
                                        <input type="number" class="form-control" name="quantity-{{$row->id}}"
                                            data-id="{{ $row->product_data->long_id }}" value="{{ $row->quantity }}"
                                            min="1" max="{{ $row->product_data->quantity }}">
                                    </td>
                                    <td class="col-sm-1 col-md-1 text-center">
                                        <strong>{{ '₹' . $row->product_data->price }}</strong>
                                    </td>
                                    <td class="col-sm-1 col-md-1 text-center">
                                        <strong>{{ '₹' . $row->quantity * $row->product_data->price }}</strong>
                                    </td>
                                    <td class="col-sm-1 col-md-1">
                                        <button type="button" class="btn btn-danger remove-product"
                                            data-id="{{ $row->id }}">
                                            <span class="fa fa-remove"></span> Remove
                                        </button>
                                    </td>
                                </tr>
                                @php
                                    $total_amount += $row->quantity * $row->product_data->price;
                                @endphp
                            @endforeach
                            <tr>
                                <td> </td>
                                <td> </td>
                                <td> </td>
                                <td>
                                    <h3>Total</h3>
                                </td>
                                <td class="text-right">
                                    <h3><strong>{{ '₹' . $total_amount }}</strong></h3>
                                </td>
                            </tr>
                            <tr>
                                <td> </td>
                                <td> </td>
                                <td> </td>
                                <td>
                                    <a href="{{ route('home') }}" class="btn btn-default"> Continue Shopping
                                    </a>
                                </td>
                                <td>
                                    <a href="#" class="btn btn-success">
                                        Checkout <span class="fa fa-play"></span>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        </div>
    </main>
@endsection

@section('extra-js')
    <script>
        $(document).on('click', '.remove-product', function(e) {
            e.preventDefault();
            var $this = $(this);
            var id = $this.data('id');

            var url = "{{ route('remove-cart-item', ':id') }}";
            url = url.replace(':id', id);

            $.ajax({
                type: "POST",
                url: url,
                dataType: "json",
                success: function(response) {
                    //if request if made successfully then the response represent the data
                    $this.closest('tr').fadeOut('slow');
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                }
            });

            return false;
        });

        $(document).on('change', 'input[name^=quantity]', function(e) {
            e.preventDefault();

            var formData = {
                product_long_id: $(this).data('id'),
                quantity: $(this).val(),
                reset: true
            };
            $.ajax({
                type: "POST",
                url: "{{ route('add-to-cart') }}",
                data: formData,
                dataType: "json",
                encode: true,
                success: function(response) {

                    location.reload();
                },
                error: function(data) {
                    //if request if made successfully then the response represent the data
                    // console.log(data.responseJSON);
                    Toastify({
                        text: data.responseJSON.message,
                        duration: 3000,
                        close: true,
                        gravity: "bottom",
                        position: "left",
                        backgroundColor: "#dc3545",
                        escapeMarkup: false
                    }).showToast();
                }
            });
        });
    </script>
@endsection
