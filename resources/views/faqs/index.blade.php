<x-master title="FAQs">
    <x-top-bar />

    <!-- Add/Edit FAQ Modal -->
    <div class="modal fade" id="faqModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form id="faqForm">
                @csrf
                <input type="hidden" name="faq_id" id="faq_id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add / Edit FAQ</h5>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Question</label>
                            <input type="text" name="question" id="question" class="form-control">
                            <div class="text-danger small" id="question_error"></div>
                        </div>
                        <div class="mb-3">
                            <label>Answer</label>
                            <textarea name="answer" id="answer" class="form-control" rows="3"></textarea>
                            <div class="text-danger small" id="answer_error"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save FAQ</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>Frequently Asked Questions</h4>

            {{-- Only show "Add FAQ" button if user can create --}}
            @can('create faq')
                <button class="btn btn-primary" id="addFaqBtn">
                    <i class="bi bi-plus-circle me-1"></i> Add FAQ
                </button>
            @endcan
        </div>

        <table class="table table-bordered text-center align-middle" id="faqTable">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Question</th>
                    <th>Answer</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
    </div>

    <script>
        // Show Add Modal
        $(document).on('click', '#addFaqBtn', function () {
            $('#faqForm')[0].reset();
            $('#faq_id').val('');
            $('#question_error').text('');
            $('#answer_error').text('');
            $('#faqModal').modal('show');
        });

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2500,
            timerProgressBar: true
        });

        // Initialize DataTable
        const table = $('#faqTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('faqs.index') }}",
                type: 'GET'
            },
            columns: [
                { data: 'id', name: 'id' },
                { data: 'question', name: 'question' },
                { data: 'answer', name: 'answer' },
                {
                    data: null,
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    render: function (data, type, row) {
                        let actions = '';

                        @can('edit faq')
                            actions += `<button class="btn btn-sm btn-warning editFaq me-2"
                                data-id="${row.id}" data-question="${row.question}" data-answer="${row.answer}">
                                <i class="bi bi-pencil"></i>
                            </button>`;
                        @endcan

                        @can('delete faq')
                            actions += `<button class="btn btn-sm btn-danger deleteFaq" data-id="${row.id}">
                                <i class="bi bi-trash"></i>
                            </button>`;
                        @endcan

                        return actions || '<span class="text-muted">No Actions</span>';
                    }
                }
            ]
        });

        // Save FAQ (Add/Edit)
        $('#faqForm').on('submit', function (e) {
            e.preventDefault();
            let id = $('#faq_id').val();
            let url = id ? `/faqs/${id}` : "{{ route('faqs.store') }}";
            let method = id ? 'PUT' : 'POST';

            $.ajax({
                url,
                type: method,
                data: $(this).serialize(),
                success: function (res) {
                    if (res.success) {
                        $('#faqModal').modal('hide');
                        $('#faqForm')[0].reset();
                        Toast.fire({ icon: 'success', title: res.message });
                        table.ajax.reload();
                    } else {
                        Toast.fire({ icon: 'error', title: res.message || 'Something went wrong' });
                    }
                },
                error: function (xhr) {
                    $('#question_error').text('');
                    $('#answer_error').text('');
                    if (xhr.responseJSON?.errors) {
                        let errs = xhr.responseJSON.errors;
                        if (errs.question) $('#question_error').text(errs.question[0]);
                        if (errs.answer) $('#answer_error').text(errs.answer[0]);
                    } else {
                        Toast.fire({ icon: 'error', title: 'Unexpected error occurred' });
                    }
                }
            });
        });

        // Edit FAQ
        $(document).on('click', '.editFaq', function () {
            $('#faq_id').val($(this).data('id'));
            $('#question').val($(this).data('question'));
            $('#answer').val($(this).data('answer'));
            $('#faqModal').modal('show');
        });

        // Delete FAQ
        $(document).on('click', '.deleteFaq', function () {
            const id = $(this).data('id');
            Swal.fire({
                title: 'Delete this FAQ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/faqs/${id}`,
                        type: 'DELETE',
                        data: { _token: '{{ csrf_token() }}' },
                        success: function (res) {
                            if (res.success) {
                                Toast.fire({ icon: 'success', title: res.message });
                                table.ajax.reload();
                            } else {
                                Toast.fire({ icon: 'error', title: 'Failed to delete' });
                            }
                        },
                        error: () => {
                            Toast.fire({ icon: 'error', title: 'Something went wrong' });
                        }
                    });
                }
            });
        });
    </script>
</x-master>
