@extends('app')

@section('content')
    <div class="container mt-3 mt-md-5">
        <h2 class="text-charcoal hidden-sm-down">Your Orders</h2>

        @if ($orders->count() > 0)
            @foreach ($orders as $order)
                <div class="row">
                    <div class="col-12">
                        <div class="list-group mb-5">
                            <div class="list-group-item p-3 bg-snow" style="position: relative;">
                                <div class="row w-100 no-gutters">
                                    <div class="col-6 col-md">
                                        <h6 class="text-charcoal mb-0 w-100">Order Number</h6>
                                        <a href="#"
                                            class="text-pebble mb-0 w-100 mb-2 mb-md-0">{{ $order->id }}</a>
                                    </div>
                                    <div class="col-6 col-md">
                                        <h6 class="text-charcoal mb-0 w-100">Date</h6>
                                        <p class="text-pebble mb-0 w-100 mb-2 mb-md-0">{{ Carbon\Carbon::parse($order->created_at)->format('d-m-Y') }}</p>
                                    </div>
                                    <div class="col-6 col-md">
                                        <h6 class="text-charcoal mb-0 w-100">Total</h6>
                                        <p class="text-pebble mb-0 w-100 mb-2 mb-md-0">{{ '₹' . $order->total_amount }}</p>
                                    </div>
                                    <div class="col-6 col-md">
                                        <h6 class="text-charcoal mb-0 w-100">Address</h6>
                                        <p class="text-pebble mb-0 w-100 mb-2 mb-md-0">
                                            {{ $order->address . ', ' . $order->city }}</p>
                                    </div>
                                </div>

                            </div>
                            <div class="list-group-item p-3 bg-white">
                                @foreach ($order->order_details as $detail)
                                    <div class="row no-gutters">
                                        <div class="row no-gutters mt-3">
                                            <div class="col-9 col-md-8 pr-0 pr-md-3">
                                                <h6 class="text-charcoal mb-2 mb-md-1">
                                                    <a href="#" class="text-charcoal">{{$detail->quantity}} x {{$detail->title}}</a>
                                                </h6>
                                                <h6 class="text-charcoal text-left mb-0 mb-md-2"><b>{{ '₹' . $detail->sub_total }}</b></h6>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="row">
                <div class="col-md-12">
                    <p>No Order Found.</p>
                </div>
            </div>
        @endif
    </div>
@endsection
