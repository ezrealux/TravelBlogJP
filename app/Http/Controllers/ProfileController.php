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

        if ($request->filled('avatar_cropped')) {
            $avatarData = $request->input('avatar_cropped');
            
            // 1. 檢查合法base64字串('data:image/png;base64,,iVBORw0KGgoAAAANSUhEUgAA...') 2. 擷取副檔名
            if (preg_match('/^data:image\/(\w+);base64,/', $avatarData, $type)) {
                // 只擷取逗號後的部分(iVBORw0KGgoAAAANSUhEUgAA...)
                $avatarData = substr($avatarData, strpos($avatarData, ',') + 1);
                $type = strtolower($type[1]); // png / jpg / jpeg
                if (!in_array($type, ['jpg', 'jpeg', 'png'])) {
                    $type = 'png'; // 預設 fallback
                }

                $avatarData = base64_decode($avatarData);
                if ($avatarData === false) {
                    throw new \Exception('base64 decode failed');
                }

                // 統一檔名：user_{id}.png
                $fileName = "avatars/user_{$user->id}.{$type}";
                Storage::disk('public')->put($fileName, $avatarData);

                $validated['avatar'] = 'storage/' . $fileName;
            }
        }
        //dd($validated);

        //dd($validated->file('avatar'));
        $user->update($validated);
        return redirect()->route('users.show', $user->slug)->with('success', '個人資料已更新');
    }
}
