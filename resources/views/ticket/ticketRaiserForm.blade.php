<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Raise Ticket
        </h2>
        <div class="flex justify-end">
            <button class="bg-red-600 text-black rounded px-2 py-2 text-sm shadow"><a  href="{{route('user.ticketlist')}}">ticket List</a></button>
        </div>
    </x-slot>

   <div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-danger text-white">
            <h4 class="mb-0">Raise a Ticket</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('ticket.raise') }}" method="POST" novalidate>
                @csrf

                <div class="row g-3">
                    <!-- User Name -->
                    <div class="col-md-6">
                        <label for="User_Name" class="form-label">User Name <span class="text-danger">*</span></label>
                        <input type="text" name="User_Name" class="form-control @error('User_Name') is-invalid @enderror" value="{{ auth()->user()->name }}" readonly>
                        @error('User_Name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Ticket Subject -->
                    <div class="col-md-6">
                        <label for="Ticket_Subject" class="form-label">Ticket Subject <span class="text-danger">*</span></label>
                        <input type="text" name="Ticket_Subject" class="form-control @error('Ticket_Subject') is-invalid @enderror" required>
                        @error('Ticket_Subject') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Ticket Category -->
                    <div class="col-md-6">
                        <label for="Ticket_Category" class="form-label">Ticket Category <span class="text-danger">*</span></label>
                        <select name="Ticket_Category" class="form-select @error('Ticket_Category') is-invalid @enderror" required>
                            <option value="">Select Category</option>
                            <option value="Technical">Technical</option>
                            <option value="Billing">Billing</option>
                            <option value="Support">Support</option>
                            <option value="General">General</option>
                        </select>
                        @error('Ticket_Category') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Ticket Description -->
                    <div class="col-md-12">
                        <label for="Ticket_Description" class="form-label">Ticket Description <span class="text-danger">*</span></label>
                        <textarea name="Ticket_Description" rows="4" class="form-control @error('Ticket_Description') is-invalid @enderror" required></textarea>
                        @error('Ticket_Description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-danger px-4">Submit Ticket</button>
                </div>
            </form>
        </div>
    </div>
</div>



</x-app-layout>
