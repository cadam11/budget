<nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    <i class="fa fa-university"></i> Budget
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> Home</a></li>
                    @if (!Auth::guest())
                    <li><a href="{{ route('transactions::index') }}"><i class="fa fa-shopping-cart"></i> Transactions</a></li>
                    <li><a href="{{ route('budgets::index') }}"><i class="fa fa-pie-chart"></i> Budgets</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i> Administration <i class="fa fa-caret-down"></i></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ route('admin::todo') }}"><i class="fa fa-check-square-o"></i> To Do</a></li>
                            <li><a href="{{ route('admin::info') }}"><i class="fa fa-info"></i> Info</a></li>
                            <li><a href="{{ route('admin::rules::index') }}"><i class="fa fa-list"></i> Category Rules</a></li>
                            <li><a href="{{ route('admin::settings') }}"><i class="fa fa-cog"></i> Settings</a></li>
                        </ul>
                    </li>
                    @endif
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Login</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <i class="fa fa-caret-down"></i>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>        
    </nav>