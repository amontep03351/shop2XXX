<?php

namespace App\Http\Controllers;

use App\Models\ContactUs;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    /**
     * Show the form for editing the contact information.
     */
    public function edit()
    {
        $contactUs = ContactUs::first();

        if (!$contactUs) {
            $contactUs = ContactUs::create([
                'address_en' => '',
                'address_th' => '',
                'mail' => json_encode([]),
                'tel' => json_encode([]),
                'linkfacebook' => '',
                'linkyoutube' => '',
                'maplocation' => ''
            ]);
        }
    
        // Pass the contact info to the Blade template
        return view('contact_us.index', compact('contactUs'));
    }

    /**
     * Update the contact information in storage.
     */
    public function update(Request $request)
    {
        // Validate the request
        $request->validate([
            'address_en' => 'required|max:255',
            'address_th' => 'required|max:255',
            'mail' => 'nullable|email',
            'tel' => 'nullable|string',
            'linkfacebook' => 'nullable|url',
            'linkyoutube' => 'nullable|url',
            'maplocation' => 'nullable|string|max:255',
        ]);
   
        // Convert emails and phone numbers to JSON format
        $mail = array_map('trim', explode(',', $request->input('mail', '')));
        $tel = array_map('trim', explode(',', $request->input('tel', '')));

        // Fetch the contact information (assuming there's only one entry)
        $contactUs = ContactUs::first();

        // Update the contact information
        $contactUs->update([
            'address_en' => $request->input('address_en'),
            'address_th' => $request->input('address_th'),
            'mail' => json_encode($mail),
            'tel' => json_encode($tel),
            'linkfacebook' => $request->input('linkfacebook'),
            'linkyoutube' => $request->input('linkyoutube'),
            'maplocation' => $request->input('maplocation'),
        ]);

        // Redirect back with success message
        return redirect()->route('contactus.edit')->with('success', 'Contact information updated successfully!');
    }
}
