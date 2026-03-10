<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $reportTitle }} - Print Preview</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                margin: 0;
                padding: 15px;
            }
            .page-break {
                page-break-before: always;
            }
            .no-break {
                page-break-inside: avoid;
            }
        }
        
        .print-header {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }
        
        .summary-card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        
        .metric-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .metric-card {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            padding: 15px;
            text-align: center;
        }
        
        .metric-value {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .metric-label {
            font-size: 14px;
            color: #6b7280;
        }
        
        .status-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
        }
        
        .status-paid { background-color: #dcfce7; color: #166534; }
        .status-pending { background-color: #fef3c7; color: #92400e; }
        .status-overdue { background-color: #fee2e2; color: #991b1b; }
        .status-cancelled { background-color: #f3f4f6; color: #374151; }
        
        .table-container {
            overflow-x: auto;
            margin-bottom: 20px;
        }
        
        .bills-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }
        
        .bills-table th {
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
            padding: 12px 8px;
            text-align: left;
            font-weight: bold;
            color: #374151;
        }
        
        .bills-table td {
            border: 1px solid #e5e7eb;
            padding: 10px 8px;
            vertical-align: top;
        }
        
        .bills-table tr:nth-child(even) {
            background-color: #f9fafb;
        }
        
        .bills-table tr:hover {
            background-color: #f3f4f6;
        }
        
        .amount-cell {
            text-align: right;
            font-family: 'Courier New', monospace;
            font-weight: bold;
        }
        
        .toc {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            padding: 20px;
            margin-bottom: 30px;
        }
        
        .toc-item {
            margin-bottom: 8px;
            padding: 5px 0;
        }
        
        .toc-link {
            color: #10b981;
            text-decoration: none;
            font-weight: 500;
        }
        
        .toc-link:hover {
            text-decoration: underline;
        }
        
        .print-controls {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .btn {
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: 500;
            text-decoration: none;
            display: inline-block;
            margin: 2px;
            cursor: pointer;
            border: none;
            font-size: 14px;
        }
        
        .btn-primary {
            background-color: #10b981;
            color: white;
        }
        
        .btn-primary:hover {
            background-color: #059669;
        }
        
        .btn-secondary {
            background-color: #6b7280;
            color: white;
        }
        
        .btn-secondary:hover {
            background-color: #4b5563;
        }
        
        .btn-outline {
            background-color: transparent;
            color: #10b981;
            border: 1px solid #10b981;
        }
        
        .btn-outline:hover {
            background-color: #10b981;
            color: white;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Print Controls -->
    <div class="print-controls no-print">
        <div class="text-sm font-medium text-gray-700 mb-3">Print Controls</div>
        <button onclick="window.print()" class="btn btn-primary">
            🖨️ Print Report
        </button>
        <button onclick="window.close()" class="btn btn-secondary">
            ❌ Close
        </button>
        <a href="{{ route('admin.billing.export', array_merge(request()->query(), ['type' => 'pdf'])) }}" class="btn btn-outline">
            📄 Download PDF
        </a>
        <div class="mt-3 text-xs text-gray-500">
            Press Ctrl+P to print
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Header with Company Information -->
        <div class="print-header">
            <div class="flex items-center justify-center mb-4">
                @if($billHeader && $billHeader->company_logo)
                    <img src="{{ asset('storage/' . $billHeader->company_logo) }}" alt="Company Logo" class="h-16 w-auto mr-4">
                @endif
                <div>
                    <h1 class="text-3xl font-bold">{{ $billHeader->company_name ?? 'Your Company Name' }}</h1>
                    @if($billHeader)
                        <p class="text-sm opacity-90">{{ $billHeader->company_address ?? '' }}</p>
                        <p class="text-sm opacity-90">
                            Phone: {{ $billHeader->company_phone ?? '' }} | 
                            Email: {{ $billHeader->company_email ?? '' }}
                            @if($billHeader->company_website)
                                | Website: {{ $billHeader->company_website }}
                            @endif
                        </p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Report Title -->
        <div class="text-center mb-8">
            <h2 class="text-4xl font-bold text-gray-900 mb-2">{{ $reportTitle }}</h2>
            <div class="text-gray-600">
                Generated on: {{ now()->format('F d, Y \a\t g:i A') }}<br>
                Report Period: {{ request('dateRange', 'All Time') }}
                @if(request('status'))
                    | Status: {{ ucfirst(request('status')) }}
                @endif
                @if(request('search'))
                    | Search: "{{ request('search') }}"
                @endif
            </div>
        </div>

        <!-- Table of Contents -->
        <div class="toc">
            <h3 class="text-lg font-bold text-gray-900 mb-3">📋 Table of Contents</h3>
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
            <div id="summary" class="summary-card no-break">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">📊 Executive Summary</h3>
                
                <!-- Key Metrics Grid -->
                <div class="metric-grid">
                    <div class="metric-card">
                        <div class="metric-value text-blue-600">{{ number_format($summary['total_bills']) }}</div>
                        <div class="metric-label">Total Bills</div>
                    </div>
                    <div class="metric-card">
                        <div class="metric-value text-green-600">Rs. {{ number_format($summary['total_amount'], 2) }}</div>
                        <div class="metric-label">Total Amount</div>
                    </div>
                    <div class="metric-card">
                        <div class="metric-value text-green-600">{{ number_format($summary['paid_bills']) }}</div>
                        <div class="metric-label">Paid Bills</div>
                    </div>
                    <div class="metric-card">
                        <div class="metric-value text-yellow-600">{{ number_format($summary['pending_bills']) }}</div>
                        <div class="metric-label">Pending Bills</div>
                    </div>
                    <div class="metric-card">
                        <div class="metric-value text-red-600">{{ number_format($summary['overdue_bills']) }}</div>
                        <div class="metric-label">Overdue Bills</div>
                    </div>
                    <div class="metric-card">
                        <div class="metric-value text-red-600">Rs. {{ number_format($summary['total_due'], 2) }}</div>
                        <div class="metric-label">Outstanding Amount</div>
                    </div>
                </div>

                <!-- Financial Overview -->
                <div class="mt-8">
                    <h4 class="text-xl font-bold text-gray-900 mb-4">💰 Financial Overview</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-white border border-gray-200 rounded-lg p-6">
                            <div class="text-sm text-gray-600 mb-2">Collection Rate</div>
                            <div class="text-3xl font-bold text-green-600">
                                {{ $summary['total_amount'] > 0 ? number_format(($summary['total_paid'] / $summary['total_amount']) * 100, 1) : 0 }}%
                            </div>
                        </div>
                        <div class="bg-white border border-gray-200 rounded-lg p-6">
                            <div class="text-sm text-gray-600 mb-2">Average Bill Amount</div>
                            <div class="text-3xl font-bold text-blue-600">
                                Rs. {{ $summary['total_bills'] > 0 ? number_format($summary['total_amount'] / $summary['total_bills'], 2) : 0 }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status Breakdown -->
                <div class="mt-8">
                    <h4 class="text-xl font-bold text-gray-900 mb-4">📈 Status Breakdown</h4>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-600">{{ number_format($summary['paid_bills']) }}</div>
                            <div class="text-sm text-gray-600">Paid</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-yellow-600">{{ number_format($summary['pending_bills']) }}</div>
                            <div class="text-sm text-gray-600">Pending</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-red-600">{{ number_format($summary['overdue_bills']) }}</div>
                            <div class="text-sm text-gray-600">Overdue</div>
                        </div>
                        @if($summary['cancelled_bills'] > 0)
                        <div class="text-center">
                            <div class="text-2xl font-bold text-gray-600">{{ number_format($summary['cancelled_bills']) }}</div>
                            <div class="text-sm text-gray-600">Cancelled</div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        <!-- Detailed Bills Report -->
        @if($includeDetails && count($billsData) > 0)
            <div id="details" class="page-break">
                <div class="summary-card">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">📋 Detailed Bills Report</h3>
                    
                    <div class="table-container">
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
                                            <div class="font-bold">{{ $bill['bill_number'] }}</div>
                                            <div class="text-sm text-gray-500">{{ $bill['order_number'] }}</div>
                                        </td>
                                        <td>
                                            <div class="font-medium">{{ $bill['customer_name'] }}</div>
                                            <div class="text-sm text-gray-500">{{ $bill['customer_email'] }}</div>
                                        </td>
                                        <td>{{ $bill['date'] }}</td>
                                        <td>{{ $bill['due_date'] }}</td>
                                        <td class="amount-cell">
                                            <span class="text-green-600">Rs. {{ $bill['amount'] }}</span>
                                        </td>
                                        <td class="amount-cell">
                                            <span class="text-green-600">Rs. {{ $bill['paid_amount'] }}</span>
                                        </td>
                                        <td class="amount-cell">
                                            @if($bill['due_amount'] > 0)
                                                <span class="text-red-600">Rs. {{ $bill['due_amount'] }}</span>
                                            @else
                                                <span class="text-green-600">Rs. 0.00</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="status-badge status-{{ strtolower($bill['status']) }}">
                                                {{ $bill['status'] }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="text-sm text-gray-600">{{ $bill['created_by'] }}</div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Summary at bottom -->
                    <div class="mt-6 text-right">
                        <div class="text-lg font-bold text-gray-900">
                            Total Bills: {{ count($billsData) }}
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Footer -->
        <div id="footer" class="summary-card mt-8">
            <div class="text-center">
                <div class="text-lg font-bold text-gray-900 mb-2">
                    {{ $billHeader->company_name ?? 'Your Company Name' }}
                </div>
                @if($billHeader)
                    <div class="text-gray-600 mb-2">
                        {{ $billHeader->company_address ?? '' }}<br>
                        Phone: {{ $billHeader->company_phone ?? '' }} | 
                        Email: {{ $billHeader->company_email ?? '' }}
                        @if($billHeader->company_website)
                            | Website: {{ $billHeader->company_website }}
                        @endif
                    </div>
                @endif
                <div class="text-sm text-gray-500 mb-4">
                    This report was generated automatically by the Animal Food Management System<br>
                    Report ID: {{ uniqid() }} | Generated on: {{ now()->format('Y-m-d H:i:s') }}
                </div>
                @if($billHeader && $billHeader->footer_text)
                    <div class="text-sm text-gray-600 italic border-t border-gray-200 pt-4">
                        {{ $billHeader->footer_text }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        // Auto-print after 1 second (optional)
        // setTimeout(() => window.print(), 1000);
        
        // Add smooth scrolling for table of contents
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>
</html>

