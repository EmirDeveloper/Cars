
<section id="image-carousel" class="splide" aria-label="Beautiful Images">
    <div class="splide__track">
        <ul class="splide__list">
            <li class="splide__slide">
                <img src="storage/images/slider/slider1.jpg" alt="" class="">
            </li>
            <li class="splide__slide">
                <img src="storage/images/slider/slider1.jpg" alt="" class="">
                <!-- <img src="{{ storage_path('/images/slider/slider2.jpg') }}" alt="" class="">  hem bolup biler -->
            </li>
        </ul>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let splide = new Splide('#image-carousel', {
            type: 'loop',
            autoplay: true,
            arrows: false,
            interval: 4000,
            pauseOnHover: false,
            pauseOnFocus: false,
            perPage: 1,
            perMove: 1,
        })
        splide.mount();
    });
</script>

<style>
    .splide__slide img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

</style>
