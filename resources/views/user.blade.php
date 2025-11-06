<x-master title="User Management">
    <x-top-bar/>
<style>
    .badge{
        color:snow

    }
</style>

<div class="container">
 <x-page-header title="User Management" route="{{ route('userRegister')}}"  buttonValue="User"/>



    @if ($users->count())
        <table class="table table-bordered" id="myDataTable">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
<td>
    <div class="mb-3">
        <select name="role" class="form-control user-role-select" data-user-id="{{ $user->id }}">
            <option value="">Select a Role</option>
            @foreach ($roles as $role)
                <option value="{{ $role['id'] }}"
                    {{ $user->roles->contains('id', $role['id']) ? 'selected' : '' }}>
                    {{ ucfirst($role['name']) }}
                </option>
            @endforeach
        </select>
    </div>
</td>
<td class="text-center">
    @if ($user->status == 'active')
        <span class="badge bg-success">Active</span>
    @elseif ($user->status == 'inactive')
        <span class="badge bg-danger">Inactive</span>
    @else
        <span class="badge bg-secondary">{{ ucfirst($user->status) }}</span>
    @endif
</td>

<td class="text-center">
    {{-- Edit Button --}}
    <a href="{{ route('users.edit', $user->id) }}"
       class="btn btn-warning btn-sm me-2"
       title="Edit">
        <i class="bi bi-pencil-square"></i>
    </a>

    {{-- Delete Button --}}
    <form action="{{ route('users.destroy', $user->id) }}"
          method="POST"
          class="d-inline delete-form">
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
        <p>No Users available.</p>
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


// Role change via AJAX
$('.user-role-select').on('change', function () {
    let roleId = $(this).val();
    let userId = $(this).data('user-id');

    $.ajax({
        url: "{{ route('users.updateRole') }}",
        method: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            user_id: userId,
            role_id: roleId
        },
        success: function (response) {
            if (response.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Updated!',
                    text: response.message,
                    timer: 1500,
                    showConfirmButton: false
                });
            } else {
                Swal.fire('Error', response.message, 'error');
            }
        },
        error: function () {
            Swal.fire('Error', 'Something went wrong.', 'error');
        }
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





