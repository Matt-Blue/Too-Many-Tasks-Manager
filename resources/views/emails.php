<?php

namespace App\Http\Controllers;

use Mail;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Send an e-mail reminder to the user.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function sendEmailReminder(Request $request, $id)
    {
        $user = User::findOrFail('user_id');

        Mail::send('emails.reminder', ['user' => $user], function ($m) use ($user) {
            $m->from('team@toomanytasksmanager.com', 'TMTM');

            $m->to($user->email, $user->name)->subject('Notification: Upcoming task tomorrow!');
        });
    }
}