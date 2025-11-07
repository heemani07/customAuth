<x-master title="FAQs">
    <x-top-bar/>

    <style>
        .faq-container {
            max-width: 800px;
            margin: 2rem auto;
            background: #fff;
            padding: 1.5rem 2rem;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        .faq-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        .faq-header h5 {
            font-size: 1.1rem;
            font-weight: 600;
            color: #444;
            margin: 0;
        }
        .accordion-button {
            background: #fff;
            font-size: 1rem;
            font-weight: 500;
            color: #333;
            box-shadow: none !important;
            border: none;
        }
        .accordion-button:not(.collapsed) {
            color: #007bff;
            background: #f8f9fa;
        }
        .accordion-body {
            position: relative;
            padding-top: 1.5rem;
            font-size: 0.95rem;
            color: #555;
        }
        .faq-actions {
            position: absolute;
            top: 0.5rem;
            right: 0.75rem;
        }
        .faq-actions button {
            border: none;
            background: none;
            color: #666;
            font-size: 1rem;
            margin-left: 8px;
            cursor: pointer;
        }
        .faq-actions button:hover {
            color: #007bff;
        }
    </style>

    <div class="faq-container">
        <div class="faq-header">
            <h5>Frequently Asked Questions</h5>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#faqModal">
                <i class="bi bi-plus-circle me-1"></i> Add FAQ
            </button>
        </div>

        <div class="accordion" id="faqAccordion">
            @forelse($faqs as $faq)
                <div class="accordion-item border rounded">
                    <h2 class="accordion-header" id="heading{{ $faq->id }}">
                        <button class="accordion-button collapsed" type="button"
                            data-bs-toggle="collapse" data-bs-target="#collapse{{ $faq->id }}"
                            aria-expanded="false" aria-controls="collapse{{ $faq->id }}">
                            {{ $faq->question }}
                        </button>
                    </h2>
                    <div id="collapse{{ $faq->id }}" class="accordion-collapse collapse"
                        aria-labelledby="heading{{ $faq->id }}" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            <div class="faq-actions">
                                <button class="editFaq"
                                    data-id="{{ $faq->id }}"
                                    data-question="{{ $faq->question }}"
                                    data-answer="{{ $faq->answer }}">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <button class="deleteFaq" data-id="{{ $faq->id }}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                            <p style="margin-left: 10px;">{{ $faq->answer }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-muted text-center m-0">No FAQs found yet.</p>
            @endforelse
        </div>
    </div>

    <!-- Add/Edit Modal -->
    <div class="modal fade" id="faqModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form id="faqForm">
                @csrf
                <input type="hidden" id="faq_id" name="faq_id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add / Edit FAQ</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Question</label>
                            <input type="text" class="form-control" name="question" id="question">
                            <div class="text-danger small" id="question_error"></div>
                        </div>
                        <div class="mb-3">
                            <label>Answer</label>
                            <textarea class="form-control" name="answer" id="answer" rows="3"></textarea>
                            <div class="text-danger small" id="answer_error"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

<script>
    // Setup reusable SweetAlert Toast
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2500,
        timerProgressBar: true,
        customClass: {
            popup: 'colored-toast'
        }
    });

    // Save FAQ (Add/Edit)
    $('#faqForm').on('submit', function(e) {
        e.preventDefault();
        const id = $('#faq_id').val();
        const url = id ? `/faqs/${id}` : "{{ route('faqs.store') }}";
        const method = id ? 'PUT' : 'POST';

        $.ajax({
            url,
            method,
            data: $(this).serialize(),
            success: function(res) {
                if (res.success) {
                    $('#faqModal').modal('hide');
                    $('#faqForm')[0].reset();
                    Toast.fire({
                        icon: 'success',
                        title: res.message
                    });
                    setTimeout(() => location.reload(), 1500);
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: res.message || 'Something went wrong'
                    });
                }
            },
            error: function(xhr) {
                const errors = xhr.responseJSON?.errors;
                let errorMsg = 'Something went wrong';
                if (errors) {
                    errorMsg = Object.values(errors).flat().join('<br>');
                }
                Toast.fire({
                    icon: 'error',
                    title: errorMsg
                });
            }
        });
    });

    // Edit FAQ
    $(document).on('click', '.editFaq', function() {
        $('#faq_id').val($(this).data('id'));
        $('#question').val($(this).data('question'));
        $('#answer').val($(this).data('answer'));
        $('#faqModal').modal('show');
    });

    // Delete FAQ
    $(document).on('click', '.deleteFaq', function() {
        const id = $(this).data('id');
        Swal.fire({
            title: 'Delete this FAQ?',
            text: 'This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#aaa',
            confirmButtonText: 'Yes, delete it'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/faqs/${id}`,
                    method: 'DELETE',
                    data: {_token: '{{ csrf_token() }}'},
                    success: function(res) {
                        if (res.success) {
                            Toast.fire({
                                icon: 'success',
                                title: res.message
                            });
                            setTimeout(() => location.reload(), 1500);
                        } else {
                            Toast.fire({
                                icon: 'error',
                                title: res.message || 'Failed to delete'
                            });
                        }
                    },
                    error: () => {
                        Toast.fire({
                            icon: 'error',
                            title: 'Something went wrong'
                        });
                    }
                });
            }
        });
    });
</script>

</x-master>
