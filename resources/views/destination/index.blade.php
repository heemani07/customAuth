<x-master title="Destination Management">
    <x-top-bar />

    <div class="container mt-4">
        <x-page-header title="Destination Management" route="{{ route('destinations.create') }}" buttonValue="Add Destination" />

        {{-- Show Toastr messages --}}
        @if(session('success'))
            <script>toastr.success("{{ session('success') }}");</script>
        @elseif(session('error'))
            <script>toastr.error("{{ session('error') }}");</script>
        @endif

        {{-- Table --}}
        @if($destinations->count())
            <div class="card shadow-sm">
                <div class="card-body">
                    <table class="table table-bordered align-middle text-center" id="myDataTable">
                        <thead class="table-light">
                            <tr>

                                <th>Name</th>
                                <th>Description</th>
                                <th>Categories</th>
                                <th>Image</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($destinations as $destination)
                                <tr>


                                    {{-- Name --}}
                                    <td>{{ $destination->name }}</td>

                                    {{-- Description --}}
                                    <td>{!! Str::limit($destination->description, 60) !!}</td>

                                    {{-- Categories --}}
                                    <td>
                                        @foreach($destination->categories as $cat)
                                            <span class="badge bg-info text-dark">{{ $cat->category_name }}</span>
                                        @endforeach
                                    </td>
                                     {{-- Image --}}
                                    <td>
                                        @if($destination->image)
                                            <img src="{{ asset('storage/'.$destination->image) }}" alt="Destination Image" width="80" height="60" class="rounded shadow-sm">
                                        @else
                                            <span class="text-muted">No Image</span>
                                        @endif
                                    </td>
                                    {{-- Status --}}
                                    <td>
                                        @if($destination->status === 'active')
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>

                                    {{-- Actions --}}
                                    <td>
                                        {{-- Edit --}}
                                        <a href="{{ route('destinations.edit', $destination->id) }}"
                                           class="btn btn-warning btn-sm me-1" title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        {{-- Delete --}}
                                        <form action="{{ route('destinations.destroy', $destination->id) }}" method="POST" class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm delete-btn" title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="alert alert-info text-center mt-4">No destinations found!</div>
        @endif
    </div>

    {{-- SweetAlert Script --}}
    <script>
        $(document).ready(function () {
            $('.delete-btn').on('click', function (e) {
                e.preventDefault();
                let form = $(this).closest('form');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "This will delete the destination permanently.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
</x-master>
