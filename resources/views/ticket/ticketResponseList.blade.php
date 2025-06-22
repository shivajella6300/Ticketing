<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-content-end">
          <button class="btn btn-danger btn-sm"><a href="{{route('admin.tickets')}}">All Tickets</a> </button>
        </div>
    </x-slot>
      
    <div class="py-6 px-4 max-w-7xl mx-auto">
        <table id="ticketTable" class="display w-full">
            <thead>
                <tr>
                    <th>Sno</th>
                    <th>Ticket Response Id</th>
                    <th>ticket_id</th>
                    <th>ticket_response</th>
                    <th>created_at</th>
                    <th>Ticket_Category</th>
                     <th>Ticket_Description</th>
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
    $('#ticketTable').DataTable({
        processing: true,
        serverSide: true,
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'ticket_response_id', name: 'ticket_response_id' },
            { data: 'ticket_id', name: 'ticket_id' },
            { data: 'ticket_response', name: 'ticket_response' },
            { data: 'created_at', name: 'created_at' },
            { data: 'Ticket_Category', name: 'Ticket_Category' },
            { data: 'Ticket_Description', name: 'Ticket_Description' }
        ]
    });
    $('#status_fil').change(function () {
                table.draw();
            });
});
</script>
