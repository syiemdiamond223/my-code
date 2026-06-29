@extends('layouts.tutor')
@section('page-title', 'Payment History')
@section('page-subtitle', 'Track all your earnings and refunds')
@section('content')
<div class="p-6 bg-gray-50 min-h-screen">

    <form method="GET"
        action="{{ route('tutor.payments') }}"
        class="bg-white p-4 rounded-xl shadow mb-6">

        <div class="grid md:grid-cols-3 gap-4">

            <input
                type="text"
                name="tutor"
                value="{{ request('tutor') }}"
                placeholder="Search Student"
                class="border rounded-lg px-4 py-2">

            <select
                name="status"
                class="border rounded-lg px-4 py-2">

                <option value="">All Status</option>

                <option value="paid"
                    {{ request('status') == 'paid' ? 'selected' : '' }}>
                    Paid
                </option>

                <option value="pending"
                    {{ request('status') == 'pending' ? 'selected' : '' }}>
                    Pending
                </option>

                <option value="failed"
                    {{ request('status') == 'failed' ? 'selected' : '' }}>
                    Failed
                </option>

            </select>

            <input
                type="text"
                id="filterDate"
                name="date"
                value="{{ request('date') }}"
                placeholder="YYYY-MM-DD"
                class="border rounded-lg px-4 py-2">

        </div>

        <div class="mt-4 flex gap-3">

            <button type="submit"
                    class="bg-blue-600 text-white px-5 py-2 rounded-lg">

                Filter

            </button>

            <a href="{{ route('tutor.payments') }}"
            class="bg-violet-600 text-white px-5 py-2 rounded-lg">

                Reset

            </a>

        </div>

    </form>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">

    <div class="bg-green-100 border border-green-500 p-5 rounded-2xl">
        <h3 class="text-sm text-gray-600 mb-2">
             Total Payments Received
        </h3>

        <p class="text-3xl font-bold text-green-700">
            ₹{{ $totalEarnings }}
        </p>
    </div>

    <div class="bg-yellow-100 border border-yellow-500 p-6 rounded-2xl">
        <h3 class="text-sm text-gray-600 mb-2">
            Refunds Requests
        </h3>

        <p class="text-3xl font-bold text-yellow-700">
            {{ $pendingRefunds }}
        </p>
    </div>

    <div class="bg-blue-100 border border-blue-500 p-6 rounded-2xl">
        <h3 class="text-sm text-gray-600 mb-2">
            Total Refunded
        </h3>

        <p class="text-3xl font-bold text-blue-700">
            ₹{{ $totalRefunds }}
        </p>
    </div>

</div>

    @if($payments->isEmpty())

        <div class="bg-white p-10 rounded-2xl border border-gray-200 shadow-sm text-center">

            <h3 class="text-lg font-semibold text-gray-700">
                No payment records found
            </h3>

        </div>

    @else

        <div class="space-y-6">

            @foreach($payments as $payment)

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200">

                <div class="flex justify-between items-center mb-4">

                    <div>

                        <h2 class="text-xl font-semibold text-gray-900">
                            {{ $payment->student->name }}
                        </h2>

                        <p class="text-gray-500 text-sm">
                            Subject: {{ $payment->subject->name }}
                        </p>

                    </div>

                    <span class="px-3 py-1 rounded-full text-sm font-medium

                    @if($payment->payment_status == 'paid')
                        bg-green-100 text-green-700
                    @elseif($payment->payment_status == 'pending')
                        bg-yellow-100 text-yellow-700
                    @else
                        bg-red-100 text-red-700
                    @endif">

                        {{ ucfirst($payment->payment_status) }}

                    </span>

                </div>

                <div class="space-y-2 text-sm text-gray-600">

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

                @if($payment->payment_status == 'paid')

                <div class="mt-4 flex gap-3">

                    <a href="{{ route('receipt.preview', $payment->id) }}"
                    target="_blank"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium">

                        View Receipt

                    </a>

                    <a href="{{ route('receipt.download', $payment->id) }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">

                        Download Receipt

                    </a>

                </div>

                @endif

                @if($payment->refund_status != 'not_requested')

                    <div class="mt-4 p-4 rounded-xl

                        @if($payment->refund_status == 'refunded')
                            bg-green-100 text-green-700 border border-green-200

                        @elseif($payment->refund_status == 'partial_refund')
                            bg-yellow-100 text-yellow-700 border border-yellow-200

                        @else
                            bg-blue-100 text-blue-700 border border-blue-200
                        @endif">

                        <strong>Refund Status:</strong>
                        {{ ucfirst(str_replace('_', ' ', $payment->refund_status)) }}

                        <br>

                        <strong>Refund Amount:</strong>
                        ₹{{ $payment->refund_amount }}

                    </div>

                @endif

            </div>

            @endforeach

        </div>

    @endif

</div>

@endsection