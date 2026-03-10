<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $reportTitle }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
            line-height: 1.6;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #10b981;
            padding-bottom: 20px;
        }
        
        .company-logo {
            max-width: 150px;
            max-height: 80px;
            margin-bottom: 10px;
        }
        
        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #10b981;
            margin-bottom: 5px;
        }
        
        .company-info {
            font-size: 12px;
            color: #666;
            margin-bottom: 5px;
        }
        
        .report-title {
            font-size: 28px;
            font-weight: bold;
            color: #1f2937;
            margin: 20px 0;
            text-align: center;
        }
        
        .report-meta {
            text-align: center;
            margin-bottom: 30px;
            color: #666;
            font-size: 14px;
        }
        
        .summary-section {
            margin-bottom: 30px;
            page-break-inside: avoid;
        }
        
        .summary-title {
            font-size: 18px;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 15px;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 5px;
        }
        
        .summary-grid {
            display: table;
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        .summary-row {
            display: table-row;
        }
        
        .summary-cell {
            display: table-cell;
            padding: 12px;
            border: 1px solid #e5e7eb;
            text-align: center;
            vertical-align: middle;
        }
        
        .summary-cell.header {
            background-color: #f9fafb;
            font-weight: bold;
            color: #374151;
        }
        
        .summary-cell.value {
            font-size: 16px;
            font-weight: bold;
            color: #10b981;
        }
        
        .summary-cell.amount {
            font-size: 18px;
            font-weight: bold;
            color: #059669;
        }
        
        .summary-cell.warning {
            color: #d97706;
        }
        
        .summary-cell.danger {
            color: #dc2626;
        }
        
        .details-section {
            margin-bottom: 30px;
        }
        
        .details-title {
            font-size: 18px;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 15px;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 5px;
        }
        
        .bills-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 12px;
        }
        
        .bills-table th {
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
            padding: 10px 8px;
            text-align: left;
            font-weight: bold;
            color: #374151;
        }
        
        .bills-table td {
            border: 1px solid #e5e7eb;
            padding: 8px;
            vertical-align: top;
        }
        
        .bills-table tr:nth-child(even) {
            background-color: #f9fafb;
        }
        
        .status-paid {
            color: #059669;
            font-weight: bold;
        }
        
        .status-pending {
            color: #d97706;
            font-weight: bold;
        }
        
        .status-overdue {
            color: #dc2626;
            font-weight: bold;
        }
        
        .status-cancelled {
            color: #6b7280;
            font-weight: bold;
        }
        
        .amount-cell {
            text-align: right;
            font-family: 'Courier New', monospace;
        }
        
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #e5e7eb;
            padding-top: 20px;
        }
        
        .page-break {
            page-break-before: always;
        }
        
        .no-break {
            page-break-inside: avoid;
        }
        
        .toc {
            margin-bottom: 30px;
        }
        
        .toc-title {
            font-size: 18px;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 15px;
        }
        
        .toc-item {
            margin-bottom: 8px;
            font-size: 14px;
        }
        
        .toc-link {
            color: #10b981;
            text-decoration: none;
        }
        
        .toc-link:hover {
            text-decoration: underline;
        }
        
        @media print {
            body {
                margin: 0;
                padding: 15px;
            }
            
            .page-break {
                page-break-before: always;
            }
        }
    </style>
