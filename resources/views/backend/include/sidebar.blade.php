<aside class="left-sidebar">
    <div>
        <div class="brand-logo-2 d-flex align-items-center justify-content-between">
            <img src="{{ asset('logo.png') }}" alt="Logo" width="70px" />
            <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                <i class="ti ti-x fs-6"></i>
            </div>
        </div>

        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
            <ul id="sidebarnav" class="nav">


                @php $u = Auth::user(); @endphp

                @if ($u && $u->hasRole('clerk'))
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('clerk.dashboard') }}">
                            <i class="ti ti-dashboard"></i>
                            <span class="hide-menu">Dashboard</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('products.index') }}">
                            <i class="ti ti-box"></i>
                            <span class="hide-menu">Products</span>
                        </a>
                    </li>
                @endif

                @if ($u && $u->hasRole('admin'))

                    <!-- Dashboard -->
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('admin.dashboard') }}">
                            <i class="ti ti-dashboard"></i>
                            <span class="hide-menu">Dashboard</span>
                        </a>
                    </li>

                    <!-- LOW STOCK ALERTS -->
                    <li class="sidebar-item">
                        <a class="sidebar-link d-flex align-items-center justify-content-between"
                            href="{{ route('admin.lowstock') }}">
                            <div>
                                <i class="ti ti-alert-triangle"></i>
                                <span class="hide-menu">Low Stock</span>
                            </div>

                            {{-- RED BADGE --}}
                            @php
                                $lowCount = \App\Models\Product::whereColumn('stock', '<=', 'min_stock')->count();
                            @endphp

                            @if ($lowCount > 0)
                                <span class="badge bg-danger">{{ $lowCount }}</span>
                            @endif
                        </a>
                    </li>

                    <!-- Orders (Just Placeholder Now) -->
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="javascript:void(0)">
                            <i class="ti ti-shopping-cart"></i>
                            <span class="hide-menu">Orders (coming soon)</span>
                        </a>
                    </li>

                    <!-- Administration -->
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('users.index') }}">
                            <i class="ti ti-users"></i>
                            <span class="hide-menu">User Management</span>
                        </a>
                    </li>

                @endif





            </ul>
        </nav>
    </div>
</aside>

<style>
    .sidebar-link {
        display: flex !important;
        align-items: center !important;
        padding: 10px 15px !important;
    }

    .sidebar-link i {
        margin-right: 10px;
        width: 20px;
        text-align: center;
    }

    .brand-logo-2 {
        min-height: 70px;
        padding: 0 24px;
        margin-left: 50px;
        margin-top: 26px;
    }
</style>
