<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
           Admin Tickets List
        </h2>
        <div class="flex justify-content-end">
          <button class="btn btn-danger btn-sm"><a href="{{route('ticket.response')}}">Response Tickets</a> </button>
        </div>

        <div class="col-md-4">
                        <form method="GET" enctype="multipart/form-data"
                              class="app-search d-none d-lg-block needs-validation"
                              novalidate="true" id="item_group">
                             @csrf
                            <div class="mb-3">
                                <label class="text-sm font-600">Ticket Status</label>
                                <select class="form-control form-select" id="status_fil"
                                        class="form-control form-select">
                                          <option value="" >Select Status</option>
                                          <option value="Pending">Pending</option>
                                          <option value="Opened">Opened</option>
                                          <option value="Closed">Closed</option>
                                </select>
                            </div>
                            <div class="invalid-feedback">
                                <span class="text-danger">Please Select Category</span>
                            </div>
                        </form>
                    </div>


    </x-slot>

    <div class="py-6 px-4 max-w-7xl mx-auto">
        <table id="ticketTable" class="display w-full">
            <thead>
                <tr>
                    <th>Sno</th>
                    <th>User Name</th>
                    <th>Subject</th>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Ticket Status</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>
</x-app-layout>

<!-- Include CDN Scripts -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
  var table=$('#ticketTable').DataTable({
        processing: true,
        serverSide: true,
         ajax: {
                url: "{{route('admin.tickets')}}",
                data: function (data) {
                    data.Ticket_Status = $('#status_fil').val();
                },
                },
       
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            { data: 'User_Name',          name: 'User_Name' },
            { data: 'Ticket_Subject',     name: 'Ticket_Subject' },
            { data: 'Ticket_Category',    name: 'Ticket_Category' },
            { data: 'Ticket_Description', name: 'Ticket_Description' },
            { data: 'Ticket_Status', name: 'Ticket_Status' },
            {data: 'action', name: 'action', orderable: false, searchable: false},

        ]
    });
    $('#status_fil').change(function () {
                table.draw();
            });
});
$(document).on('click', '.change-status', function (e) {
    e.preventDefault();
    const id = $(this).data('id');
    const status = $(this).data('status');
    Swal.fire({
        title: `Confirm to mark ticket as ${status}?`,
        input: 'textarea',
        inputLabel: 'Add a comment (required)',
        inputPlaceholder: 'Enter your response...',
        showCancelButton: true,
        confirmButtonText: 'Submit',
        cancelButtonText: 'Cancel',
        preConfirm: (comment) => {
            if (!comment || !comment.trim()) {
                Swal.showValidationMessage('Please Enter the Comment');
                return false;
            }
            return comment.trim();
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const comment = result.value;
            $.ajax({
                url: "{{route('update.ticketStatus')}}",
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id,
                    status: status,
                    comment: comment
                },
                success: function (res) {
                    Swal.fire('Updated!', res.message, 'success');
                    $('#ticketTable').DataTable().ajax.reload(null, false);
                },
                error: function () {
                    Swal.fire('Error!', 'Something went wrong.', 'error');
                }
            });
        }
    });
});






</script>
