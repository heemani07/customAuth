<x-master title="Edit Destination">
    <x-top-bar />

    <div class="container mt-4">
        <x-page-header title="Edit Destination" route="{{ route('destinations.index') }}" buttonValue="Back to List" />

        {{-- Show Toastr messages --}}
        @if(session('success'))
            <script>toastr.success("{{ session('success') }}");</script>
        @elseif(session('error'))
            <script>toastr.error("{{ session('error') }}");</script>
        @endif

        <div class="card shadow-sm p-4">
            <form action="{{ route('destinations.update', $destination->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Name --}}
                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold">Destination Name</label>
                    <input type="text" name="name" id="name" class="form-control"
                           value="{{ old('name', $destination->name) }}" required>
                    @error('name')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Description --}}
                <div class="mb-3">
                    <label for="description" class="form-label description fw-semibold">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="3" required>{{ old('description', $destination->description) }}</textarea>
                    @error('description')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Categories --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Select Categories</label>
                    <select name="categories[]" id="editCategorySelect" class="form-control select2" multiple required>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ in_array($category->id, old('categories', $destination->categories->pluck('id')->toArray())) ? 'selected' : '' }}>
                                {{ ucfirst($category->category_name) }}
                            </option>
                        @endforeach
                    </select>
                    <small class="text-muted">You can select multiple categories.</small>
                    @error('categories')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Image --}}
                <div class="mb-3">
                    <label for="image" class="form-label fw-semibold">Destination Image</label>
                    <input type="file" name="image" id="image" class="form-control">

                    @if($destination->image)
                        <div class="mt-2">
                            <img src="{{ asset('storage/'.$destination->image) }}" alt="Current Image" width="200" class="rounded shadow-sm">
                            <p class="text-muted small mt-1">Current image</p>
                        </div>
                    @endif

                    @error('image')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Status --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Status</label>
                    <select name="status" class="form-control" required>
                        <option value="active" {{ old('status', $destination->status) === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $destination->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Submit Button --}}
                <div class="text-end">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save"></i> Update Destination
                    </button>
                </div>
            </form>
        </div>
    </div>

{{-- ✅ Keep alert toast code conditional --}}
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

{{-- ✅ Always run this script (moved outside condition) --}}
<script>
    $(document).ready(function() {
        console.log('Initializing Summernote...'); // debug

        $('#description').summernote({
            placeholder: 'Enter destination description...',
            tabsize: 2,
            height: 200,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['fontsize', 'color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link', 'picture']],
                ['view', ['fullscreen', 'codeview']]
            ]
        });

        $('.select2').select2({
            placeholder: "Select categories",
            allowClear: true
        });
    });
</script>
</x-master>
