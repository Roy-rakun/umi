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
        $sections = LandingSection::orderBy('sort_order', 'asc')->get();
        return view('admin.landing.sections.index', compact('sections'));
    }

    public function reorder(Request $request, LandingSection $section, $direction)
    {
        $currentOrder = $section->sort_order;
        
        if ($direction === 'up') {
            $swapSection = LandingSection::where('sort_order', '<', $currentOrder)
                ->orderBy('sort_order', 'desc')
                ->first();
        } else {
            $swapSection = LandingSection::where('sort_order', '>', $currentOrder)
                ->orderBy('sort_order', 'asc')
                ->first();
        }

        if ($swapSection) {
            $section->sort_order = $swapSection->sort_order;
            $swapSection->sort_order = $currentOrder;
            
            $section->save();
            $swapSection->save();
            
            return back()->with('success', 'Order updated successfully.');
        }

        return back()->with('error', 'Already at the edge.');
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
            $content['image_url'] = '/storage/' . $path;
        }

        if ($request->hasFile('logo_image')) {
            $path = $request->file('logo_image')->store('landing', 'public');
            $content['logo_url'] = '/storage/' . $path;
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
                        $item['image_url'] = '/storage/' . $path;
                    }
                } elseif (isset($existingGallery[$i]['image_url']) && !isset($item['image_url'])) {
                    $item['image_url'] = $existingGallery[$i]['image_url'];
                }
                
                $item['is_large'] = $request->boolean("gallery.$i.is_large");
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

        // 3. Handle Sosmed Items
        if ($request->has('items')) {
            $newItems = $request->input('items');
            $existingItems = $content['items'] ?? [];
            
            $finalItems = [];
            foreach ($newItems as $i => $item) {
                if ($request->hasFile("items.$i.image")) {
                    $file = $request->file("items.$i.image");
                    if ($file->isValid()) {
                        $path = $file->store('landing', 'public');
                        $item['image_url'] = '/storage/' . $path;
                    }
                } elseif (isset($existingItems[$i]['image_url']) && !isset($item['image_url'])) {
                    $item['image_url'] = $existingItems[$i]['image_url'];
                }
                $finalItems[$i] = $item;
            }
            $content['items'] = $finalItems;
        }

        // 4. Handle All Other Fields (Stats, Badge, Title, etc.)
        $nonGalleryFields = $request->except(['_token', '_method', 'hero_image', 'logo_image', 'gallery', 'items', 'buttons']);
        foreach ($nonGalleryFields as $key => $value) {
            $content[$key] = $value;
        }

        // 5. Handle Dynamic Buttons
        if ($request->has('buttons')) {
            $buttons = collect($request->input('buttons'))
                ->filter(fn($btn) => !empty($btn['text']))
                ->values()
                ->all();
            $content['buttons'] = $buttons;
        } else {
            $content['buttons'] = [];
        }

        $section->content = $content;
        $section->save();

        return redirect()->route('admin.landing.sections.index')->with('success', "Section {$section->name} updated successfully.");
    }
}
