<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        //dd($request->all());

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:users,slug,' . $user->id,
            'bio'  => 'nullable|string|max:1000',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'avatar_cropped' => 'nullable|string',
        ]);
        //dd($validated);

        // 如果有裁切後的圖片 (base64)
        if (!empty($validated['avatar_cropped'])) {
            $image = $validated['avatar_cropped'];
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = 'avatars/' . uniqid() . '.png';
            Storage::disk('public')->put($imageName, base64_decode($image));
            $validated['avatar'] = 'storage/' . $imageName;
        } elseif ($request->hasFile('avatar')) {
            // 備用：使用原始上傳的檔案
            $path = $request->file('avatar')->store('avatars', 'public');
            $validated['avatar'] = 'storage/' . $path;
        }

        //dd($validated->file('avatar'));
        $user->update($validated);
        return redirect()->route('users.show', $user->slug)->with('success', '個人資料已更新');
    }
}
