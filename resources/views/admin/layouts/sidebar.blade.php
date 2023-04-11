<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light border-end sidebar collapse">
    <div class="position-sticky py-2 sidebar-sticky">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link link-primary" href="{{ route('admin.dashboard') }}">
                    <i class="bi-speedometer text-primary me-1"></i> @lang('app.dashboard')
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link link-primary" href="{{ route('admin.customers.index') }}">
                    <i class="bi-people-fill text-primary me-1"></i> @lang('app.customers')
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link link-primary" href="{{ route('admin.verifications.index') }}">
                    <i class="bi-shield-fill-check text-primary me-1"></i> @lang('app.verifications')
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link link-primary" href="{{ route('admin.products.index') }}">
                    <i class="bi-box-fill text-primary me-1"></i> @lang('app.products')
                </a>
            </li>
            @can('categories')
                <li class="nav-item">
                    <a class="nav-link link-primary" href="{{ route('admin.categories.index') }}">
                        <i class="bi-bar-chart-line-fill text-primary me-1"></i> @lang('app.categories')
                    </a>
                </li>
            @endcan
            @can('brands')
                <li class="nav-item">
                    <a class="nav-link link-primary" href="{{ route('admin.brands.index') }}">
                        <i class="bi-github text-primary me-1"></i> @lang('app.brands')
                    </a>
                </li>
            @endcan
            <li class="nav-item">
                <a class="nav-link color-b" href="{{ route('messages.index') }}">
                    <i class="bi bi-chat-dots-fill me-1"></i> @lang('app.messages')
                </a>
            </li>
            @can('attributes')
                <li class="nav-item">
                    <a class="nav-link link-primary" href="{{ route('admin.attributes.index') }}">
                        <i class="bi-palette-fill text-primary me-1"></i> @lang('app.attributes')
                    </a>
                </li>
            @endcan
            @can('locations')
                <li class="nav-item">
                    <a class="nav-link link-primary" href="{{ route('admin.locations.index') }}">
                        <i class="bi-geo-alt-fill text-primary me-1"></i> @lang('app.locations')
                    </a>
                </li>
            @endcan
            <li class="nav-item">
                <a class="nav-link link-primary" href="{{ route('admin.users.index') }}">
                    <i class="bi-people-fill text-primary me-1"></i> @lang('app.users')
                </a>
            </li>
        </ul>
    </div>
</nav>