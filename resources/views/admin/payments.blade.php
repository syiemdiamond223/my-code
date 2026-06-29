@extends('layouts.admin')

@section('page-title', 'Payment Records')

@section('page-subtitle', 'Monitor all student payments and refunds')

@section('content')

<div class="space-y-6">

    <div class="bg-white rounded-2xl shadow-sm p-6">


    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">

    <div class="bg-green-100 border border-green-500 p-4 rounded-xl">
        <h3 class="text-sm text-gray-600 mb-2">
            Total Revenue
        </h3>

        <p class="text-2xl font-bold text-green-700">
            ₹{{ $totalRevenue }}
        </p>
    </div>

    <div class="bg-blue-100 border border-blue-500 p-6 rounded-2xl">
        <h3 class="text-sm text-gray-600 mb-2">
            Paid Transactions
        </h3>

        <p class="text-3xl font-bold text-blue-700">
            {{ $totalPaidTransactions }}
        </p>
    </div>

    <div class="bg-yellow-100 border border-yellow-500 p-6 rounded-2xl">
        <h3 class="text-sm text-gray-600 mb-2">
            Pending Payments
        </h3>

        <p class="text-3xl font-bold text-yellow-700">
            {{ $pendingPayments }}
        </p>
    </div>

    <div class="bg-red-100 border border-red-500 p-6 rounded-2xl">
        <h3 class="text-sm text-gray-600 mb-2">
            Total Refunds
        </h3>

        <p class="text-3xl font-bold text-red-700">
            ₹{{ $totalRefunds }}
        </p>
    </div>

</div>

    <form method="GET" action="{{ route('admin.payments') }}"
        class="bg-white p-4 rounded-xl shadow mb-6">

    <div class="grid md:grid-cols-4 gap-4">

        <input
            type="text"
            name="student"
            value="{{ request('student') }}"
            placeholder="Search Student"
            class="border rounded-lg px-4 py-2">

        <input
            type="text"
            name="tutor"
            value="{{ request('tutor') }}"
            placeholder="Search Tutor"
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

            <a href="{{ route('admin.payments') }}"
            class="bg-violet-600 text-white px-5 py-2 rounded-lg">

                Reset

            </a>

        </div>

    </form>


    @if($payments->isEmpty())

        <div class="bg-white p-8 rounded-xl shadow">
            No payment records found.
        </div>

    @else

        <div class="overflow-x-auto bg-white rounded-xl shadow">

            <table class="w-full">

                <thead class="bg-gray-100">

                    <tr>

                        <th class="p-4 text-left">Student</th>
                        <th class="p-4 text-left">Tutor</th>
                        <th class="p-4 text-left">Subject</th>
                        <th class="p-4 text-left">Amount</th>
                        <th class="p-4 text-left">Payment Status</th>
                        <th class="p-4 text-left">Refund Status</th>
                        <th class="p-4 text-left">Receipt</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($payments as $payment)

                    <tr class="border-t">

                        <td class="p-4">
                            {{ $payment->student->name }}
                        </td>

                        <td class="p-4">
                            {{ $payment->tutor->user->name }}
                        </td>

                        <td class="p-4">
                            {{ $payment->subject->name }}
                        </td>

                        <td class="p-4">
                            ₹{{ $payment->total_price }}
                        </td>

                        <td class="p-4">

                            @if($payment->payment_status == 'paid')

                                <span class="px-2 py-1 rounded bg-green-100 text-green-700">
                                    Paid
                                </span>

                            @elseif($payment->payment_status == 'pending')

                                <span class="px-2 py-1 rounded bg-yellow-100 text-yellow-700">
                                    Pending
                                </span>

                            @else

                                <span class="px-2 py-1 rounded bg-red-100 text-red-700">
                                    Failed
                                </span>

                            @endif

                        </td>

                        <td class="p-4">

                            @if($payment->refund_status == 'refunded')

                                <span class="px-2 py-1 rounded bg-green-100 text-green-700">
                                    Refunded
                                </span>

                            @elseif($payment->refund_status == 'partial_refund')

                                <span class="px-2 py-1 rounded bg-yellow-100 text-yellow-700">
                                    Partial Refund
                                </span>

                            @elseif($payment->refund_status == 'pending')

                                <span class="px-2 py-1 rounded bg-blue-100 text-blue-700">
                                    Pending
                                </span>

                            @else

                                <span class="px-2 py-1 rounded bg-gray-100 text-gray-700">
                                    Not Requested
                                </span>

                            @endif

                            @if($payment->refund_amount)

                                <br>
                                ₹{{ $payment->refund_amount }}

                            @endif

                        </td>

                       <td class="p-4">

                        @if($payment->payment_status == 'paid')

                            <div class="flex gap-2">

                                <a href="{{ route('receipt.preview', $payment->id) }}"
                                target="_blank"
                                class="bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-lg text-sm">

                                    View

                                </a>

                                <a href="{{ route('receipt.download', $payment->id) }}"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-lg text-sm">

                                    Download

                                </a>

                            </div>
                       
                            @else

                                <span class="text-gray-500 text-sm">
                                    Not Available
                                </span>

                            @endif

                    </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    @endif

</div>
</div>
@endsection