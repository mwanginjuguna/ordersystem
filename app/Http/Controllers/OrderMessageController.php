<?php

namespace App\Http\Controllers;

use App\Mail\NewMessageReceived;
use App\Mail\OrderReceived;
use App\Models\Order;
use App\Models\OrderMessage;
use App\Models\User;
use App\Notifications\AdminNotification;
use Illuminate\Http\Request;
use \Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;

class OrderMessageController extends Controller
{
    public $admin;

    // fetch all messages from db
    public function messagesIndex(Request $request, $id): JsonResponse
    {
        // initialize admin
        $this->admin = User::query()->where('role', '=', 'A')->first();

        $data = json_decode($request->getContent(), true);

        $order = Order::findOrFail($id);

        // all messages for $this order
        $messages = OrderMessage::query()
            ->where('order_id', '=', $data['order_id'])
            ->oldest()
            ->get();

        return response()->json([
            //'client' => $order->user_id,
            //'writer' => $order->assigned_to,
            'messages' => $messages
        ]);
    }


    // save messages to db - admin only
    public function messagesCreate( Request $request, $id): JsonResponse
    {
        // initialize admin
        $this->admin = User::query()->where('role', '=', 'A')->first();

        $data = json_decode($request->getContent(), true);

        // init order
        $order = Order::findOrFail($id);

        // create new message
        // if message sent by admin, is it meant for Client or Writer?
        // How does that affect how the message is saved
        $orderMessage = OrderMessage::create([
            'user_id' => $data['user_id'],
            'order_id' => $data['order_id'] ?? $order->id,
            'message' => $data['message'],
            'send_to_client' => $data['receiver'] === 'client' ?? false,
            'send_to_writer' => $data['receiver'] === 'writer' ?? false,
        ]);
        $admin = User::query()->where('role', '=', 'A')->first();
        $user = User::query()
            ->where('id', '=', $order->user_id)
            ->first();
        $notifyAdmin = [
            'orderId' => $order->id,
            'username' => $user->name,
            'title' => 'Order #'.$order->id.' Message.',
            'content' => 'A new message has been sent on Order #'.$order->id.' by '.$user->name.
                '. "'.$orderMessage->message.'".',
            'url' => route('orders.show', $order->id),
            'action' => 'View Order'
        ];

        if ($admin->id !== $orderMessage->user_id)
        {
            $admin->notify(new AdminNotification($notifyAdmin));
        } else {
            $mailData = [
                'title'=> 'Order #'.$order->id.' Message.',
                'username' => $user->name,
                'content' => 'A new message has been sent on Order #'.$order->id.'. "'.$orderMessage->message.'".',
                'url' => route('orders.show', $order->id),
                'action' => 'View Order'
            ];

            Mail::to($user)->queue(
                mailable: new NewMessageReceived($mailData)
            );
        }

        // load messages
        $messages = OrderMessage::query()
            ->where('order_id', '=', $data['order_id'])
            ->latest()
            ->get();

        return response()->json([
            "response" => "Success, Message sent",
            "client" => $order->user_id,
            "writer" => $order->assigned_to
        ]);
    }

    // mark message as read/seen

    // allow writer/client to see message

}
