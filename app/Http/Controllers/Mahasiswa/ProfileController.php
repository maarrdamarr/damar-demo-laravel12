<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();
        return view('mahasiswa.profile', compact('user'));
    }

    /**
     * Selalu kembalikan instance App\Models\User agar linter paham.
     */
    protected function currentUser(): User
    {
        /** @var User|null $u */
        $u = Auth::user();
        if ($u instanceof User) {
            return $u;
        }
        return User::findOrFail(Auth::id());
    }

    public function updateProfile(Request $r)
    {
        $user = $this->currentUser();

        $data = $r->validate([
            'name'  => ['required','string','max:100'],
            'email' => ['required','email','max:150', Rule::unique('users','email')->ignore($user->id)],
        ]);

        // gunakan fill + save agar tidak memicu lint error pada ->update()
        $user->fill($data);
        $user->save();

        return back()->with('ok','Profil diperbarui.');
    }

    public function updateAvatar(Request $r)
    {
        $user = $this->currentUser();

        $r->validate([
            'avatar' => ['required','image','mimes:jpg,jpeg,png,webp','max:2048'],
        ]);

        if ($user->avatar_path && Storage::disk('public')->exists($user->avatar_path)) {
            Storage::disk('public')->delete($user->avatar_path);
        }

        $path = $r->file('avatar')->store('avatars', 'public');
        $user->avatar_path = $path;
        $user->save();

        return back()->with('ok','Foto profil diperbarui.');
    }

    public function updatePassword(Request $r)
    {
        $user = $this->currentUser();

        $r->validate([
            'current_password' => ['required'],
            'password'         => ['required','string','min:6','confirmed'],
        ]);

        if (! Hash::check($r->current_password, $user->password)) {
            return back()->with('error','Password saat ini salah.');
        }

        $user->password = Hash::make($r->password);
        $user->save();

        return back()->with('ok','Password berhasil diubah.');
    }
}
