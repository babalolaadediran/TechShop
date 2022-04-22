<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyShop</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <style>
      .help-block {
        color: #dd4b39;
      }    
    </style>
</head>
<body>
    <div class="container-fluid">
        <header>
            <nav class="navbar navbar-expand-lg bg-light navbar-light">

              <!-- Links -->
              <ul class="navbar-nav">
                <li class="nav-item">
                  <a class="nav-link" href="{{ url('/') }}">Home</a>
                </li>
                @if(!Session::has('user'))
                  <li class="nav-item">
                    <a class="nav-link" href="{{ url('/login') }}">Login</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="{{ url('/signup') }}">Sign Up</a>
                  </li>
                @else
                  @php
                    $user = session('user');
                  @endphp

                  @if($user->is_admin == 1)
                    <li class="nav-item">
                      <a class="nav-link" href="{{ url('/products/add') }}">Add product</a>
                    </li>

                    <li class="nav-item">
                      <a class="nav-link" href="{{ url('/manage/orders') }}">Manage Orders</a>
                    </li>

                  @else
                    <li class="nav-item">
                      <a class="nav-link" href="{{ url('/orders') }}">My Orders</a>
                    </li>
                  @endif
                  <li class="nav-item">
                    <a class="nav-link" href="{{ url('/logout') }}">Logout</a>
                  </li>
                @endif
              </ul>

            </nav>
        </header>

        @yield('content')
    </div>

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
</body>
</html>