<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class BackOfficeController extends Controller
{
    use AuthenticatesUsers;

    protected $title = "Dashboard";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jumlah_user=DB::table('users')->count();
        $jumlah_PI=DB::table('permintaan_informasi')->count();
        $jumlah_PK=DB::table('permohonan_kunjungan')->count();
        $jumlah_PKeb=DB::table('pengajuan_keberatan')->count();
                    
        $visitor = DB::table('visitor')
                    ->select('date', DB::raw('COUNT(*) as count'))
                    ->whereYear('date', date('Y'))
                    ->groupBy(DB::raw('Year(date)'))
                    ->pluck('count');
        
        return view('back-office.pages.dashboard_bo', ['title' => $this->title, 'jumlah_user' => $jumlah_user, 'jumlah_PI' => $jumlah_PI, 'jumlah_PK' => $jumlah_PK, 'jumlah_PKeb' => $jumlah_PKeb])->with(compact('visitor'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
