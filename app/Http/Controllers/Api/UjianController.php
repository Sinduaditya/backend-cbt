<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SoalResource;
use App\Models\Soal;
use App\Models\Ujian;
use App\Models\UjianSoalList;
use Illuminate\Http\Request;

class UjianController extends Controller
{
    // function create ujian
    public function createUjian(Request $request){
        //get 20 soal angka random
        $soalNumeric = Soal::where('kategori','Numeric')->inRandomOrder()->limit(20)->get();
        // get 20 soal verbal random
        $soalVerbal = Soal::where('kategori','Verbal')->inRandomOrder()->limit(20)->get();
        // get 20 soal logika random
        $soalLogika = Soal::where('kategori','Logika')->inRandomOrder()->limit(20)->get();

        // create ujian
        $ujian = Ujian::create([
            'user_id' => $request->user()->id,
        ]);


        foreach ($soalNumeric as $soal) {
            UjianSoalList::create([
                'ujian_id' => $ujian->id,
                'soal_id' => $soal->id,
            ]);
        }

        foreach ($soalVerbal as $soal) {
            UjianSoalList::create([
                'ujian_id' => $ujian->id,
                'soal_id' => $soal->id,
            ]);
        }

        foreach ($soalLogika as $soal) {
            UjianSoalList::create([
                'ujian_id' => $ujian->id,
                'soal_id' => $soal->id,
            ]);
        }

        return response()->json([
            'message' => 'Ujian berhasil di buat',
            'data' => $ujian
        ]);
    }

    // get list soal by kategori
    public function getListByKategori(Request $request){
        $ujian = Ujian::where('user_id', $request->user()->id)->first(); // mengambil ujian berdasarkan ujiannya

        $ujianSoalList = UjianSoalList::where('ujian_id', $ujian->id)->get(); // mencari ujian soal list dengan  by user_id

        $ujianSoalListId = []; // penampung data

        foreach ($ujianSoalList as $soal) {
            array_push($ujianSoalListId, $soal->soal_id);
        } // melakukan push ke dalam array $ujianSoalList yang sesuai dengan id yang di dapatkan

        $soal = Soal::whereIn('id', $ujianSoalListId)->where('kategori', $request->kategori)->get(); // mengambil soal apa bila id nya sesuai dengan UjianSoalListId dan ketika kategorinya sesuai request->kategori

        return response()->json([
            'message' => 'Berhasil mendapatkan soal',
            'data' => SoalResource::collection($soal),
        ]);
    }
}
