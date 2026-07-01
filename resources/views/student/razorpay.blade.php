@extends('layouts.student')

@section('content')

<div class="max-w-xl mx-auto mt-10 bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">

    <!-- Header -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-8 py-6">

        <h1 class="text-3xl font-bold text-white">
            💳 Complete Payment
        </h1>

        <p class="text-blue-100 mt-2">
            Securely complete your tutoring session payment.
        </p>

    </div>

    <!-- Payment Details -->
    <div class="p-8">

        <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 text-center">

            <p class="text-gray-600 text-sm">
                Total Amount Payable
            </p>

            <h2 class="text-4xl font-bold text-blue-700 mt-2">
                ₹{{ number_format($bookingData['total_price'], 2) }}
            </h2>

        </div>

        <button id="rzp-button"
                class="w-full mt-8 inline-flex justify-center items-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-6 py-3 rounded-xl shadow-md hover:shadow-lg transition duration-300 font-semibold text-lg">

            💳 Proceed to Secure Payment

        </button>

        <div class="mt-8 bg-green-50 border border-green-200 rounded-xl p-4">

            <h3 class="font-semibold text-green-700 mb-2">
                🔒 Secure Payment
            </h3>

            <p class="text-sm text-gray-600">
                Your payment is securely processed through Razorpay. After successful payment, you can view or download your payment receipt.
            </p>

        </div>

    </div>

</div>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script>

var options = {

    "key": "{{ env('RAZORPAY_KEY_ID') }}",

    "amount": "{{ $order['amount'] }}",

    "currency": "INR",

    "name": "Tutor Finder",

    "description": "Session Booking",

    "order_id": "{{ $order['id'] }}",

    "handler": function (response){

        window.location.href =
            "{{ route('student.payment.success') }}"
            + "?payment_id="
            + response.razorpay_payment_id
            + "&order_id="
            + response.razorpay_order_id;
    }
};

var rzp1 = new Razorpay(options);

document.getElementById('rzp-button').onclick = function(e){

    rzp1.open();

    e.preventDefault();
}

</script>

@endsection