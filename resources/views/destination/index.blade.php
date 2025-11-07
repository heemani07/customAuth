<x-master title="Destination Management">
    <x-top-bar />

    <div class="container mt-4">
        <!-- <x-page-header title="Destination Management" route="{{ route('destinations.create') }}" buttonValue="Destination" /> -->
<x-page-header
    title="Destination Management"
    route="{{ route('destinations.create') }}"
    :buttonValue="auth()->user()->can('create destination') ? 'Destination' : null"
/>
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
@canany(['edit destination','delete destination'])

                                <th>Actions</th>
@endcanany

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
@canany(['edit destination','delete destination'])

                                    {{-- Actions --}}
                                    <td>
                                        <a href="{{ route('destinations.edit', $destination->id) }}" class="btn btn-warning btn-sm me-1" title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <form action="{{ route('destinations.destroy', $destination->id) }}" method="POST" class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm delete-btn" title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
@endcanany

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
        // Initialize SweetAlert Toast
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2500,
            timerProgressBar: true,
        });

        $(document).ready(function () {
            // Delete confirmation
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
<script>
    const successMsg = @json(session('success'));
    const errorMsg = @json(session('error'));

    if (successMsg) {
        Toast.fire({
            icon: 'success',
            title: successMsg
        });
    } else if (errorMsg) {
        Toast.fire({
            icon: 'error',
            title: errorMsg
        });
    }
</script>


</x-master>
