<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    public function index()
    {
        return view('pages.contact');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:20',
            'email' => 'required|email:rfc,dns|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:40',
            'message' => 'required|string|max:100',
        ]);

        $contact = Contact::create($request->all());

        try {
            \Illuminate\Support\Facades\Mail::to($contact->email)->send(new \App\Mail\ContactUserMail($contact));
            \Illuminate\Support\Facades\Mail::to('info.geofenceattendance@gmail.com')->send(new \App\Mail\ContactAdminMail($contact));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send contact emails: ' . $e->getMessage());
        }

        return redirect()->back()->with('contact_success', 'Thank you for contacting us! We will get back to you shortly.');
    }
}
