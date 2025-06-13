<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrganizationProfile;

class OrganisasiController extends Controller
{

    public function edit($user_id)
    {
        $profile = OrganizationProfile::with('user')->where('user_id', $user_id)->firstOrFail();

        return view('dashboard.editdata', compact('profile'));
    }


    public function update(Request $request, $user_id)
    {
        $profile = OrganizationProfile::with('user')->where('user_id', $user_id)->firstOrFail();

        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'nama_organisasi' => 'required',
            'tipe_organisasi' => 'required',
            'established_date' => 'nullable|date',
            'location' => 'required',
            'description' => 'nullable',
            'focus_area' => 'nullable',
            'province' => 'nullable',
            'city' => 'nullable',
            'postal_code' => 'nullable',
            'org_phone' => 'nullable',
            'website' => 'nullable|url',
            'logo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('logos', 'public');
            $validated['logo'] = $path;
        }

        $profile->update($validated);

        return redirect()->route('dashboard.editdata', $user_id)->with('success', 'Data berhasil diperbarui.');
    }

}

