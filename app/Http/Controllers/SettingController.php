<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    public function index()
    {
        $settings = [
            'currency' => Setting::getValue('currency', 'EGP'),
            'business_name' => Setting::getValue('business_name', ''),
            'business_address' => Setting::getValue('business_address', ''),
            'business_phone' => Setting::getValue('business_phone', ''),
            'business_email' => Setting::getValue('business_email', ''),
            'default_session_duration' => Setting::getValue('default_session_duration', '60'),
            'auto_close_sessions' => Setting::getValue('auto_close_sessions', '0'),
        ];
        return view('settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'currency' => 'required|in:EGP,USD,EUR',
            'business_name' => 'nullable|string|max:255',
            'business_address' => 'nullable|string',
            'business_phone' => 'nullable|string|max:20',
            'business_email' => 'nullable|email|max:255',
            'default_session_duration' => 'nullable|integer|min:1',
            'auto_close_sessions' => 'required|in:0,1'
        ]);

        $settings = $request->only([
            'currency', 'business_name', 'business_address', 
            'business_phone', 'business_email', 'default_session_duration', 'auto_close_sessions'
        ]);

        foreach ($settings as $key => $value) {
            Setting::setValue($key, $value);
        }

        return redirect()->route('settings.index')->with('success', 'Settings updated successfully.');
    }
}
