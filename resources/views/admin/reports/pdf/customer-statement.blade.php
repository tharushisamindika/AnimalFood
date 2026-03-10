<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Customer Statement - {{ $customer->name }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }
        .statement-title {
            font-size: 18px;
            margin-top: 10px;
            color: #666;
        }
        .customer-info {
            margin-bottom: 20px;
        }
        .info-row {
            margin-bottom: 5px;
        }
        .label {
            font-weight: bold;
            display: inline-block;
            width: 120px;
        }
        .period {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            margin: 20px 0;
            padding: 10px;
            background-color: #f5f5f5;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .summary {
            margin-top: 30px;
            padding: 15px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }
        .summary-label {
            font-weight: bold;
        }
        .total-row {
            border-top: 2px solid #333;
            padding-top: 10px;
            margin-top: 10px;
            font-size: 14px;
            font-weight: bold;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-name">{{ config('app.name', 'Animal Food Management System') }}</div>
        <div class="statement-title">Customer Statement</div>
    </div>

    <div class="customer-info">
        <div class="info-row">
            <span class="label">Customer:</span> {{ $customer->name }}
        </div>
        <div class="info-row">
            <span class="label">Email:</span> {{ $customer->email }}
        </div>
        <div class="info-row">
            <span class="label">Phone:</span> {{ $customer->phone }}
        </div>
        <div class="info-row">
            <span class="label">Address:</span> {{ $customer->address }}
        </div>
        @if($customer->credit)
        <div class="info-row">
                            <span class="label">Credit Limit:</span> Rs. {{ number_format($customer->credit->credit_limit, 2) }}
        </div>
        <div class="info-row">
                            <span class="label">Available Credit:</span> Rs. {{ number_format($customer->credit->available_credit, 2) }}
        </div>
        @endif
    </div>

    <div class="period">
        Statement Period: {{ $start_date->format('F d, Y') }} to {{ $end_date->format('F d, Y') }}
    </div>

    @if($orders->count() > 0)
    <h3>Orders/Invoices</h3>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Invoice #</th>
                <th>Order #</th>
                <th class="text-right">Amount</th>
                <th class="text-right">Paid</th>
                <th class="text-right">Due</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order->created_at->format('M d, Y') }}</td>
                <td>{{ $order->invoice_number ?? '-' }}</td>
                <td>{{ $order->order_number }}</td>
                                        <td class="text-right">Rs. {{ number_format($order->final_amount, 2) }}</td>
                        <td class="text-right">Rs. {{ number_format($order->paid_amount, 2) }}</td>
                        <td class="text-right">Rs. {{ number_format($order->due_amount, 2) }}</td>
                <td>{{ ucfirst($order->payment_status) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    @if($payments->count() > 0)
    <h3>Payments Received</h3>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Transaction #</th>
                <th>Method</th>
                <th>Reference</th>
                <th class="text-right">Amount</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payments as $payment)
            <tr>
                <td>{{ $payment->payment_date->format('M d, Y') }}</td>
                <td>{{ $payment->transaction_number }}</td>
                <td>{{ $payment->formatted_payment_method }}</td>
                <td>{{ $payment->reference_number ?? '-' }}</td>
                                        <td class="text-right">Rs. {{ number_format($payment->amount, 2) }}</td>
                <td>{{ $payment->description ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    <div class="summary">
        <div class="summary-row">
                            <span class="summary-label">Total Orders Amount:</span>
                <span>Rs. {{ number_format($total_orders, 2) }}</span>
        </div>
        <div class="summary-row">
                            <span class="summary-label">Total Payments:</span>
                <span>Rs. {{ number_format($total_payments, 2) }}</span>
        </div>
        <div class="summary-row total-row">
                            <span class="summary-label">Outstanding Balance:</span>
                <span>Rs. {{ number_format($total_due, 2) }}</span>
        </div>
    </div>

    <div class="footer">
        <p>Statement generated on {{ now()->format('F d, Y \a\t H:i A') }}</p>
        <p>Please contact us if you have any questions about this statement.</p>
    </div>
</body>
</html>
