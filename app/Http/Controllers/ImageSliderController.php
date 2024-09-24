<?php

namespace App\Http\Controllers;

use App\Models\ImageSlider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageSliderController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('perPage', 10);

        $query = ImageSlider::query();

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title_en', 'like', "%{$search}%")
                  ->orWhere('title_th', 'like', "%{$search}%");
            });
        }

        $imageSliders = $query->orderBy('display_order')
                              ->paginate($perPage);

        return view('image_sliders.index', compact('imageSliders'));
    }

    public function create()
    {
        return view('image_sliders.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title_en' => 'required|string|max:255',
            'title_th' => 'required|string|max:255',
            'description_en' => 'required|string',
            'description_th' => 'required|string',
            'image_url' => 'nullable|image|max:5120',
            'display_order' => 'required|integer',
            'status' => 'required|boolean',
        ]);

        $imageSlider = new ImageSlider();
        $imageSlider->title_en = $request->input('title_en');
        $imageSlider->title_th = $request->input('title_th');
        $imageSlider->description_en = $request->input('description_en');
        $imageSlider->description_th = $request->input('description_th');
        $imageSlider->display_order = $request->input('display_order');
        $imageSlider->status = $request->input('status');

        if ($request->hasFile('image_url')) {
            $imagePath = $request->file('image_url')->store('images', 'public');
            $imageSlider->image_url = $imagePath;
        }

        $imageSlider->save();

        return redirect()->route('image_sliders.index')->with('success', 'Image Slider created successfully.');
    }

    public function edit(ImageSlider $imageSlider)
    {
        return view('image_sliders.edit', compact('imageSlider'));
    }

    public function update(Request $request, ImageSlider $imageSlider)
    {
        $request->validate([
            'title_en' => 'required|string|max:255',
            'title_th' => 'required|string|max:255',
            'description_en' => 'required|string',
            'description_th' => 'required|string',
            'image_url' => 'nullable|image|max:5120',
            'display_order' => 'required|integer',
            'status' => 'required|boolean',
        ]);

        $imageSlider->title_en = $request->input('title_en');
        $imageSlider->title_th = $request->input('title_th');
        $imageSlider->description_en = $request->input('description_en');
        $imageSlider->description_th = $request->input('description_th');
        $imageSlider->display_order = $request->input('display_order');
        $imageSlider->status = $request->input('status');

        if ($request->hasFile('image_url')) {
            // Delete old image if it exists
            if ($imageSlider->image_url) {
                Storage::disk('public')->delete($imageSlider->image_url);
            }

            $imagePath = $request->file('image_url')->store('images', 'public');
            $imageSlider->image_url = $imagePath;
        }

        $imageSlider->save();

        return redirect()->route('image_sliders.index')->with('success', 'Image Slider updated successfully.');
    }

    public function show(ImageSlider $imageSlider)
    {
        return view('image_sliders.show', compact('imageSlider'));
    }

    public function destroy(ImageSlider $imageSlider)
    {
        if ($imageSlider->image_url) {
            Storage::disk('public')->delete($imageSlider->image_url);
        }

        $imageSlider->delete();

        return redirect()->route('image_sliders.index')->with('success', 'Image Slider deleted successfully.');
    }
    public function updateOrder(Request $request)
    {
        $sortedIDs = $request->input('sortedIDs');

        foreach ($sortedIDs as $index => $id) {
            ImageSlider::where('id', $id)->update(['display_order' => $index + 1]);
        }

        return response()->json(['success' => true]);
    } 
    public function toggleStatus(Request $request)
    {
        $id = $request->input('id');
        $status = $request->input('status');
        ImageSlider::where('id', $id)->update(['status' => $status]);
        return response()->json(['success' => true]);
    }
}
