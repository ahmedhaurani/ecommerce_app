<?php

namespace App\Livewire\Admin;


use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\WebsiteSetting;
use Illuminate\Support\Facades\Storage;

class WebsiteSettings extends Component
{
    use WithFileUploads;

    // Define properties for each setting field
    public $site_name, $site_description, $logo, $favicon, $meta_description, $meta_keyword;
    public $header_ads_text, $footer_text, $facebook, $instagram, $snapchat, $youtube, $x;
    public $maintenance_mode;

    // To hold the currently stored logo and favicon paths
    public $current_logo, $current_favicon;

    public function mount()
    {
        // Fetch the settings data or create a new record if it doesn't exist
        $settings = WebsiteSetting::firstOrNew();

        // Set the properties with the existing values (if available)
        $this->site_name = $settings->site_name;
        $this->site_description = $settings->site_description;
        $this->current_logo = $settings->logo;
        $this->current_favicon = $settings->favicon;
        $this->meta_description = $settings->meta_description;
        $this->meta_keyword = $settings->meta_keyword;
        $this->header_ads_text = $settings->header_ads_text;
        $this->footer_text = $settings->footer_text;
        $this->facebook = $settings->facebook;
        $this->instagram = $settings->instagram;
        $this->snapchat = $settings->snapchat;
        $this->youtube = $settings->youtube;
        $this->x = $settings->x;
        $this->maintenance_mode = $settings->maintenance_mode;
    }

    public function saveSettings()
    {
        // Validate inputs
        $validatedData = $this->validate([
            'site_name' => 'required|string|max:255',
            'site_description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'favicon' => 'nullable|image|mimes:ico,png|max:512',
            'meta_description' => 'nullable|string',
            'meta_keyword' => 'nullable|string',
            'header_ads_text' => 'nullable|string',
            'footer_text' => 'nullable|string',
            'facebook' => 'nullable|url',
            'instagram' => 'nullable|url',
            'snapchat' => 'nullable|url',
            'youtube' => 'nullable|url',
            'x' => 'nullable|url',
            'maintenance_mode' => 'boolean',
        ]);

        // Fetch the existing settings or create a new record
        $settings = WebsiteSetting::firstOrNew();

        // Assign the validated data to the settings
        $settings->site_name = $this->site_name;
        $settings->site_description = $this->site_description;
        $settings->meta_description = $this->meta_description;
        $settings->meta_keyword = $this->meta_keyword;
        $settings->header_ads_text = $this->header_ads_text;
        $settings->footer_text = $this->footer_text;
        $settings->facebook = $this->facebook;
        $settings->instagram = $this->instagram;
        $settings->snapchat = $this->snapchat;
        $settings->youtube = $this->youtube;
        $settings->x = $this->x;
        $settings->maintenance_mode = $this->maintenance_mode;

        // Handle file upload for logo
        if ($this->logo) {
            if ($this->current_logo) {
                Storage::delete($this->current_logo);
            }
            $settings->logo = $this->logo->store('public/logos');
        }

        // Handle file upload for favicon
        if ($this->favicon) {
            if ($this->current_favicon) {
                Storage::delete($this->current_favicon);
            }
            $settings->favicon = $this->favicon->store('public/favicons');
        }

        // Save settings to the database and update current_logo and current_favicon
        $settings->save();
        $this->current_logo = $settings->logo;
        $this->current_favicon = $settings->favicon;

        // Debug output
        session()->flash('success', 'Settings saved successfully.');

        // Emit an event to refresh data after save
        $this->dispatch('settingsUpdated');
    }


    public function render()
    {
        return view('livewire.admin.settings-component');
    }
}
