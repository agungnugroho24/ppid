<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class CheckProfileUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $id = auth()->user()->id;
        $users = User::findOrFail($id);
        // $UsenameEmpty = empty($users->user_name);
        $usernameEmpty = $users->user_name;
        $jenispemohonEmpty = $users->jenis_pemohon;
        $jenisidentitasEmpty = $users->jenis_identitas;
        $nomoridentitasEmpty = $users->nomor_identitas;
        $keteranganEmpty = $users->keterangan;
        $isbappenasEmpty = (int) $users->is_bappenas;
        if(empty($isbappenasEmpty)):
            if(empty($usernameEmpty) || empty($jenisidentitasEmpty) || empty($jenispemohonEmpty) || empty($nomoridentitasEmpty) || empty($keteranganEmpty)):
                return redirect(route('update-profile'));
            endif;             
        endif;
        // dd($users);
        return $next($request);
    }
}
