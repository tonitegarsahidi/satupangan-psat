<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QrBadanPangan;
use App\Models\MasterJenisPanganSegar;
use App\Models\MasterBahanPanganSegar;
use App\Http\Controllers\BatasCemaranLogamBeratController;
use App\Http\Controllers\BatasCemaranMikrobaController;
use App\Http\Controllers\BatasCemaranMikrotoksinController;
use App\Http\Controllers\BatasCemaranPestisidaController;

class LandingController extends Controller
{
    public function contact()
    {
        return view('landing.contact');
    }

    public function cekDataKeamananPangan(Request $request)
    {
        $search = $request->input('search');
        $results = null;

        if ($search) {
            $results = QrBadanPangan::with('business')
                ->where('status', 'approved')
                ->where('is_published', true)
                ->where(function($query) use ($search) {
                    $query->where('nama_komoditas', 'like', '%' . $search . '%')
                          ->orWhere('nama_latin', 'like', '%' . $search . '%')
                          ->orWhere('merk_dagang', 'like', '%' . $search . '%')
                          ->orWhere('jenis_psat', 'like', '%' . $search . '%')
                          ->orWhereHas('business', function($businessQuery) use ($search) {
                              $businessQuery->where('nama_perusahaan', 'like', '%' . $search . '%');
                          });
                })
                ->get();
        }

        return view('landing.layanan.cek_data', compact('search', 'results'));
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
        $sortBy = $request->input('sort_by', 'nama_jenis_pangan_segar');
        $sortOrder = $request->input('sort_order', 'asc');
        $jenisFilter = $request->input('jenis_filter', '');

        $validSortColumns = ['nama_jenis_pangan_segar'];

        if (!in_array($sortBy, $validSortColumns)) {
            $sortBy = 'nama_jenis_pangan_segar';
        }

        // Handle sort order toggle - only toggle if the same column is clicked
        if ($request->has('sort_by') && $request->input('sort_by') === $sortBy) {
            $sortOrder = $sortOrder === 'asc' ? 'desc' : 'asc';
        }
        // The sort_order parameter from the view already contains the correct value

        // Build the query with filter
        $query = \App\Models\MasterJenisPanganSegar::with(['bahanPangan', 'kelompok']);

        // Apply jenis filter if provided
        if (!empty($jenisFilter)) {
            $query->where('nama_jenis_pangan_segar', 'like', '%' . $jenisFilter . '%');
        }

        // Apply sorting
        $query->orderBy('nama_jenis_pangan_segar', $sortOrder);

        $jenisPangan = $query->where('is_active', true)->get();

        // Get all jenis for filter dropdown
        $jenisOptions = \App\Models\MasterJenisPanganSegar::where('is_active', true)
            ->orderBy('nama_jenis_pangan_segar', 'asc')
            ->get();

        return view('landing.panduan.batas_cemaran', compact('jenisPangan', 'sortBy', 'sortOrder', 'jenisFilter', 'jenisOptions'));
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

    public function batasCemaranResiduDetail($id)
    {
        // Get the MasterJenisPanganSegar by ID
        $jenisPangan = MasterJenisPanganSegar::findOrFail($id);

        // Get examples of fresh food materials in this category
        $bahanPanganExamples = MasterBahanPanganSegar::where('jenis_id', $id)
            ->where('is_active', true)
            ->orderBy('nama_bahan_pangan_segar', 'asc')
            ->take(5) // Limit to 5 examples
            ->get();

        // Get contamination limits for this jenis pangan
        // We'll directly query the models to get the data
        $logamBeratData = \App\Models\BatasCemaranLogamBerat::with(['jenisPangan', 'cemaranLogamBerat'])
            ->where('jenis_psat', $id)
            ->where('is_active', true)
            ->get();

        $mikrobaData = \App\Models\BatasCemaranMikroba::with(['jenisPangan', 'cemaranMikroba'])
            ->where('jenis_psat', $id)
            ->where('is_active', true)
            ->get();

        $mikrotoksinData = \App\Models\BatasCemaranMikrotoksin::with(['jenisPangan', 'cemaranMikrotoksin'])
            ->where('jenis_psat', $id)
            ->where('is_active', true)
            ->get();

        $pestisidaData = \App\Models\BatasCemaranPestisida::with(['jenisPangan', 'cemaranPestisida'])
            ->where('jenis_psat', $id)
            ->where('is_active', true)
            ->get();

        return view('landing.panduan.batas_cemaran_detail', compact(
            'jenisPangan',
            'bahanPanganExamples',
            'logamBeratData',
            'mikrobaData',
            'mikrotoksinData',
            'pestisidaData'
        ));
    }
}
