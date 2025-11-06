<x-master title="Add Package">
    <x-top-bar/>
<style>
    #uppy { min-height: 350px; }
</style>
<div class="container mt-4">
    <h2 class="mb-4">Create Trip Package</h2>

    <form action="{{ route('trip-packages.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Destination --}}
        <div class="mb-3">
            <label>Destination</label>
            <select name="destination_id" class="form-control" required>
                <option value="">Select Destination</option>
                @foreach($destinations as $dest)
                    <option value="{{ $dest->id }}">{{ $dest->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Category --}}
        <div class="mb-3">
            <label>Category</label>
            <select name="category_id" class="form-control" required>
                <option value="">Select Category</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Title --}}
        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        {{-- Description --}}
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="summernote form-control" rows="3"></textarea>
        </div>

<div class="mb-3">
    <label class="form-label">Inclusions</label>

    <div id="inclusions-wrapper">
        <div class="input-group mb-2 inclusion-item">
            <input type="text" name="inclusions[]" class="form-control" placeholder="Enter inclusion">
            <button type="button" class="btn btn-outline-danger remove-inclusion" style="display:none;">&minus;</button>
        </div>
    </div>

    <button type="button" class="btn btn-outline-primary mt-2" id="add-inclusion">+ Add Inclusion</button>
</div>


        {{-- Overview --}}
        <div class="mb-3">
            <label>Overview</label>
            <textarea name="overview" class="summernote form-control"></textarea>
        </div>

        {{-- Terms and Conditions --}}
        <div class="mb-3">
            <label>Terms & Conditions</label>
            <textarea name="terms_and_conditions" class="summernote form-control"></textarea>
        </div>

        {{-- Itinerary --}}
        <div class="mb-3">
            <label>Itinerary</label>
            <textarea name="itinerary" class="summernote form-control"></textarea>
        </div>

        {{-- Uppy File Upload --}}
        <div class="mb-3">
            <label>Upload Images</label>
            <div id="uppy"></div>
        </div>

        {{-- Hidden inputs will be added here dynamically by Uppy --}}

        {{-- Status --}}
        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Save Package</button>
    </form>
</div>

@push('scripts')
<script>
$(document).ready(function () {
    console.log("✅ Uppy initialization started");

    // Initialize Summernote
    $('.summernote').summernote({
        height: 200,
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['link', 'picture']],
            ['view', ['fullscreen', 'codeview']]
        ]
    });

    // ✅ Initialize Uppy correctly for v3+
    const uppy = new Uppy.Uppy({
        restrictions: {
            maxNumberOfFiles: 10,
            allowedFileTypes: ['image/*']
        },
        autoProceed: true
    });

    uppy.use(Uppy.Dashboard, {
        inline: true,
        target: '#uppy',
        proudlyDisplayPoweredByUppy: false,
        showProgressDetails: true,
        height: 350
    });

    uppy.use(Uppy.XHRUpload, {
        endpoint: "{{ route('trip-packages.upload.image') }}",
        formData: true,
        fieldName: 'file',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    });

    uppy.on('upload-success', (file, response) => {
        console.log('✅ Uploaded:', response.body.filename);
        $('<input>').attr({
            type: 'hidden',
            name: 'uploaded_images[]',
            value: response.body.filename
        }).appendTo('form');
    });

    uppy.on('upload-error', (file, error) => {
        console.error('❌ Upload error:', error);
    });
});
</script>
@endpush
<script>
    $(document).ready(function () {

        // Add new inclusion at the bottom
        $('#add-inclusion').click(function () {
            let newField = `
                <div class="input-group mb-2 inclusion-item">
                    <input type="text" name="inclusions[]" class="form-control" placeholder="Enter inclusion">
                    <button type="button" class="btn btn-outline-danger remove-inclusion">&minus;</button>
                </div>
            `;
            $('#inclusions-wrapper').append(newField);
        });

        // Remove inclusion field
        $(document).on('click', '.remove-inclusion', function () {
            $(this).closest('.inclusion-item').remove();
        });

    });
</script>


</x-master>


