<x-master title="Edit User">
<x-top-bar/>
        {{-- Show Toastr messages --}}
        @if(session('success'))
            <script>toastr.success("{{ session('success') }}");</script>
        @elseif(session('error'))
            <script>toastr.error("{{ session('error') }}");</script>
        @endif
<!-- <head>


  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
        rel="stylesheet" crossorigin="anonymous">
        <head> -->
            <div class="card">
                <div class="card-header">
       <h2 class="fs-6 fw-normal  text-secondary">Update User</h2>
</div>
     <div class="card-body p-5">
            <form method="POST" action="{{ route('users.update', $user->id) }}">
              @csrf
              @method('PUT')


              @if (session('error'))
                  <div class="alert alert-danger" role="alert">
                      {{ session('error') }}
                  </div>
              @endif

              <div class="row gy-2 overflow-hidden">

                {{-- Name Field --}}
                <div class="col-12">
                  <div class="form-floating mb-3">
                    <label for="name">{{ __('Name') }}</label>

                    <input type="text"
                           class="form-control @error('name') is-invalid @enderror"
                           name="name" id="name"
                           value="{{ old('name', $user->name) }}"
                           placeholder="John Doe" required>
                  </div>
                  @error('name')
                      <span class="text-danger"><strong>{{ $message }}</strong></span>
                  @enderror
                </div>

                {{-- Email Field --}}
                <div class="col-12">
                  <div class="form-floating mb-3">
                    <label for="email">{{ __('Email Address') }}</label>

                    <input type="email"
                           class="form-control @error('email') is-invalid @enderror"
                           name="email" id="email"
                           value="{{ old('email', $user->email) }}"
                           placeholder="name@example.com" required>
                  </div>
                  @error('email')
                      <span class="text-danger"><strong>{{ $message }}</strong></span>
                  @enderror
                </div>

                {{-- Password Field --}}
                <div class="col-12">
                  <div class="form-floating mb-3">
                    <label for="password">{{ __('Password (leave blank to keep current)') }}</label>

                    <input type="password"
                           class="form-control @error('password') is-invalid @enderror"
                           name="password" id="password"
                           placeholder="Password" >
                  </div>
                  @error('password')
                      <span class="text-danger"><strong>{{ $message }}</strong></span>
                  @enderror
                </div>

            {{-- Role --}}
            <div class="col-md-12">
                <label class="form-label fw-semibold">Role</label>
                <select name="role" class="form-control" required>
                    <option value="">Select a Role</option>
                    @foreach ($roles as $id => $name)
                        <option value="{{ $id }}" {{ $userRole && $userRole->id == $id ? 'selected' : '' }}>
                            {{ ucfirst($name) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-12">
    <label class="form-label">Status</label>
    <select name="status" class="form-control" required>
        <option value="">Select status</option>
        <option value="active" {{ $user->status == 'active' ? 'selected' : '' }}>Active</option>
        <option value="inactive" {{ $user->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
    </select>
</div>


                </div>
                </div>


                {{-- Register Button --}}
                <div class="col-12">

                    <div class="card-footer text-right">
                    <button class="btn btn-primary btn-lg" type="submit">
                      {{ __('Update User') }}
                    </button>
                  </div>
                </div>



              </div>
            </form>
            @if (session('success') || session('error'))
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: "{{ session('success') ? 'success' : 'error' }}",
                title: "{{ session('success') ?? session('error') }}",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
        });
    </script>
@endif
</div>
</div>

</x-master>
