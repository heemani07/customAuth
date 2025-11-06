<x-master title="Category Management">
<x-top-bar/>

        {{-- Show Toastr messages --}}
        @if(session('success'))
            <script>toastr.success("{{ session('success') }}");</script>
        @elseif(session('error'))
            <script>toastr.error("{{ session('error') }}");</script>
        @endif
    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                <h2 class="fs-6 fw-normal text-secondary mb-0">Add Category</h2>
            </div>

            <div class="card-body">

            <form method="POST" action="{{ route('categories.update', $category->id) }}">
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
                           name="category_name" id="category_name"
                           value="{{ old('category_name', $category->category_name) }}"
                           placeholder="John Doe" required>
                    <label for="category_name">{{ __('Name') }}</label>
                  </div>
                  @error('name')
                      <span class="text-danger"><strong>{{ $message }}</strong></span>
                  @enderror
                </div>

                {{-- Email Field --}}
<div class="col-12">
  <div class="form-floating mb-3">
    <textarea
      class="form-control @error('description') is-invalid @enderror"
      name="description"
      id="description"
      placeholder="Enter description" style="height:300px;"
      required>{{ old('description', $category->description ?? '') }}</textarea>
    <label for="description">{{ __('Description') }}</label>
  </div>

  @error('description')
    <span class="text-danger"><strong>{{ $message }}</strong></span>
  @enderror
</div>
</div>
</div>



                {{-- Register Button --}}
                <div class="card-footer  text-right">

                    <button class="btn btn-primary btn-lg" type="submit">
                      {{ __('Update Category') }}
                    </button>

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
      </div>
    </div>

</x-master>
