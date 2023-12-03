<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    @php
        auth()->user()->load('business');
        $logo = auth()->user()->business->business_logo;
        $name = auth()->user()->business->business_name;
    @endphp
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand bg-white d-flex align-items-center justify-content-center" href="{{ route('home') }}">
        <img class="w-50" src="{{ asset($logo) }}" alt="">
    </a>


    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('home') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>{{ $name }} Dashboard</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    @can('Business View')
    <li class="nav-item">
        <a class="nav-link {{ !in_array(Request::segment(1), [ 'business']) ? 'collapsed' : '' }}" href="#" data-toggle="collapse" data-target="#business_management"
            aria-expanded="true" aria-controls="business_management">
            <i class="fa-solid fa-briefcase"></i>
            <span>Business Management</span>
        </a>
        <div id="business_management" class="collapse {{ in_array(Request::segment(1), ['business']) ? 'show' : '' }}" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Business Management</h6>
                <a class="collapse-item {{  Request::segment(1) == 'business' ? 'active' : ''  }}" href="{{ route('business') }}">Business</a>
            </div>
        </div>
    </li>
    @endcan

    @can('User View')
    <li class="nav-item">
        <a class="nav-link {{ !in_array(Request::segment(1), [ 'user']) ? 'collapsed' : '' }}" href="#" data-toggle="collapse" data-target="#user_management"
            aria-expanded="true" aria-controls="user_management">
            <i class="fa-regular fa-user"></i>
            <span>User Management</span>
        </a>
        <div id="user_management" class="collapse {{ in_array(Request::segment(1), ['user', 'roles']) ? 'show' : '' }}" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">User Management</h6>
                @can('User View')
                <a class="collapse-item {{  Request::segment(1) == 'user' ? 'active' : ''  }}" href="{{ route('user') }}">Users</a>
                @endcan
                @can('Roles View')
                <a class="collapse-item {{ Request::segment(1) == 'roles' ? 'active' : '' }}" href="{{ route('roles') }} " href="{{ route('roles') }}">Roles</a>
                @endcan
            </div>
        </div>
    </li>
    @endcan
    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Nav Item - Pages Collapse Menu -->
    @can('Customer View')
    <li class="nav-item">
        <a class="nav-link {{ !in_array(Request::segment(1), [ 'customer']) ? 'collapsed' : '' }}" href="#" data-toggle="collapse" data-target="#collapesActivity"
            aria-expanded="true" aria-controls="collapesActivity">
            <i class="fa-solid fa-list-check"></i>
            <span>Customers</span>
        </a>
        <div id="collapesActivity" class="collapse {{ in_array(Request::segment(1), ['customer']) ? 'show' : '' }}" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">

                <a class="collapse-item {{  Request::segment(1) == 'customer' ? 'active' : ''  }}" href="{{ route('customer') }}">Customers</a>


            </div>
        </div>
    </li>
    @endcan
    @if (auth()->user()->can('Service View') || auth()->user()->can('Service Category View'))
    <li class="nav-item">
        <a class="nav-link {{ !in_array(Request::segment(1), [ 'service', 'service_category']) ? 'collapsed' : '' }}" href="#" data-toggle="collapse" data-target="#service"
            aria-expanded="true" aria-controls="service">
            <i class="fa-regular fa-rectangle-list"></i>
            <span>Service Management</span>
        </a>
        <div id="service" class="collapse {{ in_array(Request::segment(1), ['service_category', 'service']) ? 'show' : '' }}" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                @can('Service View')
                <a class="collapse-item {{  Request::segment(1) == 'service_category' ? 'active' : ''  }}" href="{{ route('service_category') }}">Service Category</a>
                @endcan
                @can('Service Category View')
                <a class="collapse-item {{  Request::segment(1) == 'service' ? 'active' : ''  }}" href="{{ route('service') }}">Services</a>
                @endcan

            </div>
        </div>
    </li>
    @endif
    @if (auth()->user()->can('Order View') || auth()->user()->can('Order Create'))
     <li class="nav-item">
        <a class="nav-link {{ !in_array(Request::segment(1), [ 'order']) ? 'collapsed' : '' }}" href="#" data-toggle="collapse" data-target="#orders"
            aria-expanded="true" aria-controls="orders">
            <i class="fa-solid fa-rectangle-list"></i>
            <span>Orders Management</span>
        </a>
        <div id="orders" class="collapse {{ in_array(Request::segment(1), ['order']) ? 'show' : '' }}" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                @can('Order View')
                <a class="collapse-item {{  Request::routeIs('order') ? 'active' : ''  }}" href="{{ route('order') }}">Order List</a>
                @endcan
                @can('Order Create')
                <a class="collapse-item {{  Request::routeIs('order.create') ? 'active' : ''  }}" href="{{ route('order.create') }}">Add Order</a>
                @endcan
            </div>
        </div>
    </li>
    @endif
    @if (auth()->user()->can('Expense View') || auth()->user()->can('Expense Category View'))
    <li class="nav-item">
        <a class="nav-link {{ !in_array(Request::segment(1), [ 'expense', 'expense_category']) ? 'collapsed' : '' }}" href="#" data-toggle="collapse" data-target="#expense"
            aria-expanded="true" aria-controls="expense">
            <i class="fa-solid fa-rectangle-list"></i>
            <span>Expense Management</span>
        </a>

        <div id="expense" class="collapse {{ in_array(Request::segment(1), ['expense', 'expense_category']) ? 'show' : '' }}" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                @can('Expense View')
                <a class="collapse-item {{  in_array(Request::segment(1), [ 'expense_category']) ? 'active' : ''  }}" href="{{ route('expenseCategory') }}">Expense Category</a>
                @endcan
                @can('Expense Category View')
                <a class="collapse-item {{  in_array(Request::segment(1), [ 'expense']) ? 'active' : ''  }}" href="{{ route('expense') }}">Expense</a>
                @endcan
            </div>
        </div>
    </li>
    @endif

    <li class="nav-item">
        <a class="nav-link {{ !in_array(Request::segment(1), [ 'report']) ? 'collapsed' : '' }}" href="#" data-toggle="collapse" data-target="#report_management"
            aria-expanded="true" aria-controls="report_management">
            <i class="fa-solid fa-rectangle-list"></i>
            <span>Reports</span>
        </a>

        <div id="report_management" class="collapse {{ in_array(Request::segment(1), ['report']) ? 'show' : '' }}" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{  Request::routeIs('order.report') ? 'active' : ''  }}" href="{{ route('order.report') }}">Order Report</a>
                <a class="collapse-item {{  Request::routeIs('profit_loss.report') ? 'active' : ''  }}" href="{{ route('profit_loss.report') }}">Profit Loss Report</a>
            </div>
        </div>
    </li>
</ul>
<!-- End of Sidebar -->
