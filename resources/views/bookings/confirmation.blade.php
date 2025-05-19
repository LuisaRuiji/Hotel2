<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Booking Confirmation') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6" role="alert">
                        <strong class="font-bold">Success!</strong>
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                    @endif
                    
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-green-600 mb-4">
                            Your booking has been confirmed!
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <h4 class="font-medium mb-2">Booking Details:</h4>
                                <p><strong>Check-in:</strong> {{ $booking->check_in_date->format('M d, Y') }}</p>
                                <p><strong>Check-out:</strong> {{ $booking->check_out_date->format('M d, Y') }}</p>
                                <p><strong>Number of Guests:</strong> {{ $booking->guests }}</p>
                                <p><strong>Total Amount:</strong> ₱{{ number_format($booking->total_amount, 2) }}</p>
                                <p><strong>Status:</strong> <span class="capitalize">{{ $booking->status }}</span></p>
                                <p><strong>Booking Reference:</strong> #{{ $booking->id }}</p>
                            </div>
                            
                            <div>
                                <h4 class="font-medium mb-2">Room Details:</h4>
                                <p><strong>Room Number:</strong> {{ $booking->room->room_number }}</p>
                                <p><strong>Room Type:</strong> {{ $booking->room->type }}</p>
                                <p><strong>Floor:</strong> {{ $booking->room->floor }}</p>
                                <p><strong>Capacity:</strong> {{ $booking->room->capacity }} persons</p>
                            </div>
                        </div>

                        @if($booking->special_requests)
                            <div class="mt-4">
                                <h4 class="font-medium mb-2">Special Requests:</h4>
                                <p>{{ $booking->special_requests }}</p>
                            </div>
                        @endif
                        
                        @if($booking->services->count() > 0)
                            <div class="mt-4">
                                <h4 class="font-medium mb-2">Additional Services:</h4>
                                <ul>
                                    @foreach($booking->services as $service)
                                        <li>
                                            {{ $service->name }} 
                                            @if($service->pivot->quantity > 1)
                                                ({{ $service->pivot->quantity }}x)
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('dashboard') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Return to Dashboard
                        </a>
                        
                        <!-- Print receipt option -->
                        <a href="{{ route('customer.booking.receipt', $booking) }}" class="ml-4 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            View Receipt
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 