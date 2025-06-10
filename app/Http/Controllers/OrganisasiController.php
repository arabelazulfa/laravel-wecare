<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrganizationProfile;

class OrganisasiController extends Controller
{
    public function edit()
    {
    $profile = auth()->user()->organizationProfile; // Sesuai relasi
    return view('dashboard.editdata', compact('profile'));
    }

    public function update(Request $request, $id)
    {
        $org = OrganizationProfile::findOrFail($id);

        $org->update([
            'nama_organisasi' => $request->nama_organisasi,
            'tipe_organisasi' => $request->tipe_organisasi,
            // tambahkan kolom lain sesuai kebutuhan
        ]);

        return redirect()->back()->with('success', 'Data organisasi berhasil diperbarui');
    }
}

