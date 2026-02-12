<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LandingSection;
use Illuminate\Support\Facades\Storage;
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
            $path = $request->file('hero_image')->store('landing', 'public');
            $newContent['image_url'] = Storage::disk('public')->url($path);
        }

        if ($request->hasFile('logo_image')) {
            $path = $request->file('logo_image')->store('landing', 'public');
            $newContent['logo_url'] = Storage::disk('public')->url($path);
        }

        // Handle Gallery Uploads
        if ($request->has('gallery')) {
            $galleryData = $request->input('gallery');
            
            // Laravel handles array file uploads specifically
            if ($request->hasFile('gallery')) {
                $uploadedFiles = $request->file('gallery');
                foreach ($uploadedFiles as $index => $itemFile) {
                    if (isset($itemFile['image']) && $itemFile['image']->isValid()) {
                        $path = $itemFile['image']->store('landing', 'public');
                        $galleryData[$index]['image_url'] = Storage::disk('public')->url($path);
                    }
                }
            }
            
            // Ensure only one item is marked as large
            $foundLarge = false;
            foreach ($galleryData as $index => $item) {
                if (isset($item['is_large']) && $item['is_large'] == 'on') {
                    if (!$foundLarge) {
                        $galleryData[$index]['is_large'] = true;
                        $foundLarge = true;
                    } else {
                        $galleryData[$index]['is_large'] = false;
                    }
                } else {
                    $galleryData[$index]['is_large'] = (isset($item['is_large']) && $item['is_large'] === true);
                }
            }
            $newContent['gallery'] = $galleryData;
        }

        // Standard fields from request
        $fields = $request->except(['_token', '_method', 'hero_image', 'logo_image', 'gallery']);
        
        foreach ($fields as $key => $value) {
            $newContent[$key] = $value;
        }

        $section->update([
            'content' => $newContent
        ]);

        return redirect()->route('admin.landing.sections.index')->with('success', "Section {$section->name} updated successfully.");
    }
}
