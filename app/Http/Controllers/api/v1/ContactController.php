<?php

namespace App\Http\Controllers\api\v1;

use App\Models\Contact;
use App\Rules\ReCaptcha;
use Illuminate\Http\Request;
use App\Helpers\TranslatorHelper;
use App\Mail\CustomerThankYouMail;
use App\Mail\AdminNotificationMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function submit(Request $request)
    {
        // ✅ Step 1: Validate the form input
        $validated = $request->validate([
            'yourName' => 'required|string|max:255',
            'yourEmail' => 'required|email|max:255',
            'yourPhone' => 'nullable|string|max:20',
            'yourCompany' => 'nullable|string|max:255',
            'yourMessage' => 'required|string|max:3000',
        ]);

        // ✅ Step 2: Translate the message (e.g., to English)
        $originalMessage = $validated['yourMessage'];
        $translatedMessage = TranslatorHelper::translateToEnglish($originalMessage);

        // ✅ Step 3: Save to DB
        $contact = Contact::create([
            'name' => $validated['yourName'],
            'email' => $validated['yourEmail'],
            'phone' => $validated['yourPhone'],
            'company' => $validated['yourCompany'],
            'message' => $originalMessage,
            'translated' => $translatedMessage,
        ]);

        // ✅ Step 4: Send acknowledgment to user
        Mail::to($validated['yourEmail'])->send(new CustomerThankYouMail($contact));

        // ✅ Step 5: Notify admin
        Mail::to(env('ADMIN_EMAIL', 'admin@example.com'))->send(new AdminNotificationMail($contact));

        // ✅ Step 6: Return JSON response
        return response()->json([
            'message' => 'Thank you for contacting us!',
            'status' => 'success'
        ]);
    }
}
