<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\Email;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function email_send() {
        $user = ['email' => 'user@test.com', 'name' => 'monsieur truc'];
        Mail::to($user['email'])->send(new Email($user));
        return view('emails.mail');
    }
}
