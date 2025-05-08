<?php

namespace App\Http\Controllers;

use App\Models\Logo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('can:read setting');
    }

    public function index()
    {
        return view('back.pages.setting.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function changeWebLogo(Request $request)
    {
        $setting = Logo::find(1);
        $logo_path = 'back/images/logo/';
        $old_logo = $setting->getAttributes()['logo_utama'];
        $file = $request->file('logo_utama');
        $filename = rand(1, 100000) . 'logo.png';
        if ($request->hasFile('logo_utama')) {
            if ($old_logo != null && File::exists(public_path($logo_path . $old_logo))) {
                File::delete(public_path($logo_path . $old_logo));
            }
            $upload = $file->move(public_path($logo_path), $filename);
            if ($upload) {
                $setting->update([
                    'logo_utama' => $filename,
                ]);

                return response()->json(['status' => 1, 'msg' => 'Logo has been successfuly updated.']);
            } else {
                return response()->json(['status' => 0, 'msg' => 'Something wrong!']);
            }
        }
    }

    public function changeEmailLogo(Request $request)
    {
        $setting = Logo::find(1);
        $logo_path = 'back/images/logo/';
        $old_logo = $setting->getAttributes()['logo_email'];
        $file = $request->file('logo_email');
        $filename = rand(1, 100000) . 'logo-email.png';
        if ($request->hasFile('logo_email')) {
            if ($old_logo != null && File::exists(public_path($logo_path . $old_logo))) {
                File::delete(public_path($logo_path . $old_logo));
            }
            $upload = $file->move(public_path($logo_path), $filename);
            if ($upload) {
                $setting->update([
                    'logo_email' => $filename,
                ]);

                return response()->json(['status' => 1, 'msg' => 'Email Logo has been successfuly updated.']);
            } else {
                return response()->json(['status' => 0, 'msg' => 'Something wrong!']);
            }
        }
    }

    public function changeWebFavicon(Request $request)
    {
        $setting = Logo::find(1);
        $favicon_path = 'back/images/logo/';
        $old_favicon = $setting->getAttributes()['logo_favicon'];
        $file = $request->file('logo_favicon');
        $filename = rand(1, 100000) . 'favicon.ico';
        if ($request->hasFile('logo_favicon')) {
            if ($old_favicon != null && File::exists(public_path($favicon_path . $old_favicon))) {
                File::delete(public_path($favicon_path . $old_favicon));
            }
            $upload = $file->move(public_path($favicon_path), $filename);
            if ($upload) {
                $setting->update([
                    'logo_favicon' => $filename,
                ]);

                return response()->json(['status' => 1, 'msg' => 'Favicon has been successfuly updated.']);
            } else {
                return response()->json(['status' => 0, 'msg' => 'Something wrong!']);
            }
        }
    }

    public function changeWebFront(Request $request)
    {
        $setting = Logo::find(1);
        $logo_path = 'back/images/logo/';
        $old_logo = $setting->getAttributes()['logo_front'];
        $file = $request->file('logo_front');
        $filename = rand(1, 100000) . 'logo-front.png';
        if ($request->hasFile('logo_front')) {
            if ($old_logo != null && File::exists(public_path($logo_path . $old_logo))) {
                File::delete(public_path($logo_path . $old_logo));
            }
            $upload = $file->move(public_path($logo_path), $filename);
            if ($upload) {
                $setting->update([
                    'logo_front' => $filename,
                ]);

                return response()->json(['status' => 1, 'msg' => 'Logo has been successfuly updated.']);
            } else {
                return response()->json(['status' => 0, 'msg' => 'Something wrong!']);
            }
        }
    }

    public function changeWebFront2(Request $request)
    {
        $setting = Logo::find(1);
        $logo_path = 'back/images/logo/';
        $old_logo = $setting->getAttributes()['logo_front2'];
        $file = $request->file('logo_front2');
        $filename = rand(1, 100000) . 'logo-front2.png';
        if ($request->hasFile('logo_front2')) {
            if ($old_logo != null && File::exists(public_path($logo_path . $old_logo))) {
                File::delete(public_path($logo_path . $old_logo));
            }
            $upload = $file->move(public_path($logo_path), $filename);
            if ($upload) {
                $setting->update([
                    'logo_front2' => $filename,
                ]);

                return response()->json(['status' => 1, 'msg' => 'Logo has been successfuly updated.']);
            } else {
                return response()->json(['status' => 0, 'msg' => 'Something wrong!']);
            }
        }
    }
}
