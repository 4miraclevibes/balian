<nav class="navbar">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ $assets->where('name', 'combination-mark')->first()->image ?? asset('assets/landing/images/logo-navbar.png') }}" alt="Logo" height="30">
        </a>
        <ul class="navbar-nav d-flex flex-row">
            @guest
                <li class="nav-item me-3">
                    <a class="nav-link" href="{{ route('landing.auth.login') }}">Masuk</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link bg-success text-white rounded-pill px-3 py-2" href="{{ route('landing.auth.register') }}">Daftar</a>
                </li>
            @else
                @if(Auth::user()->role->name === 'admin')
                    <li class="nav-item me-3">
                        <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link bg-success text-white rounded-pill px-3 py-2" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            @endguest
        </ul>
    </div>
</nav>

@section('style')
<style>
    .navbar {
        background-color: #ffffff;
        box-shadow: 0 2px 4px rgba(0,0,0,.1);
    }
    .nav-link {
        color: #333333;
    }
</style>
@endsection