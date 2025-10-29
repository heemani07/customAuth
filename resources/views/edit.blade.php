<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>User Registration | Custom Auth</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
        rel="stylesheet" crossorigin="anonymous">

  <style>
    body {
      background: #F8F9FA;
    }
  </style>
</head>
<body>

<section class="bg-light py-3 py-md-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
        <div class="card border border-light-subtle rounded-3 shadow-sm">
          <div class="card-body p-3 p-md-4 p-xl-5">

            <h2 class="fs-6 fw-normal text-center text-secondary mb-4">Update User</h2>

            <form method="POST" action="{{ route('users.update', $user->id) }}">
              @csrf
              @method('PUT')

              {{-- ✅ Session Error Message --}}
              @if (session('error'))
                  <div class="alert alert-danger" role="alert">
                      {{ session('error') }}
                  </div>
              @endif

              <div class="row gy-2 overflow-hidden">

                {{-- Name Field --}}
                <div class="col-12">
                  <div class="form-floating mb-3">
                    <input type="text"
                           class="form-control @error('name') is-invalid @enderror"
                           name="name" id="name"
                           value="{{ old('name', $user->name) }}"
                           placeholder="John Doe" required>
                    <label for="name">{{ __('Name') }}</label>
                  </div>
                  @error('name')
                      <span class="text-danger"><strong>{{ $message }}</strong></span>
                  @enderror
                </div>

                {{-- Email Field --}}
                <div class="col-12">
                  <div class="form-floating mb-3">
                    <input type="email"
                           class="form-control @error('email') is-invalid @enderror"
                           name="email" id="email"
                           value="{{ old('email', $user->email) }}"
                           placeholder="name@example.com" required>
                    <label for="email">{{ __('Email Address') }}</label>
                  </div>
                  @error('email')
                      <span class="text-danger"><strong>{{ $message }}</strong></span>
                  @enderror
                </div>

                {{-- Password Field --}}
                <div class="col-12">
                  <div class="form-floating mb-3">
                    <input type="password"
                           class="form-control @error('password') is-invalid @enderror"
                           name="password" id="password"
                           placeholder="Password" >
                    <label for="password">{{ __('Password (leave blank to keep current)') }}</label>
                  </div>
                  @error('password')
                      <span class="text-danger"><strong>{{ $message }}</strong></span>
                  @enderror
                </div>



                {{-- Register Button --}}
                <div class="col-12">
                  <div class="d-grid my-3">
                    <button class="btn btn-primary btn-lg" type="submit">
                      {{ __('Update User') }}
                    </button>
                  </div>
                </div>



              </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>

</body>
</html>
