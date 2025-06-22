<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventRegistration;
use App\Notifications\EventRegistered;
use App\Models\Participation;
use App\Models\Events;
use App\Models\User;
use App\Models\Chat;
use App\Helpers\AiHelper;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class EventRegistrationController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'reason' => 'required|string|max:1000',
            'why_you' => 'required|string|max:1000',
            'division' => 'nullable|string|max:100',
            'cv_file' => 'required|mimes:pdf|max:2048',
        ]);

        $path = $request->file('cv_file')->store('cv', 'public');

        EventRegistration::create([
            'user_id' => $request->user()->id,
            'event_id' => $request->event_id,
            'division' => $request->division,
            'reason' => $request->reason,
            'why_you' => $request->why_you,
            'cv_file' => $path,
            'status' => 'pending',
            'registered_at' => now(),
        ]);
        $event = Event::find($request->event_id);
        $request->user()->notify(new EventRegistered($event));

      
        $orgUser = $event->organizer; 

        if ($orgUser) {                    
            $orgUser->notify(new \App\Notifications\VolunteerJoinedEvent(
                $request->user()->name,            
                $event->title,                     
                route('dashboard.organisasi')      
            ));
        }

        
        if ($orgUser) {
            $user = $request->user(); 
            $organizationName = $orgUser->organizationProfile->org_name ?? 'Organisasi Kami';
            $prompt = "Tulis pesan ramah kepada {$user->name} yang baru mendaftar ke event '{$event->title}' dari organisasi {$organizationName} dan jelaskan bahwa kami akan memberikan informasi lebih lanjut apabila diterima menjadi relawan. Akhiri dengan salam dari {$organizationName}.Bold bagian yang penting dan sertakan emoji yang mendukung";
            $aiMessage = AiHelper::generateReply($prompt);

            Chat::create([
                'sender_id' => $orgUser->id,
                'receiver_id' => $user->id,
                'message' => $aiMessage,
                'sent_at' => now(),
            ]);
        }

        return redirect()->back()->with('success', true);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'event_id' => 'required|exists:events,id',
            'reason' => 'required|string',
            'why_you' => 'required|string',
            'division' => 'required|string',
            'cv_file' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        if ($request->hasFile('cv_file')) {
            $data['cv_file'] = $request->file('cv_file')->store('cv', 'public');
        }

        $data['user_id'] = auth()->id();
        EventRegistration::create($data);

        $event = Event::find($data['event_id']);
        Auth::user()->notify(new EventRegistered($event));

        return response()->json(['message' => 'Pendaftaran berhasil!']);
    }


    public function accept(Request $request)
    {

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'event_id' => 'required|exists:events,id',
        ]);

        Participation::updateOrCreate(
            [
                'user_id' => $validated['user_id'],
                'event_id' => $validated['event_id'],
            ],
            [
                'verified' => true,
            ]
        );
        EventRegistration::where('user_id', $validated['user_id'])
            ->where('event_id', $validated['event_id'])
            ->update(['status' => DB::raw("'accepted'")]);

    
        $volunteer = User::find($validated['user_id']);
        $event = Event::find($validated['event_id']);
        $volunteer->notify(new \App\Notifications\VolunteerAccepted($event));

       
        $orgUser = $event->organizer; 
        if ($orgUser && $orgUser->organizationProfile) {
            $organizationName = $orgUser->organizationProfile->org_name;

            $prompt = "Tulis pesan ramah dan profesional dari organisasi {$organizationName} kepada {$volunteer->name} bahwa mereka telah DITERIMA untuk bergabung di event <b>'{$event->title}'</b>. Gunakan format HTML. Tambahkan ucapan selamat dalam huruf kapital atau tebal di awal, buat paragraf rapi, sertakan emoji yang mendukung dan akhiri dengan salam hangat dari organisasi.";


            $aiMessage = AiHelper::generateReply($prompt);

            Chat::create([
                'sender_id' => $orgUser->id,
                'receiver_id' => $volunteer->id,
                'message' => $aiMessage,
                'sent_at' => now(),
            ]);
        }

        return back()->with([
            'success' => 'Relawan berhasil diterima.',
            'event_id' => $validated['event_id'],
        ]);

    }
}
