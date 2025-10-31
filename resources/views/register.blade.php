<x-master title="register user">
    <x-top-bar/>
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
        <select name="role" class="form-select" required>
            <option value="">Select a Role</option>
            @foreach ($roles as $id => $name)
                <option value="{{ $id }}">{{ ucfirst($name) }}</option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Register User</button>
</form>
</x-master>
