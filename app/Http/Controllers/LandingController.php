<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QrBadanPangan;

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

    public function batasCemaranResidu(Request $request)
    {
        $sortBy = $request->input('sort_by', 'nama_bahan_pangan_segar');
        $sortOrder = $request->input('sort_order', 'asc');

        $validSortColumns = ['nama_bahan_pangan_segar', 'jenis.nama_jenis_pangan_segar'];

        if (!in_array($sortBy, $validSortColumns)) {
            $sortBy = 'nama_bahan_pangan_segar';
        }

        // Handle sort order toggle
        if ($request->has('sort_by') && $request->input('sort_by') === $sortBy) {
            $sortOrder = $sortOrder === 'asc' ? 'desc' : 'asc';
        }

        // Normalize sort_by value for processing
        $actualSortBy = $sortBy;
        if ($sortBy === 'jenis.nama_jenis_pangan_segar') {
            $actualSortBy = 'nama_jenis_pangan_segar';
        }

        if ($actualSortBy === 'nama_jenis_pangan_segar') {
            $bahanPangan = \App\Models\MasterBahanPanganSegar::with('jenis')
                ->join('master_jenis_pangan_segars', 'master_bahan_pangan_segars.jenis_id', '=', 'master_jenis_pangan_segars.id')
                ->orderBy('master_jenis_pangan_segars.nama_jenis_pangan_segar', $sortOrder)
                ->select('master_bahan_pangan_segars.*')
                ->get();
        } else {
            $bahanPangan = \App\Models\MasterBahanPanganSegar::orderBy($actualSortBy, $sortOrder)
                ->with('jenis')
                ->get();
        }

        return view('landing.panduan.batas_cemaran', compact('bahanPangan', 'sortBy', 'sortOrder'));
    }

    public function showQRDetail($qr_code)
    {
        // Find the QR code data
        $data = QrBadanPangan::where('qr_code', $qr_code)
            ->where('status', 'approved')
            ->where('is_published', true)
            ->with(['business', 'jenisPsat', 'referensiSppb', 'referensiIzinedarPsatpl', 'referensiIzinedarPsatpd', 'referensiIzinedarPsatpduk'])
            ->first();

        return view('landing.qr', ['data' => $data]);
    }
}
