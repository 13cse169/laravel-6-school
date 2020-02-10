<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\SendMail;
use File;
use Mail;

class SendMailController extends Controller
{
    public function mail()
    {
        return view('sendMail.mailForm');
    }

    public function send(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|min:3',
            'phone' => 'required|digits:10',
            'email' => 'required|email',
            'description' => 'required'
        ]);

        if($request->hasFile('attachment')){

            $data['as']         = $request->attachment->hashName();
            $data['mime']       = 'application/'.File::extension($data['as']);
            $data['attachment'] = $request->file('attachment')->getPathName();
        }

        Mail::to($request->email)->send(new SendMail($data));

        return redirect()->back()->with('mailSent', 'Your mail has been sent...!!');

    }
}
