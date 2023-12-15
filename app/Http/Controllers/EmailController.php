<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;
use App\Http\Requests\ContactFormRequest;

class EmailController extends Controller
{
    public function sendEmail(ContactFormRequest $request)
    {
        $data = $request->validated();

        Mail::to('kozma.balazs1992@gmail.com')->send(new ContactFormMail($data['name'], $data['email'], $data['contactMessage']));

        return response()->json(['message' => 'Email sent successfully'], 200);
    }
}
