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
        .edit-role-btn {
            background: none;
            border: none;
            color: #0d6efd;
            font-size: 18px;
            margin-right: 8px;
        }
        .edit-role-btn:hover {
            color: #084298;
        }
    </style>

    @php
        $canManage = auth()->user()->canany(['create role', 'edit role', 'delete role']);
        $readOnly = !$canManage;
    @endphp

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

    <!-- Edit Role Modal -->
    <div class="modal fade" id="editRoleModal" tabindex="-1" aria-labelledby="editRoleLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
          <div class="modal-header bg-primary text-white">
            <h5 class="modal-title fw-bold" id="editRoleLabel">Edit Role</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form id="editRoleForm">
            @csrf
            <input type="hidden" id="editRoleId">
            <div class="modal-body">
              <div class="form-group">
                <label for="editRoleName" class="col-form-label fw-semibold">Role Name</label>
                <input type="text" class="form-control" id="editRoleName" placeholder="Enter new role name" required>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-primary">Update Role</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Header -->
    <div class="card-header d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0 fw-bold">Role Permission Management</h2>

        @can('create role')
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                + Add Role
            </button>
        @endcan
    </div>

    <!-- Roles & Permissions -->
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

                            @if($canManage)
                                <div class="d-flex align-items-center">
                                    @can('edit role')
                                        <button type="button"
                                                class="edit-role-btn"
                                                data-role-id="{{ $role->id }}"
                                                data-role-name="{{ $role->name }}"
                                                title="Edit Role">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    @endcan
                                    @can('delete role')
                                        <button type="button"
                                                class="delete-role-btn"
                                                data-role-id="{{ $role->id }}"
                                                title="Delete Role">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    @endcan
                                </div>
                            @endif
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
                                                        data-role="{{ $role->id }}"
                                                        @if($readOnly) disabled @endif>
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
                                                                    {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}
                                                                    @if($readOnly) disabled @endif>
                                                                <label class="form-check-label"
                                                                    for="perm_{{ $role->id }}_{{ $permission->id }}">
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
            <button class="btn btn-primary px-4" type="submit" @if($readOnly) disabled @endif>
                Save All Permissions
            </button>
        </div>
    </form>

    {{-- JS --}}
 <script>
        $(document).ready(function () {

        $('#addRoleForm').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
        url: "{{ route('roles.store') }}",
        type: "POST",
        data: $(this).serialize(),
        success: function (res) {
        if (res.success) {
            $('#exampleModal').modal('hide');
            $('#roleName').val('');
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: 'Role added successfully!',
                showConfirmButton: false,
                timer: 1500
            });

            // Dynamically append the new role (optional)
            setTimeout(() => location.reload(), 800);
        }
        },
        error: (xhr) =>
        Swal.fire('Error', xhr.responseJSON?.errors?.name?.[0] || 'Failed to add role', 'error')
        });
        });

        // === Edit Role ===
        let currentRoleId = null;
        $(document).on('click', '.edit-role-btn', function () {
        currentRoleId = $(this).data('role-id');
        $('#editRoleName').val($(this).data('role-name'));
        $('#editRoleModal').modal('show');
        });

        $('#editRoleForm').on('submit', function (e) {
        e.preventDefault();
        const newName = $('#editRoleName').val().trim();
        if (!newName) return Swal.fire('Error', 'Role name cannot be empty', 'error');

        $.ajax({
        url: `{{ url('roles') }}/${currentRoleId}`,
        type: "POST",
        data: {
        _token: '{{ csrf_token() }}',
        _method: 'PUT',
        name: newName
        },
        success: function (res) {
        if (res.success) {
            $('#editRoleModal').modal('hide');


            $(`button[data-role-id="${currentRoleId}"]`)
                .closest('.accordion-header')
                .find('.accordion-button')
                .text(newName);


            $(`.edit-role-btn[data-role-id="${currentRoleId}"]`).data('role-name', newName);

            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: 'Role updated successfully!',
                showConfirmButton: false,
                timer: 1500
            });
        }
        },
        error: () => Swal.fire('Error', 'Failed to update role', 'error')
        });
        });

        $(document).on('click', '.delete-role-btn', function () {
        const roleId = $(this).data('role-id');
        const currentUserRoleId = "{{ auth()->user()->roles->first()->id ?? '' }}";
        if (roleId == currentUserRoleId) {
        Swal.fire({
        icon: 'warning',
        title: 'Action not allowed',
        text: 'You cannot delete your own role.',
        showConfirmButton: true
        });
        return;
        }
        Swal.fire({
        title: 'Are you sure?',
        text: 'This will permanently delete this role.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
        }).then(result => {
        if (result.isConfirmed) {
        $.ajax({
            url: `{{ url('roles') }}/${roleId}`,
            type: "DELETE",
            data: { _token: '{{ csrf_token() }}' },
            success: function (res) {
                if (res.success) {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Role deleted!',
                        showConfirmButton: false,
                        timer: 1200
                    });

                    $(`button[data-role-id="${roleId}"]`).closest('.accordion-item').remove();
                }
            },
            error: () => Swal.fire('Error', 'Failed to delete role.', 'error')
        });
        }
        });
        });

        function getChildren(module, role) {
        return $(`.perm-checkbox[data-module="${module}"][data-role="${role}"]`);
        }

        $('.select-all').each(function () {
        const module = $(this).data('module');
        const role = $(this).data('role');
        const children = getChildren(module, role);
        $(this).prop('checked', children.length && children.filter(':checked').length === children.length);
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
        getChildren(module, role).prop('checked', $(this).is(':checked')).trigger('change');
        $(this).prop('indeterminate', false);
        });
        });
        </script>


</x-master>
