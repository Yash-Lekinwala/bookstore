<div class="col">
    <div class="card shadow-sm">
        <img src="{{asset('storage/books/'.$product->photo)}}" alt="" class="img-fluid w-50 rounded mx-auto" />
        <div class="card-body">
            <a href="{{ route('product-page', $product->long_id) }}" class="text-decoration-none"><h5>{{$product->title}}</h5></a>
            <p class="card-text">Author: {{$product->author}}</p>
            <p class="card-text mb-1">Price: {{'₹'.$product->price}}</p>
            <p class="card-text">Stock: {{$product->quantity ?? ' No Stock'}}</p>
        </div>
    </div>
</div>