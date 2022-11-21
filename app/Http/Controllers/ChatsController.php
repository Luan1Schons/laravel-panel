<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Message;
use App\Models\ChatBans;
use Illuminate\Http\Request;
use App\Models\MessagesReport;
use Illuminate\Support\Facades\Auth;

class ChatsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Fetch all messages
     *
     * @return Message
     */
    public function fetchMessages()
    {
        return Message::with('user', 'report')->get();
    }

    /**
     * Persist message to database
     *
     * @param  Request $request
     * @return Response
     */
    public function sendMessage(Request $request)
    {
        $user = Auth::user();
        $chatBans = ChatBans::where('user_id', $user->id)->first();

        if($chatBans){
            return response()->json(['status' => 'Você está banido do chat.', 'code' => 403]);
        }

        $message = $user->messages()->create([
            'message' => $request->input('message')
        ]);

        $messageData = Message::with('user', 'report')->where('id', $message->id)->first();
        //broadcast(new \App\Events\MessageSent($user, $message));
        event(new \App\Events\MessageSent($user, $messageData));
        return response()->json(['status' =>  $messageData, 'code' => 201]);
    }

    /**
     * Persist message to database
     *
     * @param  Request $request
     * @return Response
     */
    public function deleteMessage(Request $request)
    {
        $user = Auth::user();
        $message = new Message();
        $message = Message::where('id', $request->input('id'))->delete();
        event(new \App\Events\MessageDelete($user, $request->input('id')));
        return ['status' => 'Message Deleted!'];
    }

    public function banUser(Request $request)
    {
        $user = Auth::user();

        try {

            ChatBans::create([
                'banned_by' => $user->id,
                'user_id' => $request->input('user_id')
            ]);

            if($request->input('removeReport') == true){
                $reportData = MessagesReport::where('user_reported_id', $request->input('user_id'))->delete();
            }

            return ['status' => 'Usuário banido com sucesso.', 'code' => 201];

        } catch (Exception $e) {
            return ['status' => $e->getMessage(), 'code' => 500];
        }
    }

    public function chatBans(Request $request)
    {
        try {
            $bans = ChatBans::where('user_id', $request->input('user_id'))->first();
            return ['data' => $bans, 'code' => 201];
        } catch (Exception $e) {
            return ['status' => $e->getMessage(), 'code' => 500];
        }
    }

    public function reportMessage(Request $request){

        $user = Auth::user();
        $messagesReport = new MessagesReport();

        try {

            $data = $request->all();
            $messagesReport->create([
                'user_id' => $user->id,
                'user_reported_id' => $data['user_reported_id'],
                'message_id' => $data['message_id'],
                'motive' => strip_tags($data['motive']),
            ]);

            return response()->json(['status' => 'Mensagem reportada com sucesso.', 'code' => 201]);
        } catch (Exception $e) {
            return response()->json(['status' => $e->getMessage(), 'code' => 500]);
        }
    }
}
