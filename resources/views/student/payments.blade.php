@extends('layouts.student')

@section('content')

<div class="p-6 bg-gray-50 min-h-screen">

    <h1 class="text-3xl font-bold mb-2 text-gray-900">
        Payment History
    </h1>

    <p class="text-gray-600 mb-8">
        Track all your payment transactions
    </p>

    @if($payments->isEmpty())

        <!-- Empty State -->
        <div class="bg-white p-10 rounded-2xl border border-gray-200 shadow-sm text-center">

            <h3 class="text-lg font-semibold text-gray-700">
                No payment records found
            </h3>

            <p class="text-gray-500 mt-2">
                Your payment history will appear here.
            </p>

        </div>

    @else

        <div class="space-y-6">

            @foreach($payments as $payment)

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200 hover:shadow-lg transition">

                <!-- Top -->
                <div class="flex justify-between items-center mb-4">

                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">
                            {{ $payment->tutor->user->name }}
                        </h2>

                        <p class="text-gray-500 text-sm">
                            Subject: {{ $payment->subject->name }}
                        </p>
                    </div>

                    <!-- Payment Status -->
                    <span class="px-3 py-1 rounded-full text-sm font-medium
                        @if($payment->payment_status == 'success')
                            bg-green-100 text-green-700
                        @elseif($payment->payment_status == 'pending')
                            bg-yellow-100 text-yellow-700
                        @else
                            bg-red-100 text-red-700
                        @endif">

                        {{ ucfirst($payment->payment_status) }}

                    </span>

                </div>

                <!-- Details -->
                <div class="mt-3 text-sm text-gray-600 space-y-2">

                    <p>
                        <strong>Amount:</strong>
                        ₹{{ $payment->total_price }}
                    </p>

                    <p>
                        <strong>Transaction ID:</strong>
                        {{ $payment->razorpay_payment_id ?? 'Not Available' }}
                    </p>

                    <p>
                        <strong>Session Date:</strong>
                        {{ $payment->session_date }}
                    </p>

                    <p>
                        <strong>Paid At:</strong>
                        {{ $payment->paid_at ?? 'Pending' }}
                    </p>

                </div>

                <!-- Actions -->
                <div class="mt-5">

                    @if($payment->payment_status == 'success')

                        <button class="bg-blue-600 text-white px-4 py-2 rounded-xl hover:bg-blue-700 transition">
                            View Receipt
                        </button>

                    @elseif($payment->payment_status == 'failed')

                        <button class="bg-red-600 text-white px-4 py-2 rounded-xl hover:bg-red-700 transition">
                            Retry Payment
                        </button>

                    @endif

                </div>

            </div>

            @endforeach

        </div>

    @endif

</div>

@endsection