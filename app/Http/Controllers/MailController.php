<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\Email;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function bar() {
        Mail::to('receiver@test.com')->send(new Email());
        return view('emails.mail');
    }
}
