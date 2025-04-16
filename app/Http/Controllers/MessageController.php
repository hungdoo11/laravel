<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class MessageController extends Controller
{
    // public function inbox()
    // {
    //     /** @var \App\Models\User $user */
    //     $user = auth()->user();

    //     if (!$user) {
    //         return redirect()->route('login')->with('error', 'Bạn cần đăng nhập');
    //     }

    //     // Admin: lấy danh sách user đã nhắn tin
    //     if ($user->level == 1) {
    //         $conversations = Message::select('from_user_id')
    //             ->where('to_user_id', $user->id)
    //             ->distinct()
    //             ->with('fromUser')
    //             ->get();
    //     } else {
    //         // User: chỉ xem chat với admin
    //         $conversations = User::where('level', 1)->get();
    //     }

    //     return view('chat.inbox', compact('conversations'));
    // }

    // public function showConversation($userId)
    // {
    //     $currentUserId = auth()->id();

    //     $messages = Message::where(function ($query) use ($currentUserId, $userId) {
    //         $query->where('from_user_id', $currentUserId)
    //             ->where('to_user_id', $userId);
    //     })->orWhere(function ($query) use ($currentUserId, $userId) {
    //         $query->where('from_user_id', $userId)
    //             ->where('to_user_id', $currentUserId);
    //     })->orderBy('created_at')->get();

    //     return view('chat.conversation', compact('messages', 'userId'));
    // }
    public function send(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'receiver_id' => 'required|integer',
        ]);

        // Tạo tin nhắn mới
        $message = new Message();
        $message->from_user_id = auth()->id();  // Gán đúng người gửi
        $message->to_user_id = $request->receiver_id;  // Gán người nhận
        $message->message = $request->message;
        $message->save();

        // Trả về thông tin tin nhắn gửi đi dưới dạng JSON
        return response()->json([
            'success' => true,
            'sender' => auth()->user()->full_name,
            'message' => $request->message
        ]);
    }







    // public function index()
    // {
    //     $user = Auth::user();
    //     $admin = User::where('level', 1)->first();

    //     $messages = Message::where(function ($q) use ($user, $admin) {
    //         $q->where('sender_id', $user->id)->where('receiver_id', $admin->id);
    //     })->orWhere(function ($q) use ($user, $admin) {
    //         $q->where('sender_id', $admin->id)->where('receiver_id', $user->id);
    //     })->orderBy('created_at')->get();

    //     return view('chat.index', compact('messages', 'admin'));
    // }
    // public function sendMessage(Request $request)
    // {
    //     $validated = $request->validate([
    //         'message' => 'required|string',
    //         'receiver_id' => 'required|integer',
    //     ]);

    //     $message = new Message();
    //     $message->sender_id = auth()->id();  // ID người gửi
    //     $message->receiver_id = $request->receiver_id;  // ID người nhận
    //     $message->message = $request->message;
    //     $message->save();

    //     // Trả về thông tin tin nhắn gửi đi
    //     return response()->json([
    //         'success' => true,
    //         'sender' => auth()->user()->full_name,  // Tên người gửi
    //         'message' => $request->message
    //     ]);
    // }
}
