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
        $jenisFilter = $request->input('jenis_filter', '');

        $validSortColumns = ['nama_bahan_pangan_segar', 'jenis.nama_jenis_pangan_segar'];

        if (!in_array($sortBy, $validSortColumns)) {
            $sortBy = 'nama_bahan_pangan_segar';
        }

        // Handle sort order toggle - only toggle if the same column is clicked
        if ($request->has('sort_by') && $request->input('sort_by') === $sortBy) {
            $sortOrder = $sortOrder === 'asc' ? 'desc' : 'asc';
        }
        // The sort_order parameter from the view already contains the correct value

        // Normalize sort_by value for processing
        $actualSortBy = $sortBy;
        if ($sortBy === 'jenis.nama_jenis_pangan_segar') {
            $actualSortBy = 'nama_jenis_pangan_segar';
        }

        // Build the query with filter
        $query = \App\Models\MasterBahanPanganSegar::with('jenis');

        // Apply jenis filter if provided
        if (!empty($jenisFilter)) {
            $query->whereHas('jenis', function($q) use ($jenisFilter) {
                $q->where('nama_jenis_pangan_segar', 'like', '%' . $jenisFilter . '%');
            });
        }

        // Apply sorting
        if ($actualSortBy === 'nama_jenis_pangan_segar') {
            $query->join('master_jenis_pangan_segars', 'master_bahan_pangan_segars.jenis_id', '=', 'master_jenis_pangan_segars.id')
                  ->orderBy('master_jenis_pangan_segars.nama_jenis_pangan_segar', $sortOrder)
                  ->select('master_bahan_pangan_segars.*');
        } else {
            $query->orderBy($actualSortBy, $sortOrder);
        }

        $bahanPangan = $query->get();

        // Get all jenis for filter dropdown
        $jenisOptions = \App\Models\MasterJenisPanganSegar::where('is_active', true)
            ->orderBy('nama_jenis_pangan_segar', 'asc')
            ->get();

        return view('landing.panduan.batas_cemaran', compact('bahanPangan', 'sortBy', 'sortOrder', 'jenisFilter', 'jenisOptions'));
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
