<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
           User HasMany Tickets List
        </h2>
            @if(session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(session()->has('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        <h2 class="font-semibold text-xl mt-4 text-gray-800 dark:text-gray-200 leading-tight">
           Ticket Status
        </h2>
        <div class="col-md-4">
                        <form method="GET" enctype="multipart/form-data"
                              class="app-search d-none d-lg-block needs-validation"
                              novalidate="true" id="item_group">
                             @csrf
                            <div class="mb-3">
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
        <div class="flex justify-end">
           <button class="bg-red-600 text-black text-sm px-4 py-2 rounded shadow"><a href="{{route('ticket.form')}}">Ticket Raise</a></button>
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
                    <th>Status</th>
                </tr>
            </thead>
        </table>
    </div>
</x-app-layout>

<!-- Include CDN Scripts -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function() {
   var table =  $('#ticketTable').DataTable({
        processing: true,
        serverSide: true,
              ajax: {
                    url: "{{route('user.ticketlist') }}",
                    data: function (data) {
                        data.Ticket_Status = $('#status_fil').val();
                    },
                },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            { data: 'User_Name', name: 'User_Name' },
            { data: 'Ticket_Subject', name: 'Ticket_Subject' },
            { data: 'Ticket_Category', name: 'Ticket_Category' },
            { data: 'Ticket_Description', name: 'Ticket_Description' },
            { data: 'Ticket_Status', name: 'Ticket_Status' },

        ]
       
    });
     $('#status_fil').change(function () {
                table.draw();
            });
     
});
</script>
