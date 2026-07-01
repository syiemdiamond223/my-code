<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">

        <style>

        body{
            font-family: DejaVu Sans;
            font-size:14px;
        }

        .title{
            text-align:center;
            font-size:24px;
            font-weight:bold;
            margin-bottom:20px;
        }

        table{
            width:100%;
            border-collapse:collapse;
        }

        td{
            border:1px solid #ddd;
            padding:8px;
        }

        </style>

        </head>
        <body>

        <div class="title">
            Tutor Finder Payment Receipt
        </div>

        <table>

        <tr>
            <td><strong>Receipt Number</strong></td>
            <td>RCPT-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</td>
        </tr>

        <tr>
            <td><strong>Booking ID</strong></td>
            <td>{{ $booking->id }}</td>
        </tr>

        <tr>
            <td><strong>Student Name</strong></td>
            <td>{{ $booking->student->name }}</td>
        </tr>

        <tr>
            <td><strong>Tutor Name</strong></td>
            <td>{{ $booking->tutor->user->name }}</td>
        </tr>

        <tr>
            <td><strong>Subject</strong></td>
            <td>{{ $booking->subject->name }}</td>
        </tr>

        <tr>
            <td><strong>Session Date</strong></td>
            <td>{{ $booking->session_date }}</td>
        </tr>

        <tr>
            <td><strong>Session Time</strong></td>
            <td>{{ $booking->session_time }}</td>
        </tr>

        <tr>
            <td><strong>Session Mode</strong></td>
            <td>{{ ucfirst($booking->session_mode) }}</td>
        </tr>

        <tr>
            <td><strong>Amount Paid</strong></td>
            <td>₹{{ number_format($booking->total_price,2) }}</td>
        </tr>

        <tr>
            <td><strong>Payment Status</strong></td>
            <td>{{ ucfirst($booking->payment_status) }}</td>
        </tr>

        <tr>
            <td><strong>Payment ID</strong></td>
            <td>{{ $booking->razorpay_payment_id }}</td>
        </tr>

        <tr>
            <td><strong>Order ID</strong></td>
            <td>{{ $booking->razorpay_order_id }}</td>
        </tr>

        <tr>
            <td><strong>Paid At</strong></td>
            <td>
                {{ $booking->paid_at
                    ? \Carbon\Carbon::parse($booking->paid_at)->format('d M Y, h:i A')
                    : 'N/A'
                }}
            </td>
        </tr>

        @if($booking->refund_status != 'not_requested')
        <tr>
            <td><strong>Refund Status</strong></td>
            <td>{{ ucfirst(str_replace('_', ' ', $booking->refund_status)) }}</td>
        </tr>

        <tr>
            <td><strong>Refund Amount</strong></td>
            <td>₹{{ number_format($booking->refund_amount, 2) }}</td>
        </tr>
        @endif
        @if($booking->refund_status == 'refunded')
        <tr>
            <td><strong>Refund Note</strong></td>
            <td>
                The payment for this booking has been refunded to the student.
            </td>
        </tr>
        @endif
        </table>

        <br>

        <p>
        Thank you for using Tutor Finder.
        </p>

</body>
</html>