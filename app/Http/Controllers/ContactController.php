<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\CustomerThankYouMail;
use App\Mail\AdminNotificationMail;

class ContactController extends Controller
{
    public function submit(Request $request)
    {
        $request->validate([
            'your-name' => 'required|string|max:255',
            'your-email' => 'required|email|max:255',
            'your-phone' => 'nullable|string|max:20',
            'your-company' => 'nullable|string|max:255',
            'your-message' => 'required|string',
        ]);

        $contact = Contact::create([
            'name' => $request->input('your-name'),
            'email' => $request->input('your-email'),
            'phone' => $request->input('your-phone'),
            'company' => $request->input('your-company'),
            'message' => $request->input('your-message'),
        ]);

        // Send emails
        Mail::to($request->input('your-email'))->send(new CustomerThankYouMail($contact));
        // Mail::to(env('ADMIN_EMAIL'))->send(new AdminNotificationMail($contact));

        return response()->json(['message' => 'Thank you for contacting us!']);
    }
}
