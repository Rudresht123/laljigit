<?php

namespace App\Http\Controllers\systemsetting;

use App\Http\Controllers\Controller;
use App\Models\MailSetting;
use Illuminate\Http\Request;

class EmailConfiguration extends Controller
{
    public function index(){
        $email=MailSetting::first();
       if($email){
        return view('admin_panel.EmailTemplate.emailconfig',compact('email'));
       }
    }
    public function UpdateEmailConfig(Request $request,$id)
    {
       $validatedData= $request->validate([
 // corrected typo
            'mail_mailer' => 'required',
            'mail_host' => 'required',
            'mail_port' => 'required',
            'mail_username' => 'required',
            'mail_encription' => 'required',
            'mail_password' => 'required',
            'mail_fromaddress' => 'required', // corrected typo
            'mail_fromname' => 'required' // corrected typo
        ]);
    
        // Find the existing record by ID
        $mailSetting = MailSetting::findOrFail($id);
    
        // Update the fields with the request data
     $mailSetting->fill($validatedData);
    
        // Save the updated record
        if ($mailSetting->save()) {
            return redirect()->back()->with(['success' =>'Mail data updated successfully!']);
        } else {
            return  redirect()->with()->back(['success' => 'Failed to update mail data.']);
        }
    }
}
