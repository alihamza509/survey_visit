<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function edit()
    {
        $settings = Setting::first();
        return view('appsetting.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'app_title' => 'required|string',
            'app_logo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'login_logo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'favicon_logo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $settings = Setting::first();
        if (!$settings) {
            $settings = new Setting();
        }

        $settings->app_title = $request->app_title;
$settings->footer_text = $request->footer_text;
        if ($request->hasFile('app_logo')) {
            $settings->app_logo = $request->file('app_logo')->store('public/logos');
        }

        if ($request->hasFile('login_logo')) {
            $settings->login_logo = $request->file('login_logo')->store('public/logos');
        }

        if ($request->hasFile('favicon_logo')) {
            $settings->favicon_logo = $request->file('favicon_logo')->store('public/logos');
        }

        $settings->save();

        return redirect()->back()->with('success', 'Settings updated successfully.');
    }
}
