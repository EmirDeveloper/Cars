<div class="position-relative bg-white border rounded">
    <div class="">
        <img src="{{  $product->image ? Storage::url('products/sm/' . $product->image) : asset('img/sm/product.jpg') }}"
            alt="{{ $product->getFullName() }}" class="img-fluid rounded-start col-12">
    </div>
    <div>
        <div class="d-flex flex-column h-100 pb-3">
            <div class="fw-semibold mb-auto">
                <div class="px-4 pt-3">
                    <i class="bi-coin text-primary me-1"></i>
                    {{ $product->price }} <span class="fw-bold">TMT</span>
                </div>
                <div class="px-4 pt-3 small">
                    <i class="bi-car-front-fill text-primary me-1"></i>
                    {{ $product->category->getName() }}
                </div>
                <div class="px-4 pt-2 small">
                    <i class="bi-geo-alt-fill text-primary me-1"></i>
                    @if($product->location->parent_id)
                        <span class="text-secondary">{{ $product->location->parent->getName() }},</span>
                    @endif
                    {{ $product->location->getName() }}
                </div>
                <a href="{{ route('product.show', $product->slug) }}" class="link-dark text-decoration-none stretched-link">
                    {{ $product->name }}
                </a>
                <div class="px-4 pt-2 small">
                    <i class="bi-clock-history text-primary me-1"></i>
                    {{ $product->created_at }}
                </div>
            </div>
        </div>
    </div>
</div>