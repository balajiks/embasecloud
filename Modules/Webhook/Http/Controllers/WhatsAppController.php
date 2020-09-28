<?php

namespace Modules\Webhook\Http\Controllers;

use App\Entities\Chat;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Leads\Entities\Lead;
use Modules\Users\Entities\Profile;
use Modules\Users\Entities\User;

class WhatsAppController extends Controller
{
    /**
     * Receive callback POST from nexmo
     * @return Response
     */
    public function incoming(Request $request)
    {
        $request = json_decode($request->data);
        // search for lead with this phone number
        $lead = Lead::where('mobile', $this->format($request->from))->first();
        // Search user with this number
        $profile = Profile::where('mobile', $this->format($request->from))->first();
        if ($request->event == 'INBOX') {
            if (isset($lead->id)) {
                $this->saveLeadChat($lead, $request);
            }
            if (isset($profile->id)) {
                $this->saveUserChat($profile->user, $request);
            }
        }

        return ['message' => langapp('saved_successfully'), 'success' => true];
        // return ["apiwha_autoreply" => $request->text];
        if ($request->event == 'MESSAGEPROCESSED') {
            $chat = Chat::where(['id' => $request->custom_data])->first();
            if (isset($chat->id)) {
                $chat->isDelivered();
                return ['message' => 'Message marked as delivered'];
            }
        }
    }

    private function format($number)
    {
        return '+'.str_replace('+', '', $number);
    }

    private function saveLeadChat($lead, $request)
    {
        $lead->chats()->create([
                'user_id' => $lead->sales_rep,
                'message' => $request->text,
                'from' => $this->format($request->from),
                'to' => $request->to
            ]);
        $lead->update(['has_chats' => 1, 'whatsapp_optin' => 1]);
    }

    private function saveUserChat($user, $request)
    {
        $user->chats()->create([
                'user_id' => $user->id,
                'message' => $request->text,
                'from' => $this->format($request->from),
                'to' => $request->to
        ]);
        $user->update(['has_chats' => 1, 'whatsapp_optin' => 1]);
    }
}
