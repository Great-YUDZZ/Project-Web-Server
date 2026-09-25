<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CertificateController extends Controller
{
    /**
     * Display a listing of certificates.
     */
    public function index(Request $request)
    {
        $query = Certificate::query();

        if ($search = $request->input('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('issuer', 'like', "%{$search}%")
                    ->orWhere('credential_id', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $certificates = $query->orderBy('order')->latest()->paginate(10)->withQueryString();
        $totalCount = Certificate::count();
        $featuredCount = Certificate::featured()->count();

        return view('admin.certificates.index', compact('certificates', 'totalCount', 'featuredCount'));
    }

    /**
     * Show the form for creating a new certificate.
     */
    public function create()
    {
        return view('admin.certificates.create');
    }

    /**
     * Store a newly created certificate in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'issuer' => ['required', 'string', 'max:255'],
            'credential_id' => ['nullable', 'string', 'max:255'],
            'issued_date' => ['nullable', 'string', 'max:100'],
            'duration_hours' => ['nullable', 'string', 'max:100'],
            'verification_status' => ['nullable', 'string', 'max:150'],
            'description' => ['nullable', 'string'],
            'credential_url' => ['nullable', 'url', 'max:500'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_featured' => ['nullable', 'boolean'],
            'certificate_file' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png,webp', 'max:5120'],
        ]);

        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['order'] = $request->input('order', 0) ?? 0;

        if ($request->hasFile('certificate_file')) {
            $path = $request->file('certificate_file')->store('certificates', 'public');
            $validated['file_path'] = $path;
        }

        Certificate::create($validated);

        return redirect()->route('admin.certificates.index')
            ->with('success', 'Sertifikat kredensial resmi berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified certificate.
     */
    public function edit(Certificate $certificate)
    {
        return view('admin.certificates.edit', compact('certificate'));
    }

    /**
     * Update the specified certificate in storage.
     */
    public function update(Request $request, Certificate $certificate)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'issuer' => ['required', 'string', 'max:255'],
            'credential_id' => ['nullable', 'string', 'max:255'],
            'issued_date' => ['nullable', 'string', 'max:100'],
            'duration_hours' => ['nullable', 'string', 'max:100'],
            'verification_status' => ['nullable', 'string', 'max:150'],
            'description' => ['nullable', 'string'],
            'credential_url' => ['nullable', 'url', 'max:500'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_featured' => ['nullable', 'boolean'],
            'certificate_file' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png,webp', 'max:5120'],
        ]);

        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['order'] = $request->input('order', 0) ?? 0;

        if ($request->hasFile('certificate_file')) {
            if ($certificate->file_path && ! Str::startsWith($certificate->file_path, ['http://', 'https://', '/images/'])) {
                Storage::disk('public')->delete($certificate->file_path);
            }

            $path = $request->file('certificate_file')->store('certificates', 'public');
            $validated['file_path'] = $path;
        }

        $certificate->update($validated);

        return redirect()->route('admin.certificates.index')
            ->with('success', 'Data sertifikat berhasil diperbarui.');
    }

    /**
     * Remove the specified certificate from storage.
     */
    public function destroy(Certificate $certificate)
    {
        if ($certificate->file_path && ! Str::startsWith($certificate->file_path, ['http://', 'https://', '/images/'])) {
            Storage::disk('public')->delete($certificate->file_path);
        }

        $certificate->delete();

        return redirect()->route('admin.certificates.index')
            ->with('success', 'Sertifikat berhasil dihapus.');
    }
}
