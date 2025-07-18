<?php

namespace App\Http\Controllers;

use App\Helpers\TranslatorHelper;
use App\Models\Contact;
use App\Rules\ReCaptcha;
use Illuminate\Http\Request;
use App\Mail\CustomerThankYouMail;
use App\Mail\AdminNotificationMail;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

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
            'g-recaptcha-response' => ['required', new ReCaptcha]
        ]);

        $originalMessage = $request->input('your-message');

        // 🔄 Translate using helper
        $translatedMessage = TranslatorHelper::translateToEnglish($originalMessage);


        $contact = Contact::create([
            'name' => $request->input('your-name'),
            'email' => $request->input('your-email'),
            'phone' => $request->input('your-phone'),
            'company' => $request->input('your-company'),
            'message' => $originalMessage,
            'translated' => $translatedMessage,
        ]);

        // Send emails
        Mail::to($request->input('your-email'))->send(new CustomerThankYouMail($contact));
        Mail::to(env('ADMIN_EMAIL'))->send(new AdminNotificationMail($contact));

        return response()->json(['message' => 'Thank you for contacting us!']);
    }
}
