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
        $content = $section->content;

        // 1. Handle Top-Level File Uploads
        if ($request->hasFile('hero_image')) {
            $path = $request->file('hero_image')->store('landing', 'public');
            $content['image_url'] = Storage::disk('public')->url($path);
        }

        if ($request->hasFile('logo_image')) {
            $path = $request->file('logo_image')->store('landing', 'public');
            $content['logo_url'] = Storage::disk('public')->url($path);
        }

        // 2. Handle Gallery (Special Array Processing)
        if ($request->has('gallery')) {
            $newGallery = $request->input('gallery');
            $existingGallery = $content['gallery'] ?? [];
            
            $finalGallery = [];
            for ($i = 0; $i < 9; $i++) {
                $item = $newGallery[$i] ?? ($existingGallery[$i] ?? []);
                
                if ($request->hasFile("gallery.$i.image")) {
                    $file = $request->file("gallery.$i.image");
                    if ($file->isValid()) {
                        $path = $file->store('landing', 'public');
                        $item['image_url'] = Storage::disk('public')->url($path);
                    }
                } elseif (isset($existingGallery[$i]['image_url']) && !isset($item['image_url'])) {
                    $item['image_url'] = $existingGallery[$i]['image_url'];
                }
                
                $item['is_large'] = $request->has("gallery.$i.is_large");
                $finalGallery[$i] = $item;
            }
            
            $foundLarge = false;
            foreach ($finalGallery as $idx => $item) {
                if (($item['is_large'] ?? false) && !$foundLarge) {
                    $foundLarge = true;
                } else {
                    $finalGallery[$idx]['is_large'] = false;
                }
            }
            $content['gallery'] = $finalGallery;
        }

        // 3. Handle All Other Fields (Stats, Badge, Title, etc.)
        $nonGalleryFields = $request->except(['_token', '_method', 'hero_image', 'logo_image', 'gallery']);
        foreach ($nonGalleryFields as $key => $value) {
            $content[$key] = $value;
        }

        $section->content = $content;
        $section->save();

        return redirect()->route('admin.landing.sections.index')->with('success', "Section {$section->name} updated successfully.");
    }
}
