@extends('app')

@section('content')
    <div class="container">
        <main>
            <div class="py-5 text-center">
                <h2>Checkout form</h2>
            </div>

            <div class="row g-5">
                <div class="col-md-5 col-lg-4 order-md-last">
                    <h4 class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-primary">Your cart</span>
                        <span class="badge bg-primary rounded-pill">{{ $total_qty }}</span>
                    </h4>
                    <ul class="list-group mb-3">
                        @php
                            $total_amount = 0;
                        @endphp
                        @foreach ($rows as $row)
                            <li class="list-group-item d-flex justify-content-between lh-sm">
                                <div>
                                    <h6 class="my-0">{{ $row->product_data->title . ' - ' . $row->quantity }}</h6>
                                    <small class="text-body-secondary">{{ $row->product_data->author }}</small>
                                </div>
                                <span
                                    class="text-body-secondary">{{ '₹' . $row->quantity * $row->product_data->price }}</span>
                            </li>
                            @php
                                $total_amount += $row->quantity * $row->product_data->price;
                            @endphp
                        @endforeach

                        <li class="list-group-item d-flex justify-content-between">
                            <span>Total</span>
                            <strong>{{ '₹' . $total_amount }}</strong>
                        </li>
                    </ul>

                </div>
                <div class="col-md-7 col-lg-8">
                    <h4 class="mb-3">Billing address</h4>
                    <form class="needs-validation" novalidate id="checkoutForm">
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <label for="firstName" class="form-label">First name</label>
                                <input type="text" class="form-control" id="firstName" name="first_name" placeholder=""
                                    value="" required>
                                <div class="invalid-feedback">
                                    Valid first name is required.
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <label for="lastName" class="form-label">Last name</label>
                                <input type="text" class="form-control" id="lastName" name="last_name" placeholder=""
                                    value="" required>
                                <div class="invalid-feedback">
                                    Valid last name is required.
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="you@example.com">
                                <div class="invalid-feedback">
                                    Please enter a valid email address for shipping updates.
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" class="form-control" id="address" name="address"
                                    placeholder="1234 Main St" required>
                                <div class="invalid-feedback">
                                    Please enter your shipping address.
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label for="country" class="form-label">Country</label>
                                <input type="text" class="form-control" id="country" name="country" placeholder=""
                                    required>
                                <div class="invalid-feedback">
                                    Country required.
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="state" class="form-label">State</label>
                                <input type="text" class="form-control" id="state" name="state" placeholder=""
                                    required>
                                <div class="invalid-feedback">
                                    State required.
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="city" class="form-label">City</label>
                                <input type="text" class="form-control" id="city" name="city" placeholder=""
                                    required>
                                <div class="invalid-feedback">
                                    City required.
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <button class="w-100 btn btn-primary btn-lg" type="submit">Place Order</button>
                    </form>
                </div>
            </div>
        </main>
    </div>
@endsection

@section('extra-js')
    <script>
        $('#checkoutForm').submit(function(e) {
            var $checkoutForm = $('#checkoutForm');
            e.preventDefault();
            if (document.getElementById("checkoutForm").checkValidity() === false) {
                e.preventDefault();
                e.stopPropagation();

                $checkoutForm.addClass('was-validated');
                return false;
            }

            $checkoutForm.addClass('was-validated');

            var formData = new FormData($(this)[0]);
            $.ajax({
                type: "POST",
                url: "{{ route('place-order') }}",
                data: formData,
                processData: false,
                contentType: false,
                dataType: "json",
                encode: true,
                success: function(response) {
                    //if request if made successfully then the response represent the data
                    // console.log(response)
                    $("#checkoutForm")[0].reset();
                    $('#checkoutForm').removeClass('was-validated');

                    setTimeout(() => {
                        window.location.href = "{{route('home')}}";
                    }, 2000);

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
                    //if request if made successfully then the response represent the data
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
