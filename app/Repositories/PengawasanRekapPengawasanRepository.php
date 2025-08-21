<?php

namespace App\Repositories;

use App\Models\PengawasanRekapPengawasan;
use App\Models\PengawasanRekap;
use App\Models\Pengawasan;
use Exception;
use Illuminate\Support\Facades\Log;

class PengawasanRekapPengawasanRepository
{
    public function getAllRekapPengawasan()
    {
        return PengawasanRekapPengawasan::with([
            'pengawasanRekap',
            'pengawasan'
        ])->get();
    }

    public function getRekapPengawasanById($id)
    {
        return PengawasanRekapPengawasan::with([
            'pengawasanRekap',
            'pengawasan'
        ])->find($id);
    }

    public function createRekapPengawasan($data)
    {
        return PengawasanRekapPengawasan::create($data);
    }

    public function updateRekapPengawasan($id, $data)
    {
        $rekapPengawasan = PengawasanRekapPengawasan::findOrFail($id);
        $rekapPengawasan->update($data);
        return $rekapPengawasan;
    }

    public function deleteRekapPengawasan($id): ?bool
    {
        try {
            $rekapPengawasan = PengawasanRekapPengawasan::findOrFail($id);
            $rekapPengawasan->delete();
            return true;
        } catch (\Exception $e) {
            Log::error("Failed to delete rekap pengawasan with id $id: {$e->getMessage()}");
            return false;
        }
    }

    public function getRekapPengawasanByRekapId($rekapId)
    {
        return PengawasanRekapPengawasan::where('pengawasan_rekap_id', $rekapId)
            ->with([
                'pengawasan'
            ])
            ->get();
    }

    public function getRekapPengawasanByPengawasanId($pengawasanId)
    {
        return PengawasanRekapPengawasan::where('pengawasan_id', $pengawasanId)
            ->with([
                'pengawasanRekap'
            ])
            ->get();
    }

    public function linkPengawasanToRekap($pengawasanId, $rekapId)
    {
        // Check if already linked
        $existing = PengawasanRekapPengawasan::where('pengawasan_rekap_id', $rekapId)
            ->where('pengawasan_id', $pengawasanId)
            ->first();

        if ($existing) {
            return $existing;
        }

        return PengawasanRekapPengawasan::create([
            'pengawasan_rekap_id' => $rekapId,
            'pengawasan_id' => $pengawasanId
        ]);
    }

    public function unlinkPengawasanFromRekap($pengawasanId, $rekapId)
    {
        return PengawasanRekapPengawasan::where('pengawasan_rekap_id', $rekapId)
            ->where('pengawasan_id', $pengawasanId)
            ->delete();
    }

    public function unlinkAllPengawasanFromRekap($rekapId)
    {
        return PengawasanRekapPengawasan::where('pengawasan_rekap_id', $rekapId)
            ->delete();
    }

    public function unlinkAllRekapFromPengawasan($pengawasanId)
    {
        return PengawasanRekapPengawasan::where('pengawasan_id', $pengawasanId)
            ->delete();
    }

    public function getRekapCountByPengawasanId($pengawasanId)
    {
        return PengawasanRekapPengawasan::where('pengawasan_id', $pengawasanId)
            ->count();
    }

    public function getPengawasanCountByRekapId($rekapId)
    {
        return PengawasanRekapPengawasan::where('pengawasan_rekap_id', $rekapId)
            ->count();
    }

    public function getRekapIdsByPengawasanId($pengawasanId)
    {
        return PengawasanRekapPengawasan::where('pengawasan_id', $pengawasanId)
            ->pluck('pengawasan_rekap_id');
    }

    public function getPengawasanIdsByRekapId($rekapId)
    {
        return PengawasanRekapPengawasan::where('pengawasan_rekap_id', $rekapId)
            ->pluck('pengawasan_id');
    }
}
