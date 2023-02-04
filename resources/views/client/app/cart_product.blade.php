<div class="bg-white shadow py-2 px-1 my-3 text-center">
    <div class="row justify-content-center align-items-center">
        <div class="col-2">
            <i class="bi-cart fs-5"></i>
        </div>
        <div class="col-3">
            <div class="h5 fw-bolder text-center pt-3">
                {{ $product['product']->name_tm }}
            </div>
        </div>
        <div class="col-3">
            <div class="row align-items-center">
                <div class="col-3">
                    <a href="{{ route('client.cart.add', $product['product']->id) }}"
                       class="btn btn-secondary opacity-25 btn-sm disabled">
                        <i class="bi-plus-lg"></i>
                    </a>
                </div>
                <div class="col-2">
                    <div class="fs-5 text-center text-dark">{{ $product['count'] }}</div>
                </div>
                <div class="col-3">
                    <a href="{{ route('client.cart.add', $product['product']->id) }}"
                       class="btn btn-secondary opacity-25 btn-sm disabled">
                        <i class="bi-dash-lg"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-2">
            <div class="fw-bold">
                {{ number_format($product['product']->price * $product['count'], 2, '.', ' ') }}
                <small>TMT</small>
            </div>
        </div>
        <div class="col-2">
            <a href="{{ route('client.cart.remove', $product['product']->id) }}" class="btn">
                <i class="bi-trash3"></i>
            </a>
        </div>
    </div>
</div>



