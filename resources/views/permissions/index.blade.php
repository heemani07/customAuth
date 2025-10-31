<x-master title="Role and Permission Management">
    <x-top-bar />
<style>
   button {
    cursor: pointer;
    border: none;
    font-size: large;
    color: gray;
}
</style>

<!-- Modal -->
<!-- Add Role Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold" id="exampleModalLabel">Add New Role</h5>
                <button type="button" class="close btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <form id="addRoleForm">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="roleName" class="col-form-label fw-semibold">Role Name</label>
                        <input type="text" class="form-control" id="roleName" name="name"
                            placeholder="Enter role name" required>
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

<div class="card-header d-flex justify-content-between align-items-center"> <h2 class="mb-4 fw-bold">Role Permission Management</h2> <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"> +Add Role </button> </div>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('permissions.update') }}">
            @csrf

            <div class="accordion" id="rolesAccordion">
                @foreach ($roles as $role)
                    <div class="accordion-item mb-3 shadow-sm border">
                        <h2 class="accordion-header" id="heading{{ $loop->index }}">
                            <button class="accordion-button collapsed fw-semibold text-capitalize bg-light"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#collapse{{ $loop->index }}"
                                    aria-expanded="false"
                                    aria-controls="collapse{{ $loop->index }}">
                                {{ ucfirst($role->name) }}
                            </button>
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
                                                <div class="d-flex justify-content-between align-items-center mb-2">
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
                <button class="btn btn-primary px-4" type="submit">💾 Save All Permissions</button>
            </div>
        </form>
    </div>

    {{-- JS Script for Select All --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {


    function getChildren(module, role) {
        return $(`.perm-checkbox[data-module="${module}"][data-role="${role}"]`);
    }


    $('.select-all').each(function() {
        const module = $(this).data('module');
        const role = $(this).data('role');
        const children = getChildren(module, role);

        if (children.length === 0) {
            $(this).closest('.form-check').hide();
            return;
        }

        const allChecked = children.length > 0 && children.filter(':checked').length === children.length;
        $(this).prop('checked', allChecked);
    });


    $('.perm-checkbox').on('change', function() {
        const module = $(this).data('module');
        const role = $(this).data('role');
        const children = getChildren(module, role);
        const selectAll = $(`#selectAll_${role}_${module}`);

        const total = children.length;
        const checkedCount = children.filter(':checked').length;

        selectAll.prop('checked', checkedCount === total);
        selectAll.prop('indeterminate', checkedCount > 0 && checkedCount < total);
    });


    $('.select-all').on('change', function() {
        const module = $(this).data('module');
        const role = $(this).data('role');
        const isChecked = $(this).is(':checked');

        const children = getChildren(module, role);
        children.prop('checked', isChecked).trigger('change');


        $(this).prop('indeterminate', false);
    });

});


$(document).ready(function () {
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


                    $('<div class="alert alert-success mt-3">' + response.message + '</div>')
                        .insertBefore('.accordion')
                        .delay(3000)
                        .fadeOut(500, function () { $(this).remove(); });

                    //
                    location.reload();
                }
            },
            error: function (xhr) {
                const errors = xhr.responseJSON?.errors;
                if (errors?.name) {
                    alert(errors.name[0]);
                } else {
                    alert('Something went wrong. Please try again.');
                }
            }
        });
    });
});

</script>

</x-master>
