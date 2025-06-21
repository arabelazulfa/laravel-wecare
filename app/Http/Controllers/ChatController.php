<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    // 🧠 Fungsi reusable untuk ambil daftar kontak dengan unread count & last message
    private function getChatList($userId)
    {
        return User::where('id', '!=', $userId)
            ->where(function ($q) use ($userId) {
                $q->whereHas('sentMessages', function ($q2) use ($userId) {
                    $q2->where('receiver_id', $userId);
                })->orWhereHas('receivedMessages', function ($q2) use ($userId) {
                    $q2->where('sender_id', $userId);
                });
            })
            ->get()
            ->map(function ($contact) use ($userId) {
                $unreadCount = Chat::where('sender_id', $contact->id)
                    ->where('receiver_id', $userId)
                    ->whereNull('read_at')
                    ->count();

                $lastMessage = Chat::where(function ($q) use ($userId, $contact) {
                    $q->where('sender_id', $userId)->where('receiver_id', $contact->id);
                })
                    ->orWhere(function ($q) use ($userId, $contact) {
                        $q->where('sender_id', $contact->id)->where('receiver_id', $userId);
                    })
                    ->orderByDesc('sent_at')
                    ->orderByDesc('created_at')
                    ->first();

                $contact->unread_count = $unreadCount;
                $contact->last_message = $lastMessage ? $lastMessage->message : 'Belum ada pesan';
                $contact->last_message_time = $lastMessage ? $lastMessage->sent_at : null;

                return $contact;
            })
            ->sortByDesc('last_message_time') // urutkan berdasarkan waktu terakhir chat
            ->values(); // reset indeks
    }

    private function getChatListWithOrgProfile($userId)
    {
        return User::with('organizationProfile')
            ->where('id', '!=', $userId)
            ->where(function ($q) use ($userId) {
                $q->whereHas('sentMessages', function ($q2) use ($userId) {
                    $q2->where('receiver_id', $userId);
                })->orWhereHas('receivedMessages', function ($q2) use ($userId) {
                    $q2->where('sender_id', $userId);
                });
            })
            ->get()
            ->map(function ($contact) use ($userId) {
                $unreadCount = Chat::where('sender_id', $contact->id)
                    ->where('receiver_id', $userId)
                    ->whereNull('read_at')
                    ->count();

                $lastMessage = Chat::where(function ($q) use ($userId, $contact) {
                    $q->where('sender_id', $userId)->where('receiver_id', $contact->id);
                })
                    ->orWhere(function ($q) use ($userId, $contact) {
                        $q->where('sender_id', $contact->id)->where('receiver_id', $userId);
                    })
                    ->orderByDesc('sent_at')
                    ->orderByDesc('created_at')
                    ->first();

                $contact->unread_count = $unreadCount;
                $contact->last_message = $lastMessage ? $lastMessage->message : 'Belum ada pesan';
                $contact->last_message_time = $lastMessage ? $lastMessage->sent_at : null;

                return $contact;
            })
            ->sortByDesc('last_message_time')
            ->values();
    }


    // 💬 Halaman chat organisasi
    public function index(Request $request)
    {
        $userId = auth()->id();
        $query = $request->input('q'); // ambil input pencarian

        $chatList = $this->getChatList($userId);

        // jika ada query pencarian, filter hasilnya
        if ($query) {
            $chatList = $chatList->filter(function ($contact) use ($query) {
                return stripos($contact->name, $query) !== false;
            });
        }

        return view('chat.index', [
            'chatList' => $chatList,
            'contact' => null,
            'messages' => [],
        ]);

    }


    // 👁 Tampilkan obrolan dengan user tertentu
    public function show($id)
    {
        $user = User::findOrFail($id);
        $authId = Auth::id();
        $chatList = $this->getChatList($authId);

        $messages = Chat::where(function ($q) use ($authId, $id) {
            $q->where('sender_id', $authId)->where('receiver_id', $id);
        })
            ->orWhere(function ($q) use ($authId, $id) {
                $q->where('sender_id', $id)->where('receiver_id', $authId);
            })
            ->orderBy('sent_at')
            ->get();

        Chat::where('sender_id', $id)
            ->where('receiver_id', $authId)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return view('chat.show', compact('user', 'messages', 'chatList'));
    }

    // 🧑‍🤝‍🧑 Halaman chat volunteer
    public function volunteerIndex(Request $request)
    {
        $userId = auth()->id();
        $query = $request->input('q'); // ambil input pencarian

        $chatList = $this->getChatListWithOrgProfile($userId);


        // jika ada query pencarian, filter hasilnya
        if ($query) {
            $chatList = $chatList->filter(function ($contact) use ($query) {
                return stripos($contact->name, $query) !== false;
            });
        }

        return view('chat.indexvolunteer', [
            'chatList' => $chatList,
            'contact' => null,
            'messages' => [],
        ]);

    }


    // 👁 Halaman show chat untuk volunteer
    public function volunteerShow($id)
    {
        $receiver = User::with('organizationProfile')->findOrFail($id);
        $userId = auth()->id();
        $chatList = $this->getChatListWithOrgProfile($userId);


        $messages = Chat::where(function ($q) use ($userId, $id) {
            $q->where('sender_id', $userId)->where('receiver_id', $id);
        })
            ->orWhere(function ($q) use ($userId, $id) {
                $q->where('sender_id', $id)->where('receiver_id', $userId);
            })
            ->orderBy('sent_at')
            ->get();

        Chat::where('sender_id', $id)
            ->where('receiver_id', $userId)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return view('chat.showvolunteer', [
            'messages' => $messages,
            'user' => $receiver,
            'chatList' => $chatList,
        ]);
    }

    // 📤 Kirim pesan dari volunteer
    public function volunteerSend(Request $request)
    {
        Chat::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
            'sent_at' => now(),
        ]);

        return redirect()->route('volunteer.chat.show', $request->receiver_id);
    }

    // 📤 Kirim pesan dari organisasi
    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string|max:1000',
        ]);

        Chat::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
            'sent_at' => now(),
        ]);

        return redirect()->route('chat.show', $request->receiver_id);
    }
}