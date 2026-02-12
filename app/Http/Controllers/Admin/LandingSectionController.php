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

        // Handle Gallery Uploads
        if ($request->has('gallery')) {
            $galleryData = $request->input('gallery');
            if ($request->hasFile('gallery')) {
                foreach ($request->file('gallery') as $index => $itemFile) {
                    if (isset($itemFile['image'])) {
                        $file = $itemFile['image'];
                        $filename = 'gallery_' . time() . '_' . $index . '.' . $file->getClientOriginalExtension();
                        $file->move(public_path('uploads/landing'), $filename);
                        $galleryData[$index]['image_url'] = asset('uploads/landing/' . $filename);
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
                        $galleryData[$index]['is_large'] = false; // Unset if another large is found
                    }
                } else {
                    $galleryData[$index]['is_large'] = false; // Ensure it's explicitly false if not 'on'
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
