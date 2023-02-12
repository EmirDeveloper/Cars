<div class="container-xxl py-3 mt-5">
    <div class="row row-cols-2 row-cols-lg-4 row-cols-xl-4 g-3">
        @foreach($new as $product)
            <div class="col" data-aos="fade-up">
                @include('client.app.product')
            </div>
        @endforeach
    </div>
</div>
<script>
    AOS.init();
</script>