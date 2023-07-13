@extends('app')
@section('content')
    <main>
        <div class="books py-5">
            <div class="container">

                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
                    {{-- @foreach ($products as $product)
                        <div class="col">
                            <div class="card shadow-sm">
                                <img src="{{asset('storage/books/'.$product->photo)}}" alt="" class="img-fluid w-50 rounded mx-auto" />
                                <div class="card-body">
                                    <a href="{{ route('product-page', $product->long_id) }}" class="text-decoration-none"><h5>{{$product->title}}</h5></a>
                                    <p class="card-text">Author: {{$product->author}}</p>
                                    <p class="card-text">Price: {{$product->price}}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach --}}
                </div>
            </div>
        </div>

    </main>
@endsection


@section('extra-js')
    <script>
        $(document).ready(function() {
            call_ajax_products();
        });
    </script>
@endsection