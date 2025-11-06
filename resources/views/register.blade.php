<x-master title="register user">
    <x-top-bar/>
            {{-- Show Toastr messages --}}
        @if(session('success'))
            <script>toastr.success("{{ session('success') }}");</script>
        @elseif(session('error'))
            <script>toastr.error("{{ session('error') }}");</script>
        @endif
                <div class="card">
                <div class="card-header">
       <h2 class="fs-6 fw-normal  text-secondary">Add User</h2>
</div>
     <div class="card-body p-5">
<form method="POST" action="{{ route('user.store') }}">
    @csrf

    <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" name="name" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Confirm Password</label>
        <input type="password" name="password_confirmation" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Role</label>
        <select name="role" class="form-control" required>
            <option value="">Select a Role</option>
            @foreach ($roles as $id => $name)
                <option value="{{ $id }}">{{ ucfirst($name) }}</option>
            @endforeach
        </select>

    </div>
<div class="mb-3">
    <label class="form-label">Status</label>
    <select name="status" class="form-control" required>
        <option value="">Select status</option>
        <option value="active" >Active</option>
        <option value="inactive">Inactive</option>
    </select>
</div>

<div class="card-footer text-right">
    <button type="submit" class="btn btn-primary">Register User</button>
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
