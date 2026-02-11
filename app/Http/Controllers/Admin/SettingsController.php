<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SiteSetting;

class SettingsController extends Controller
{
    /**
     * Display settings organized by groups
     */
    public function index()
    {
        $settings = SiteSetting::getAllGrouped();
        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Show the form for editing settings of a specific group
     */
    public function edit($group)
    {
        $settings = SiteSetting::where('group', $group)->get();
        return view('admin.settings.edit', compact('settings', 'group'));
    }

    /**
     * Update the specified settings
     */
    public function update(Request $request, $group)
    {
        $settings = SiteSetting::where('group', $group)->get();

        foreach ($settings as $setting) {
            if ($request->has($setting->key)) {
                $setting->value = $request->input($setting->key);
                $setting->save();
            }
        }

        return redirect()
            ->route('admin.settings.edit', $group)
            ->with('success', ucfirst($group) . ' settings updated successfully!');
    }

    /**
     * Show the form for creating a new setting
     */
    public function create()
    {
        $groups = SiteSetting::distinct('group')->pluck('group');
        return view('admin.settings.create', compact('groups'));
    }

    /**
     * Store a newly created setting
     */
    public function store(Request $request)
    {
        $request->validate([
            'key' => 'required|string|unique:site_settings,key|max:255',
            'label' => 'required|string|max:255',
            'type' => 'required|in:text,textarea,code,image,number,email,url',
            'group' => 'required|string|max:255',
            'value' => 'nullable',
            'description' => 'nullable|string',
        ]);

        SiteSetting::create($request->all());

        return redirect()
            ->route('admin.settings.index')
            ->with('success', 'Setting created successfully!');
    }

    /**
     * Show the form for editing a specific setting
     */
    public function editSingle($id)
    {
        $setting = SiteSetting::findOrFail($id);
        $groups = SiteSetting::distinct('group')->pluck('group');
        return view('admin.settings.edit-single', compact('setting', 'groups'));
    }

    /**
     * Update a specific setting
     */
    public function updateSingle(Request $request, $id)
    {
        $setting = SiteSetting::findOrFail($id);

        $request->validate([
            'key' => 'required|string|max:255|unique:site_settings,key,' . $id,
            'label' => 'required|string|max:255',
            'type' => 'required|in:text,textarea,code,image,number,email,url',
            'group' => 'required|string|max:255',
            'value' => 'nullable',
            'description' => 'nullable|string',
        ]);

        $setting->update($request->all());

        return redirect()
            ->route('admin.settings.index')
            ->with('success', 'Setting updated successfully!');
    }

    /**
     * Remove the specified setting
     */
    public function destroy($id)
    {
        $setting = SiteSetting::findOrFail($id);
        $setting->delete();

        return redirect()
            ->route('admin.settings.index')
            ->with('success', 'Setting deleted successfully!');
    }

    /**
     * Clear all settings cache
     */
    public function clearCache()
    {
        SiteSetting::clearCache();

        return redirect()
            ->back()
            ->with('success', 'Settings cache cleared successfully!');
    }
}
