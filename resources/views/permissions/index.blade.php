<x-master title="Role and Permission Management">
    <x-top-bar />

<style>
button {
    cursor: pointer;
    border: none;
    font-size: large;
    color: gray;
}
.accordion-header {
    display: flex;
    justify-content: space-between;
    align-items: left;
}
.delete-role-btn {
    background: none;
    border: none;
    color: #dc3545;
    font-size: 18px;
    transition: color 0.2s;
}
.delete-role-btn:hover {
    color: #b02a37;
}
</style>

<!-- Add Role Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold" id="exampleModalLabel">Add New Role</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="addRoleForm">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="roleName" class="col-form-label fw-semibold">Role Name</label>
                        <input type="text" class="form-control" id="roleName" name="name" placeholder="Enter role name" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Role</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Header -->
<div class="card-header d-flex justify-content-between align-items-center mb-3">
    <h2 class="mb-0 fw-bold">Role Permission Management</h2>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        + Add Role
    </button>
</div>

<!-- Success Message -->
@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<!-- Roles + Permissions -->
<form method="POST" action="{{ route('permissions.update') }}">
    @csrf
    <div class="accordion" id="rolesAccordion">
        @foreach ($roles as $role)
            <div class="accordion-item border">
                <h2 class="accordion-header" id="heading{{ $loop->index }}">
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <button class="accordion-button collapsed fw-semibold text-capitalize bg-light"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#collapse{{ $loop->index }}"
                                aria-expanded="false"
                                aria-controls="collapse{{ $loop->index }}">
                            {{ ucfirst($role->name) }}
                        </button>
                        <button type="button"
                                class="delete-role-btn ms-2"
                                data-role-id="{{ $role->id }}"
                                title="Delete Role">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </h2>

                <div id="collapse{{ $loop->index }}"
                     class="accordion-collapse collapse"
                     aria-labelledby="heading{{ $loop->index }}"
                     data-bs-parent="#rolesAccordion">
                    <div class="accordion-body bg-white">
                        <div class="row g-3">
                            @foreach ($modules as $module => $actions)
                                <div class="col-md-6 mb-3">
                                    <div class="border rounded p-3 h-100">
                                        <div class="d-flex justify-content-between align-items-left mb-2">
                                            <h6 class="fw-bold text-capitalize m-0">{{ $module }}</h6>
                                            <div class="form-check">
                                                <input class="form-check-input select-all"
                                                       type="checkbox"
                                                       id="selectAll_{{ $role->id }}_{{ $module }}"
                                                       data-module="{{ $module }}"
                                                       data-role="{{ $role->id }}">
                                                <label class="form-check-label small"
                                                       for="selectAll_{{ $role->id }}_{{ $module }}">
                                                    Select All
                                                </label>
                                            </div>
                                        </div>

                                        <div class="row">
                                            @foreach ($actions as $action)
                                                @php
                                                    $permName = "{$action} {$module}";
                                                    $permission = $permissions->firstWhere('name', $permName);
                                                @endphp
                                                @if ($permission)
                                                    <div class="col-6 mb-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input perm-checkbox"
                                                                   type="checkbox"
                                                                   name="permissions[{{ $role->id }}][]"
                                                                   id="perm_{{ $role->id }}_{{ $permission->id }}"
                                                                   value="{{ $permission->name }}"
                                                                   data-module="{{ $module }}"
                                                                   data-role="{{ $role->id }}"
                                                                   {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="perm_{{ $role->id }}_{{ $permission->id }}">
                                                                {{ ucfirst($action) }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-end mt-4">
        <button class="btn btn-primary px-4" type="submit">Save All Permissions</button>
    </div>
</form>

{{-- JavaScript --}}
<script>
$(document).ready(function () {

    // --- Handle Add Role ---
    $('#addRoleForm').on('submit', function (e) {
        e.preventDefault();
        const formData = $(this).serialize();
        const modal = $('#exampleModal');

        $.ajax({
            url: "{{ route('roles.store') }}",
            type: "POST",
            data: formData,
            success: function (response) {
                if (response.success) {
                    modal.modal('hide');
                    $('#roleName').val('');
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: response.message,
                        showConfirmButton: false,
                        timer: 2000
                    });
                    setTimeout(() => location.reload(), 2000);
                }
            },
            error: function (xhr) {
                const errors = xhr.responseJSON?.errors;
                Swal.fire('Error', errors?.name?.[0] || 'Something went wrong', 'error');
            }
        });
    });

    // --- Handle Delete Role ---
    $(document).on('click', '.delete-role-btn', function () {
        const roleId = $(this).data('role-id');

        Swal.fire({
            title: 'Are you sure?',
            text: "This will permanently delete this role.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('roles') }}/" + roleId,
                    type: 'DELETE',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function (response) {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: response.message || 'Role deleted successfully',
                            showConfirmButton: false,
                            timer: 2000
                        });
                        setTimeout(() => location.reload(), 2000);
                    },
                    error: function () {
                        Swal.fire('Failed!', 'Unable to delete the role.', 'error');
                    }
                });
            }
        });
    });

    // --- Checkbox Logic (Select All) ---
    function getChildren(module, role) {
        return $(`.perm-checkbox[data-module="${module}"][data-role="${role}"]`);
    }

    $('.select-all').each(function () {
        const module = $(this).data('module');
        const role = $(this).data('role');
        const children = getChildren(module, role);
        const allChecked = children.length && children.filter(':checked').length === children.length;
        $(this).prop('checked', allChecked);
    });

    $('.perm-checkbox').on('change', function () {
        const module = $(this).data('module');
        const role = $(this).data('role');
        const children = getChildren(module, role);
        const selectAll = $(`#selectAll_${role}_${module}`);
        const total = children.length;
        const checked = children.filter(':checked').length;
        selectAll.prop('checked', checked === total);
        selectAll.prop('indeterminate', checked > 0 && checked < total);
    });

    $('.select-all').on('change', function () {
        const module = $(this).data('module');
        const role = $(this).data('role');
        const checked = $(this).is(':checked');
        getChildren(module, role).prop('checked', checked).trigger('change');
        $(this).prop('indeterminate', false);
    });
});
</script>

</x-master>
