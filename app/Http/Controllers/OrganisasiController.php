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
        // dd($request->file('logo'));
        $validated = $request->validate([
            'name' => 'sometimes|required|string',
            'email' => 'sometimes|required|email',
            'phone' => 'sometimes|required|string',
            'org_name' => 'sometimes|required|string',
            'org_type' => 'sometimes|required|string',
            'established_date' => 'nullable|date',
            'location' => 'sometimes|required|string',
            'description' => 'nullable|string',
            'focus_area' => 'nullable|string',
            'province' => 'nullable|string',
            'city' => 'nullable|string',
            'postal_code' => 'nullable|string',
            'org_phone' => 'nullable|string',
            'website' => 'nullable|url',
            'logo' => 'nullable|image|max:2048',
        ]);


        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
            $profile->logo = $logoPath;
            $validated['logo'] = $logoPath;
        }

        $profile->save();


        return redirect()->route('organisasi.edit', $user_id)->with('success', 'Data berhasil diperbarui.');
    }

}

