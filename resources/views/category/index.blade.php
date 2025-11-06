<x-master title="Category Management">
    <x-top-bar/>



<div class="container">

 <!-- <x-page-header title="Category Management" route="{{ route('categories.create')}}"  buttonValue="Category"/> -->
  <x-page-header
    title="Category Management"
    route="{{ route('categories.create') }}"
    :buttonValue="auth()->user()->can('create category') ? 'Category' : null.'category'"
/>

    @if ($categories->count())
        <table class="table table-bordered" id="myDataTable">
            <thead>
                <tr>
                    <th>Category Name</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                <tr>
                    <td>{{ $category->category_name }}</td>
                    <td>{{ $category->description }}</td>

<td class="text-center">
    {{-- Edit Button --}}
    <a href="{{ route('categories.edit', $category->id) }}"
       class="btn btn-warning btn-sm me-2" title="Edit">
        <i class="bi bi-pencil-square"></i>
    </a>

    {{-- Delete Button --}}
    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="d-inline delete-form">
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
    @else
        <p>No Categories available.</p>
    @endif
</div>


<script>
$(document).ready(function () {
    $('.delete-btn').on('click', function (e) {
        e.preventDefault();
        let form = $(this).closest('form');

        Swal.fire({
            title: 'Are you sure?',
            text: "This action cannot be undone!",
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
</x-master>



