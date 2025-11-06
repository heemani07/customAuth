<x-master title="Destination">
    <x-top-bar/>
    <style>
.note-editor.note-frame {
    border-radius: 10px;
    border: 1px solid #ced4da;
}
</style>

    <div class="container">
        <div class="card">


        <div class="card-header bg-light">
            <h4 class="mb-0">Add New Destination</h4>
        </div>

        <div class="card-body p-4">
         <form method="POST" action="{{ route('destinations.store') }}" enctype="multipart/form-data">

                @csrf

                {{-- Destination Name --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Destination Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Enter destination name" required>
                </div>
                                                @error('name')
                                    <span class="text-danger small"><strong>{{ $message }}</strong></span>
                                @enderror

                {{-- Description with Summernote --}}
                <div class="mb-3">
                    <label for="description" class="form-label fw-semibold">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="5" required>{{ old('description') }}</textarea>
                    @error('description')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>



                {{-- Image Upload --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Destination Image</label>
                    <input type="file" name="image" class="form-control" accept="image/*" required>
                </div>
                                                @error('image')
                                    <span class="text-danger small"><strong>{{ $message }}</strong></span>
                                @enderror

                {{-- Category Multi-select --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Select Categories</label>
                        <select name="categories[]" class="form-control" multiple required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ ucfirst($category->category_name) }}</option>
                            @endforeach
                        </select>
                    <small class="text-muted">Hold Ctrl (or Command) to select multiple.</small>
                </div>
                                @error('category_ids')
                                    <span class="text-danger small"><strong>{{ $message }}</strong></span>
                                @enderror
                {{-- Status Dropdown --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Status</label>
                    <select name="status" class="form-control" required>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                                                @error('status')
                                    <span class="text-danger small"><strong>{{ $message }}</strong></span>
                                @enderror

                {{-- Submit Button --}}
                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-primary px-4">Save Destination</button>
                </div>
            </form>
        </div>
    </div>
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
<script>
    $(document).ready(function() {
        $('#description').summernote({
            placeholder: 'Enter description here...',
            tabsize: 2,
            height: 200,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['fontsize', 'color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link', 'picture']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });

        // Initialize Select2 also
        $('.select2').select2({
            placeholder: "Select categories",
            allowClear: true
        });
    });
</script>


</x-master>
