<x-master title="Register User">
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
                <form method="POST" action="{{ route('categories.store') }}">
                    @csrf

                    {{-- ✅ Session Error Message --}}
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="row gy-3">

                        {{-- Category Name Field --}}
                        <div class="col-12">
                            <div class="form-floating mb-3">
                                <label for="category_name">{{ __('Category Name') }}</label>

                                <input
                                    type="text"
                                    class="form-control @error('category_name') is-invalid @enderror"
                                    name="category_name"
                                    id="category_name"
                                    placeholder="Category Name"
                                    value="{{ old('category_name') }}"
                                    required>
                                @error('category_name')
                                    <span class="text-danger small"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        {{-- Description Field --}}
                        <div class="col-12">
                            <div class="form-floating mb-3">
                                <label for="description">{{ __('Description') }}</label>

                                <textarea
                                    class="form-control @error('description') is-invalid @enderror"
                                    name="description"
                                    id="description"
                                    placeholder="Enter description"
                                    style="height: 150px;"
                                    required>{{ old('description', $category->description ?? '') }}</textarea>
                                @error('description')
                                    <span class="text-danger small"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                    </div>

                    <div class="card-footer text-right">
                        <button class="btn btn-primary btn-lg" type="submit">{{ __('Add Category') }}</button>
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
</x-master>
