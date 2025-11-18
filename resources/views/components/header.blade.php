<header>
    <div class="container">
        <nav>
            <div class="nav-logo">
                <img src="https://raw.githubusercontent.com/mustafadalga/tour-and-travel/master/assets/img/logo.svg" alt="">
            </div>

            <div class="nav-right">
                <ul class="nav-menu">
                    <li><a href="/" class="nav-link active">Home</a></li>

                    <li><a href="{{ route('destinations.index') }}" class="nav-link">Packages</a></li>

                    <li><a href="#" class="nav-link">About</a></li>
                    <li><a href="#" class="nav-link">Partner</a></li>
                </ul>

                <div class="nav-form">
                    <a href="{{ route('login') }}" class="btn btn-login">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-register">Register</a>
                </div>
            </div>

            <div class="hamburger-menu-wrap">
                <div class="hamburger-menu">
                    <div class="line"></div>
                    <div class="line"></div>
                    <div class="line"></div>
                </div>
            </div>
        </nav>
    </div>
</header>
