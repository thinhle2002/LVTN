<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banners = Banner::latest()->get();
        return view('admin.banner.index', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.banner.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'active' => 'boolean'
        ]);

        $imageName = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            
            $uploadPath = public_path('upload/front/img/banners');
            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }
            
            $image->move($uploadPath, $imageName);
        }

        Banner::create([
            'title' => $request->title,
            'image' => $imageName,
            'active' => $request->has('active') ? 1 : 0
        ]);

        return redirect()->route('banner.index')
            ->with('success', 'Banner đã được tạo thành công!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $banner = Banner::findOrFail($id);
        return view('admin.banner.edit', compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'active' => 'boolean'
        ]);

        $banner = Banner::findOrFail($id);
              
        if ($request->hasFile('image')) {
            
            if ($banner->image) {
                $oldImagePath = public_path('upload/front/img/banners/' . $banner->image);
                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                }
            }
 
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            
            $uploadPath = public_path('upload/front/img/banners');
            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }
            
            $image->move($uploadPath, $imageName);
            $banner->image = $imageName;
        }
        
        $banner->title = $request->title;
        $banner->active = $request->has('active') ? 1 : 0;
        $banner->save();

        return redirect()->route('banner.index')
            ->with('success', 'Banner đã được cập nhật!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);
        
        // Xóa hình ảnh
        if ($banner->image) {
            $imagePath = public_path('upload/front/img/banners/' . $banner->image);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }
        
        $banner->delete();
        
        return redirect()->route('banner.index')
            ->with('success', 'Banner đã được xóa!');
    }
}