<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Slider;

class SliderController extends Controller
{
    public function addslider() {
        return view('admin.addslider');
    }

    public function sliders() {
        $sliders = Slider::All();

        return view('admin.sliders')->with('sliders', $sliders);
    }

    public function saveslider(Request $request) {
        $this->validate($request, ['description1' => 'required',
                                   'description2' => 'required',
                                   'slider_image' => 'image|nullable|max:3072|required']);

        // 1: get the file name with extension
        $fileNameWithExt = $request->file('slider_image')->getClientOriginalName();
        // 2: get just file name
        $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
        // 3: get just file extension
        $fileExt = $request->file('slider_image')->getClientOriginalExtension();
        // 4: file name to store
        $fileNameToStore = $fileName.'_'.time().'.'.$fileExt;

        //Upload Image
        $imagePath = $request->file('slider_image')->storeAs('public/slider_image', $fileNameToStore);

        $slider = new Slider();

        $slider->description1 = $request->description1;
        $slider->description2 = $request->description2;
        $slider->slider_image = $fileNameToStore;
        $slider->status = 1;

        $slider->save();

        return back()->with('status', 'The slider has been successfully saved..!!');
    }

    public function edit_slider($id) {
        $slider = Slider::find($id);

        return view('admin.edit_slider')->with('slider', $slider);
    }

    public function updateslider(Request $request) {
        $this->validate($request, ['description1' => 'required',
                                   'description2' => 'required',
                                   'slider_image' => 'image|nullable|max:3072']);

        $slider = Slider::find($request->id);

        $slider->description1 = $request->description1;
        $slider->description2 = $request->description2;

        if($request->hasFile('slider_image')) {
        // 1: get the file name with extension
        $fileNameWithExt = $request->file('slider_image')->getClientOriginalName();
        // 2: get just file name
        $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
        // 3: get just file extension
        $fileExt = $request->file('slider_image')->getClientOriginalExtension();
        // 4: file name to store
        $fileNameToStore = $fileName.'_'.time().'.'.$fileExt;

        //Upload Image
        $imagePath = $request->file('slider_image')->storeAs('public/slider_image', $fileNameToStore);

        Storage::delete('slider_image/'.$slider->slider_image);

        $slider->slider_image = $fileNameToStore;
        }

        $slider->update();

        return redirect('/sliders')->with('status', 'The slider has been successfully Updated..!!');
    }

    public function delete_slider($id) {
        $slider = Slider::find($id);

        Storage::delete('public/slider_image/'.$slider->slider_image);

        $slider->delete();

        return back()->with('status', 'The slider has been successfully deleted..!!');
    }

    public function activate_slider($id) {
        $slider = Slider::find($id);

        $slider->status = 1;
        $slider->update();

        return back()->with('status', 'The slider has been successfully activated..!!');
    }

    public function unactivate_slider($id) {
        $slider = Slider::find($id);

        $slider->status = 0;
        $slider->update();

        return back()->with('status', 'The slider has been successfully unactivated..!!');
    }
}
