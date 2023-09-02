<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PostInformasiPublik;
use App\Models\PostKontenBerita;
use App\Models\PostKontenProfil;
use App\Models\PostKunjunganTamu;
use App\Models\PostLaporan;
use Illuminate\Support\Facades\Validator;
use DataTables;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use App\Models\InformasiFrontOffice;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class SearchDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function searchData(Request $request)
    {
        $validate = $request->validate([
            'datasearch' => 'required',
        ]);

        if($validate):
            $datasearch = $request->datasearch;
            $post_ib = $this->getDataPostInformasiPublik($datasearch);
            $post_kb = $this->getDataPostKontenBerita($datasearch);
            $post_kp = $this->getDataPostKontenProfil($datasearch);
            $post_kt = $this->getDataPostKunjunganTamu($datasearch);
            $post_l = $this->getDataPostLaporan($datasearch);

            $merge = array_merge($post_ib, $post_kb, $post_kp, $post_kt, $post_l);
            $after_filter = array_filter($merge);
            $reindexed = array();

            foreach ($after_filter as $row)
                {
                    if ($row !== null)
                       $reindexed[] = $row;
                }
      
            return $reindexed;
        else:
            return response()->json();
        endif;
    }

    public function getDataPostInformasiPublik($datasearch)
    {
        $query = PostInformasiPublik::where('is_publish', 1)->where('isi_konten', 'LIKE','%'.$datasearch.'%')->orWhere('judul', 'LIKE','%'.$datasearch.'%')->get();

        if($query->isNotEmpty()):
            foreach($query as $row):
                $judul = $row->judul;
                $konten = $row->isi_konten;
                $kategori = $row->kategori;
                $uuid = $row->uuid_code;

            if(! empty($kategori)):
                if($kategori == 'Berkala'):
                    $url = route('show-informasiberkala', $uuid);
                elseif($kategori == 'Serta Merta'):
                    $url = route('show-informasisertamerta', $uuid);
                elseif($kategori == 'Setiap Saat'):
                    $url = route('show-informasisetiapsaat', $uuid);
                else:
                    $url = route('front-office');
                endif;
            else:
                    $url = route('front-office');
            endif;

                $data[] = ['judul' => $judul, 'isi_konten' => $konten, 'url' => $url];
            endforeach;
        else:
            $data[] = NULL;
        endif;

        return $data;
    }

    public function getDataPostKontenBerita($datasearch)
    {
        $query = PostKontenBerita::where('is_publish', 1)->where('isi_konten', 'LIKE','%'.$datasearch.'%')->orWhere('judul', 'LIKE','%'.$datasearch.'%')->get();

        if($query->isNotEmpty()):
            foreach($query as $row):
                $judul = $row->judul;
                $konten = $row->isi_konten;
                $url = route('show-berita', $row->uuid_code);

                $data[] = ['judul' => $judul, 'isi_konten' => $konten, 'url' => $url];
            endforeach;
        else:
            $data[] = NULL;
        endif;

        return $data;
    }

    public function getDataPostKontenProfil($datasearch)
    {
        $query = PostKontenProfil::where('is_publish', 1)->where('isi_konten', 'LIKE','%'.$datasearch.'%')->orWhere('judul', 'LIKE','%'.$datasearch.'%')->get();
     
        if($query->isNotEmpty()):
            foreach($query as $row):
                $judul = $row->judul;
                $konten = $row->isi_konten;
                $menu = $row->menu;

            if(! empty($menu)):
                $ubahstring_to_lower = Str::lower($menu);
                $cekstring = Str::contains($ubahstring_to_lower, 'dan');

                if($cekstring == true):
                    $hapusstring = Str::remove('dan', $ubahstring_to_lower);
                    $kosongkanspasi = Str::replace(' ', '', $hapusstring);
                    $slugurl = $kosongkanspasi;
                else:
                    $kosongkanspasi = Str::replace(' ', '', $ubahstring_to_lower);
                    $slugurl = $kosongkanspasi;
                endif;

                $url = route('ppid-'.$slugurl);
            else:
                $url = route('front-office');
            endif;                

                $data[] = ['judul' => $judul, 'isi_konten' => $konten, 'url' => $url];
            endforeach;
        else:
            $data[] = NULL;
        endif;

        return $data;
    }

    public function getDataPostKunjunganTamu($datasearch)
    {
        $query = PostKunjunganTamu::where('is_publish', 1)->where('isi_konten', 'LIKE','%'.$datasearch.'%')->orWhere('judul', 'LIKE','%'.$datasearch.'%')->get();

        if($query->isNotEmpty()):
            foreach($query as $row):
                $judul = $row->judul;
                $konten = $row->isi_konten;
                $kategori = $row->kategori;
                $uuid = $row->uuid_code;

            if(! empty($kategori)):
                if($kategori == 'sop'):
                    $url = route('show-sop', $uuid);
                elseif($kategori == 'tata cara'):
                    $url = route('show-tatacara', $uuid);
                else:
                    $url = route('front-office');
                endif;
            else:
                    $url = route('front-office');
            endif;

                $data[] = ['judul' => $judul, 'isi_konten' => $konten, 'url' => $url];
            endforeach;
        else:
            $data[] = NULL;
        endif;

        return $data;
    }

    public function getDataPostLaporan($datasearch)
    {
        $query = PostLaporan::where('is_publish', 1)->where('isi_konten', 'LIKE','%'.$datasearch.'%')->orWhere('judul', 'LIKE','%'.$datasearch.'%')->get();

        if($query->isNotEmpty()):
            foreach($query as $row):
                $judul = $row->judul;
                $konten = $row->isi_konten;
                $datafile = asset('storage/post_laporan/'.$row->data_file);

                $data[] = ['judul' => $judul, 'isi_konten' => $konten, 'url' => $datafile];
            endforeach;
        else:
            $data[] = NULL;
        endif;

        return $data;
    }

}
