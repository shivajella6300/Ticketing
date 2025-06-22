<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{__('Dashboard')}}
        </h2>
    @if(auth()->user()->role==="user")
       <div class="flex justify-end mb-4">
        <a href="{{ route('ticket.form') }}" 
        class="bg-red-600 text-black text-sm px-4 py-2 rounded shadow">
            Raise Ticket
        </a>
      </div>
      @else
      <div class="flex justify-end mb-4">
        <a href="{{ route('admin.tickets') }}" 
          class="bg-blue-600 hover:bg-red-500 text-black text-sm px-4 py-2 rounded shadow">
             Tickets List
        </a>
      </div>
     @endif
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                    <h2> {{ auth()->user()->role }}</h2>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