</head>
<body>
    <!-- Header with Company Information -->
    <div class="header">
        @if($billHeader && $billHeader->company_logo)
            <img src="{{ storage_path('app/public/' . $billHeader->company_logo) }}" alt="Company Logo" class="company-logo">
        @endif
        
        <div class="company-name">{{ $billHeader->company_name ?? 'Your Company Name' }}</div>
        
        @if($billHeader)
            <div class="company-info">{{ $billHeader->company_address ?? '' }}</div>
            <div class="company-info">
                Phone: {{ $billHeader->company_phone ?? '' }} | 
                Email: {{ $billHeader->company_email ?? '' }}
            </div>
            @if($billHeader->company_website)
                <div class="company-info">Website: {{ $billHeader->company_website }}</div>
            @endif
        @endif
    </div>

    <!-- Report Title -->
    <div class="report-title">{{ $reportTitle }}</div>
    
    <!-- Report Meta Information -->
    <div class="report-meta">
        Generated on: {{ now()->format('F d, Y \a\t g:i A') }}<br>
        Report Period: {{ request('dateRange', 'All Time') }}<br>
        @if(request('status'))
            Status Filter: {{ ucfirst(request('status')) }}<br>
        @endif
        @if(request('search'))
            Search Term: "{{ request('search') }}"<br>
        @endif
    </div>

    <!-- Table of Contents -->
    <div class="toc">
        <div class="toc-title">Table of Contents</div>
        @if($includeSummary)
            <div class="toc-item">1. <a href="#summary" class="toc-link">Executive Summary</a></div>
        @endif
        @if($includeDetails)
            <div class="toc-item">2. <a href="#details" class="toc-link">Detailed Bills Report</a></div>
        @endif
        <div class="toc-item">3. <a href="#footer" class="toc-link">Report Footer</a></div>
    </div>

    <!-- Executive Summary Section -->
    @if($includeSummary)
        <div id="summary" class="summary-section">
            <div class="summary-title">📊 Executive Summary</div>
            
            <!-- Key Metrics -->
            <div class="summary-grid">
                <div class="summary-row">
                    <div class="summary-cell header">Metric</div>
                    <div class="summary-cell header">Count</div>
                    <div class="summary-cell header">Amount (Rs.)</div>
                </div>
                <div class="summary-row">
                    <div class="summary-cell">Total Bills</div>
                    <div class="summary-cell value">{{ number_format($summary['total_bills']) }}</div>
                    <div class="summary-cell amount">{{ number_format($summary['total_amount'], 2) }}</div>
                </div>
                <div class="summary-row">
                    <div class="summary-cell">Paid Bills</div>
                    <div class="summary-cell value">{{ number_format($summary['paid_bills']) }}</div>
                    <div class="summary-cell amount">{{ number_format($summary['total_paid'], 2) }}</div>
                </div>
                <div class="summary-row">
                    <div class="summary-cell">Pending Bills</div>
                    <div class="summary-cell value warning">{{ number_format($summary['pending_bills']) }}</div>
                    <div class="summary-cell amount warning">{{ number_format($summary['total_due'], 2) }}</div>
                </div>
                <div class="summary-row">
                    <div class="summary-cell">Overdue Bills</div>
                    <div class="summary-cell value danger">{{ number_format($summary['overdue_bills']) }}</div>
                    <div class="summary-cell amount danger">-</div>
                </div>
                @if($summary['cancelled_bills'] > 0)
                <div class="summary-row">
                    <div class="summary-cell">Cancelled Bills</div>
                    <div class="summary-cell value">{{ number_format($summary['cancelled_bills']) }}</div>
                    <div class="summary-cell amount">-</div>
                </div>
                @endif
            </div>

            <!-- Financial Summary -->
            <div style="margin-top: 20px;">
                <h3 style="color: #1f2937; margin-bottom: 10px;">💰 Financial Overview</h3>
                <div style="display: table; width: 100%;">
                    <div style="display: table-row;">
                        <div style="display: table-cell; width: 50%; padding: 10px; border: 1px solid #e5e7eb;">
                            <strong>Total Revenue:</strong><br>
                            <span style="font-size: 18px; color: #059669;">Rs. {{ number_format($summary['total_amount'], 2) }}</span>
                        </div>
                        <div style="display: table-cell; width: 50%; padding: 10px; border: 1px solid #e5e7eb;">
                            <strong>Outstanding Amount:</strong><br>
                            <span style="font-size: 18px; color: #dc2626;">Rs. {{ number_format($summary['total_due'], 2) }}</span>
                        </div>
                    </div>
                    <div style="display: table-row;">
                        <div style="display: table-cell; width: 50%; padding: 10px; border: 1px solid #e5e7eb;">
                            <strong>Collection Rate:</strong><br>
                            <span style="font-size: 18px; color: #10b981;">
                                {{ $summary['total_amount'] > 0 ? number_format(($summary['total_paid'] / $summary['total_amount']) * 100, 1) : 0 }}%
                            </span>
                        </div>
                        <div style="display: table-cell; width: 50%; padding: 10px; border: 1px solid #e5e7eb;">
                            <strong>Average Bill Amount:</strong><br>
                            <span style="font-size: 18px; color: #1f2937;">
                                Rs. {{ $summary['total_bills'] > 0 ? number_format($summary['total_amount'] / $summary['total_bills'], 2) : 0 }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Detailed Bills Report -->
    @if($includeDetails && count($billsData) > 0)
        <div id="details" class="details-section">
            <div class="page-break"></div>
            <div class="details-title">📋 Detailed Bills Report</div>
            
            <table class="bills-table">
                <thead>
                    <tr>
                        <th style="width: 12%;">Bill #</th>
                        <th style="width: 15%;">Customer</th>
                        <th style="width: 10%;">Date</th>
                        <th style="width: 10%;">Due Date</th>
                        <th style="width: 12%;">Total Amount</th>
                        <th style="width: 12%;">Paid Amount</th>
                        <th style="width: 12%;">Due Amount</th>
                        <th style="width: 10%;">Status</th>
                        <th style="width: 7%;">Created By</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($billsData as $bill)
                        <tr>
                            <td>
                                <strong>{{ $bill['bill_number'] }}</strong><br>
                                <small style="color: #666;">{{ $bill['order_number'] }}</small>
                            </td>
                            <td>
                                <strong>{{ $bill['customer_name'] }}</strong><br>
                                <small style="color: #666;">{{ $bill['customer_email'] }}</small>
                            </td>
                            <td>{{ $bill['date'] }}</td>
                            <td>{{ $bill['due_date'] }}</td>
                            <td class="amount-cell">
                                <strong>Rs. {{ $bill['amount'] }}</strong>
                            </td>
                            <td class="amount-cell">
                                <span style="color: #059669;">Rs. {{ $bill['paid_amount'] }}</span>
                            </td>
                            <td class="amount-cell">
                                @if($bill['due_amount'] > 0)
                                    <span style="color: #dc2626;">Rs. {{ $bill['due_amount'] }}</span>
                                @else
                                    <span style="color: #059669;">Rs. 0.00</span>
                                @endif
                            </td>
                            <td>
                                <span class="status-{{ strtolower($bill['status']) }}">
                                    {{ $bill['status'] }}
                                </span>
                            </td>
                            <td>
                                <small>{{ $bill['created_by'] }}</small>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Summary at bottom of details -->
            <div style="margin-top: 20px; text-align: right; font-size: 14px;">
                <strong>Total Bills: {{ count($billsData) }}</strong>
            </div>
        </div>
    @endif

    <!-- Footer -->
    <div id="footer" class="footer">
        <div style="margin-bottom: 10px;">
            <strong>{{ $billHeader->company_name ?? 'Your Company Name' }}</strong>
        </div>
        <div style="margin-bottom: 10px;">
            @if($billHeader)
                {{ $billHeader->company_address ?? '' }}<br>
                Phone: {{ $billHeader->company_phone ?? '' }} | 
                Email: {{ $billHeader->company_email ?? '' }}
                @if($billHeader->company_website)
                    | Website: {{ $billHeader->company_website }}
                @endif
            @endif
        </div>
        <div style="color: #999; font-size: 11px;">
            This report was generated automatically by the Animal Food Management System<br>
            Report ID: {{ uniqid() }} | Generated on: {{ now()->format('Y-m-d H:i:s') }}
        </div>
        @if($billHeader && $billHeader->footer_text)
            <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #e5e7eb; font-style: italic;">
                {{ $billHeader->footer_text }}
            </div>
        @endif
    </div>
</body>
</html>

