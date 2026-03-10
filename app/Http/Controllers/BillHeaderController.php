<?php

namespace App\Http\Controllers;

use App\Models\BillHeader;
use App\Services\AuditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BillHeaderController extends Controller
{
    public function index()
    {
        $billHeader = BillHeader::getActive();
        
        // Check if storage link exists
        $storageLinkExists = file_exists(public_path('storage'));
        
        return view('admin.settings.bill-header', compact('billHeader', 'storageLinkExists'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'company_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'company_address' => 'nullable|string',
            'company_phone' => 'nullable|string|max:20',
            'company_email' => 'nullable|email|max:255',
            'company_website' => 'nullable|url|max:255',
            'tax_number' => 'nullable|string|max:100',
            'invoice_prefix' => 'nullable|string|max:10',
            'footer_text' => 'nullable|string',
        ]);

        // Get old values for audit logging
        $oldValues = [];
        $existingHeader = BillHeader::getActive();
        if ($existingHeader) {
            $oldValues = $existingHeader->toArray();
        }

        // Deactivate all existing headers
        BillHeader::where('is_active', true)->update(['is_active' => false]);

        $data = $request->except('company_logo');

        // Handle logo upload
        if ($request->hasFile('company_logo')) {
            $logoPath = $request->file('company_logo')->store('bill-headers', 'public');
            $data['company_logo'] = $logoPath;
            \Log::info('Logo uploaded:', ['path' => $logoPath]);
        }

        $data['is_active'] = true;

        // Log the data being saved
        \Log::info('Saving bill header data:', $data);

        try {
            $billHeader = BillHeader::create($data);

            \Log::info('Bill header created:', ['id' => $billHeader->id, 'data' => $billHeader->toArray()]);

            // Log bill header change for audit
            $newValues = $billHeader->toArray();
            AuditService::logBillHeaderChange($oldValues, $newValues, $request);

            return redirect()->route('admin.settings.bill-header')->with('success', 'Bill header settings saved successfully! Your company logo and information will now appear on all generated bills.');
        } catch (\Exception $e) {
            \Log::error('Error creating bill header:', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->route('admin.settings.bill-header')->with('error', 'Failed to save bill header settings. Please try again.');
        }
    }

    public function update(Request $request, BillHeader $billHeader)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'company_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'company_address' => 'nullable|string',
            'company_phone' => 'nullable|string|max:20',
            'company_email' => 'nullable|email|max:255',
            'company_website' => 'nullable|url|max:255',
            'tax_number' => 'nullable|string|max:100',
            'invoice_prefix' => 'nullable|string|max:10',
            'footer_text' => 'nullable|string',
        ]);

        // Get old values for audit logging
        $oldValues = $billHeader->toArray();

        $data = $request->except('company_logo');

        // Handle logo upload
        if ($request->hasFile('company_logo')) {
            // Delete old logo if exists
            if ($billHeader->company_logo) {
                Storage::disk('public')->delete($billHeader->company_logo);
            }
            $logoPath = $request->file('company_logo')->store('bill-headers', 'public');
            $data['company_logo'] = $logoPath;
            \Log::info('Logo updated:', ['path' => $logoPath]);
        }

        // Log the data being updated
        \Log::info('Updating bill header data:', $data);

        try {
            $billHeader->update($data);

            \Log::info('Bill header updated:', ['id' => $billHeader->id, 'data' => $billHeader->toArray()]);

            // Log bill header change for audit
            $newValues = $billHeader->fresh()->toArray();
            AuditService::logBillHeaderChange($oldValues, $newValues, $request);

            return redirect()->route('admin.settings.bill-header')->with('success', 'Bill header settings updated successfully! Your company logo and information will now appear on all generated bills.');
        } catch (\Exception $e) {
            \Log::error('Error updating bill header:', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->route('admin.settings.bill-header')->with('error', 'Failed to update bill header settings. Please try again.');
        }
    }

    public function getActiveHeader()
    {
        $header = BillHeader::getActive();
        
        // Add debug logging
        \Log::info('Bill header data:', ['header' => $header]);
        
        return response()->json($header);
    }
}
