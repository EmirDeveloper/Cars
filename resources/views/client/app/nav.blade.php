<nav class="navbar navbar-expand-md navbar-default navbar-trans navbar-dark bg-primary bg-opacity-50 fixed-top p-0">
    <div class="container-xl">
        <a class="navbar-brand" href="{{ route('home') }}"><img src="https://tmcars.info/assets/logoV5-3c6d5d6233ec99725cbfc24d0c20ceee.png" alt="w" class="col-9"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbars" aria-controls="navbars" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-collapse collapse justify-content-center" id="navbarDefault">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('message') }}">@lang('app.contact_us')</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" id="dropdown02" data-bs-toggle="dropdown" aria-expanded="false">
                        @lang('app.categories')
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdown02">
                        @foreach($categories as $category)
                            <li>
                                <a class="dropdown-item" href="{{ route('category.show', $category->slug) }}">
                                    {{ $category->getName() }}
                                    <span class="badge text-bg-info bg-opacity-10">{{ $category->products_count }}</span>
                                    <span class="badge text-bg-warning bg-opacity-10">{{ $category->out_of_stock_products_count }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('product.create') }}" href="#" aria-expanded="false">
                        <i class="bi-plus-circle"></i> @lang('app.add')
                    </a>
                </li>
                @auth('customer_web')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">
                            <i class="bi-box-arrow-right"></i> {{ auth('customer_web')->user()->name }}
                        </a>
                    </li>
                    <form id="logoutForm" action="{{ route('logout') }}" method="post" class="d-none">
                        @csrf
                    </form>
                @else
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('verification') }}">
                            <i class="bi-person-add"></i> @lang('app.login')
                        </a>
                    </li>
                @endauth
                @foreach($locales as $locale)
                    @if(app()->getLocale() != $locale)
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-white" href="#" id="dropdown02" data-bs-toggle="dropdown" aria-expanded="false">@lang('app.lang')</a>
                            <ul class="dropdown-menu" aria-labelledby="dropdown02">
                                <li>
                                    <a class="dropdown-item" href="{{ route('language', 'tm') }}"><img src="{{ asset('img/flag/tm.png') }}" alt="" style="height:1rem;"> Türkmen</a>
                                    <a class="dropdown-item" href="{{ route('language', 'en') }}"><img src="{{ asset('img/flag/en.png') }}" alt="" style="height:1rem;"> English</a>
                                </li>
                            </ul>
                        </li>
                    @endif
                @endforeach()
            </ul>
        </div>
    </div>
</nav>