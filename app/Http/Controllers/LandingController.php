<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function contact()
    {
        return view('landing.contact');
    }

    public function cekDataKeamananPangan()
    {
        return view('landing.layanan.cek_data');
    }

    public function laporKeamananPangan()
    {
        return view('landing.layanan.lapor_keamanan');
    }

    public function registrasiIzinProdukPangan()
    {
        return view('landing.layanan.registrasi_izin');
    }

    public function permintaanInformasi()
    {
        return view('landing.layanan.permintaan_informasi');
    }

    public function alurProsedur()
    {
        return view('landing.panduan.alur_prosedur');
    }

    public function standarKeamananMutuPangan()
    {
        return view('landing.panduan.standar_keamanan');
    }

    public function batasCemaranResidu()
    {
        return view('landing.panduan.batas_cemaran');
    }
}
