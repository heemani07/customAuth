<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required'
        ]);

        // Sending email
        Mail::send('emails.contact', [
            'name' => $request->name,
            'email' => $request->email,
            'msg' => $request->message
        ], function ($mail) {
            $mail->to('heemaniplodaya@gmail.com')
                 ->subject('New Contact Form Submission');
        });

        return back()->with('success', 'Your message has been sent successfully!');
    }
}
