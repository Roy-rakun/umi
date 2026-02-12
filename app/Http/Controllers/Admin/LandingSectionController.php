<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LandingSection;
use Illuminate\Http\Request;

class LandingSectionController extends Controller
{
    public function index()
    {
        $sections = LandingSection::all();
        return view('admin.landing.sections.index', compact('sections'));
    }

    public function edit(LandingSection $section)
    {
        return view('admin.landing.sections.edit', compact('section'));
    }

    public function update(Request $request, LandingSection $section)
    {
        $newContent = $section->content;

        // Handle File Uploads
        if ($request->hasFile('hero_image')) {
            $file = $request->file('hero_image');
            $filename = 'hero_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/landing'), $filename);
            $newContent['image_url'] = asset('uploads/landing/' . $filename);
        }

        if ($request->hasFile('logo_image')) {
            $file = $request->file('logo_image');
            $filename = 'logo_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/landing'), $filename);
            $newContent['logo_url'] = asset('uploads/landing/' . $filename);
        }

        // Standard fields from request
        $fields = $request->except(['_token', '_method', 'hero_image', 'logo_image']);
        
        foreach ($fields as $key => $value) {
            $newContent[$key] = $value;
        }

        $section->update([
            'content' => $newContent
        ]);

        return redirect()->route('admin.landing.sections.index')->with('success', "Section {$section->name} updated successfully.");
    }
}
