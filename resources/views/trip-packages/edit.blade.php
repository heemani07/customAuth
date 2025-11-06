<x-master title="Update Package">
<x-top-bar/>
<div class="container">
    <h2>Edit Trip Package</h2>

    {{-- UPDATE FORM --}}
    <form action="{{ route('trip-packages.update', $tripPackage->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Destination --}}
        <div class="mb-3">
            <label>Destination</label>
            <select name="destination_id" class="form-control" required>
                @foreach($destinations as $dest)
                    <option value="{{ $dest->id }}" {{ $tripPackage->destination_id == $dest->id ? 'selected' : '' }}>
                        {{ $dest->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Category --}}
        <div class="mb-3">
            <label>Category</label>
            <select name="category_id" class="form-control" required>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ $tripPackage->category_id == $cat->id ? 'selected' : '' }}>
                        {{ $cat->category_name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Title --}}
        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" value="{{ $tripPackage->title }}" class="form-control" required>
        </div>

        {{-- Description --}}
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="summernote form-control">{{ $tripPackage->description }}</textarea>
        </div>

        {{-- Inclusions --}}
@php
    // Inclusions always stored as array in DB (model cast)
    $existingInclusions = $tripPackage->inclusions ?? [];
@endphp

<div class="mb-3">
    <label class="form-label">Inclusions</label>

    <div id="inclusions-wrapper">
        @forelse($existingInclusions as $inclusion)
            <div class="input-group mb-2 inclusion-item">
                <input type="text" name="inclusions[]" class="form-control" value="{{ $inclusion }}" placeholder="Enter inclusion">
                <button type="button" class="btn btn-outline-danger remove-inclusion">&minus;</button>
            </div>
        @empty
            <div class="input-group mb-2 inclusion-item">
                <input type="text" name="inclusions[]" class="form-control" placeholder="Enter inclusion">
                <button type="button" class="btn btn-outline-danger remove-inclusion" style="display:none;">&minus;</button>
            </div>
        @endforelse
    </div>

    <button type="button" class="btn btn-outline-primary mt-2" id="add-inclusion">+ Add Inclusion</button>
</div>


        {{-- Overview --}}
        <div class="mb-3">
            <label>Overview</label>
            <textarea name="overview" id="overview" class="summernote form-control">{{ $tripPackage->overview }}</textarea>
        </div>

        {{-- Terms --}}
        <div class="mb-3">
            <label>Terms & Conditions</label>
            <textarea name="terms_and_conditions" class="summernote form-control">{{ $tripPackage->terms_and_conditions }}</textarea>
        </div>

        {{-- Itinerary --}}
        <div class="mb-3">
            <label>Itinerary</label>
            <textarea name="itinerary" class="summernote form-control">{{ $tripPackage->itinerary }}</textarea>
        </div>

        {{-- Upload Images --}}
<div id="uppy" class="mb-3"></div>


        {{-- Status --}}
        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="active" {{ $tripPackage->status == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ $tripPackage->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Update Package</button>
    </form>

    {{-- EXISTING IMAGES (OUTSIDE MAIN FORM) --}}
    @if($tripPackage->images->count())
    <div class="mt-4">
        <label>Existing Images</label>
        <div class="row">
            @foreach($tripPackage->images as $img)
                <div class="col-md-2 mb-3 position-relative">
                    <img src="{{ asset('storage/'.$img->image) }}" class="img-fluid rounded shadow-sm border" style="height:100px; width:100%; object-fit:cover;">

                    {{-- Delete Button --}}
                    <form action="{{ route('trip-packages.images.destroy', $img->id) }}" method="POST"
                          style="position:absolute; top:5px; right:10px; z-index:10;"
                          onsubmit="return confirm('Are you sure you want to delete this image?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" style="border-radius:50%; padding:4px 7px;">
                            <i class="fa fa-trash"></i>
                        </button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize Summernote
    $('.summernote').summernote({
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

    console.log('✅ Uppy initialization started');

    // Initialize Uppy
    const uppy = new Uppy.Uppy({
        restrictions: {
            maxNumberOfFiles: 10,
            allowedFileTypes: ['image/*']
        },
        autoProceed: true
    });

    // Dashboard plugin
    uppy.use(Uppy.Dashboard, {
        inline: true,
        target: '#uppy',
        proudlyDisplayPoweredByUppy: false,
        showProgressDetails: true,
        height: 350
    });

    // XHR Upload plugin
    uppy.use(Uppy.XHRUpload, {
        endpoint: "{{ route('trip-packages.upload.image') }}",
        formData: true,
        fieldName: 'file',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    });

    // On success
    uppy.on('upload-success', (file, response) => {
        console.log('✅ Uploaded:', response.body.filename);
        $('<input>').attr({
            type: 'hidden',
            name: 'uploaded_images[]',
            value: response.body.filename
        }).appendTo('form');
    });

    // On error
    uppy.on('upload-error', (file, error) => {
        console.error('❌ Upload error:', error);
    });
});
</script>
<script>
    $(document).ready(function () {

        // ✅ Add new inclusion field at the bottom
        $('#add-inclusion').click(function () {
            const newField = `
                <div class="input-group mb-2 inclusion-item">
                    <input type="text" name="inclusions[]" class="form-control" placeholder="Enter inclusion">
                    <button type="button" class="btn btn-outline-danger remove-inclusion">&minus;</button>
                </div>
            `;
            $('#inclusions-wrapper').append(newField);
        });

        // ✅ Remove an inclusion field
        $(document).on('click', '.remove-inclusion', function () {
            $(this).closest('.inclusion-item').fadeOut(200, function () {
                $(this).remove();
            });
        });

    });
</script>

@endpush

</x-master>
