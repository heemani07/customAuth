<x-master title="Trip Package">
    <x-top-bar/>

<div class="container">
    <x-page-header title="Package Management" route="{{ route('trip-packages.create') }}" buttonValue="package" />

    {{-- Toastr Alerts --}}
    @if (session('success') || session('error') || session('info'))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    background: '#fff',
                    customClass: { popup: 'shadow-lg rounded-3' },
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer);
                        toast.addEventListener('mouseleave', Swal.resumeTimer);
                    }
                });

                @if (session('success'))
                    Toast.fire({ icon: 'success', title: @json(session('success')) });
                @endif

                @if (session('error'))
                    Toast.fire({ icon: 'error', title: @json(session('error')) });
                @endif

                @if (session('info'))
                    Toast.fire({ icon: 'info', title: @json(session('info')) });
                @endif
            });
        </script>
    @endif


    {{-- Packages Table --}}
    <table class="table table-bordered align-middle shadow-sm">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Destination</th>
                <th>Category</th>
                <th>Status</th>
                <th width="140">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($packages as $index => $package)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $package->title }}</td>
                <td>{{ $package->destination->name ?? '-' }}</td>
                <td>{{ $package->category->category_name ?? '-' }}</td>
                <td>
                    <span class="badge bg-{{ $package->status == 'active' ? 'success' : 'secondary' }}">
                        {{ ucfirst($package->status) }}
                    </span>
                </td>
                <td class="text-center">
                    {{-- Edit --}}
                    <a href="{{ route('trip-packages.edit', $package->id) }}"
                      class="btn btn-warning btn-sm me-2"
                       title="Edit">
                        <i class="bi bi-pencil-square"></i>
                    </a>

                    {{-- Delete --}}
                    <form action="{{ route('trip-packages.destroy', $package->id) }}"
                          method="POST"
                          class="d-inline delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="button"
                                class="btn btn-danger btn-sm delete-btn"
                                title="Delete">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center">No packages found.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-3">
        {{ $packages->links() }}
    </div>
</div>


{{-- SweetAlert Delete Confirmation --}}

<script>
document.addEventListener("DOMContentLoaded", function() {
    const deleteForms = document.querySelectorAll('.delete-form');

    deleteForms.forEach(form => {
        const deleteBtn = form.querySelector('.delete-btn');

        deleteBtn.addEventListener('click', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Are you sure?',
                text: "This will permanently delete the package.",
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
});
</script>

{{-- FontAwesome Icons --}}
</x-master>
