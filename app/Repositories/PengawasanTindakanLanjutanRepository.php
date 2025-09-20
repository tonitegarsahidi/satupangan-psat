<?php

namespace App\Repositories;

use App\Models\PengawasanTindakanLanjutan;
use App\Models\PengawasanTindakan;
use App\Models\PengawasanAttachment;
use App\Models\User;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PengawasanTindakanLanjutanRepository
{
    public function getAllTindakanLanjutan(int $perPage = 10, string $sortField = null, string $sortOrder = null, String $keyword = null): LengthAwarePaginator
    {
        $queryResult = PengawasanTindakanLanjutan::query();

        if (!is_null($sortField) && !is_null($sortOrder)) {
            $queryResult->orderBy($sortField, $sortOrder);
        } else {
            $queryResult->orderBy("created_at", "desc");
        }

        $queryResult->with([
            'tindakan',
            'tindakan.rekap',
            'tindakan.pimpinan',
            'tindakan.picTindakans',
            'pic',
            'attachments'
        ]);

        if (!is_null($keyword)) {
            $queryResult->whereRaw('lower(tindak_lanjut) LIKE ?', ['%' . strtolower($keyword) . '%'])
                ->orWhereHas('tindakan', function($q) use ($keyword) {
                    $q->whereRaw('lower(tindak_lanjut) LIKE ?', ['%' . strtolower($keyword) . '%'])
                      ->orWhereHas('pimpinan', function($q) use ($keyword) {
                          $q->whereRaw('lower(name) LIKE ?', ['%' . strtolower($keyword) . '%']);
                      });
                })
                ->orWhereHas('pic', function($q) use ($keyword) {
                    $q->whereRaw('lower(name) LIKE ?', ['%' . strtolower($keyword) . '%']);
                });
        }

        $paginator = $queryResult->paginate($perPage);
        $paginator->withQueryString();

        return $paginator;
    }

    public function getTindakanLanjutanById($lanjutanId): ?PengawasanTindakanLanjutan
    {
        return PengawasanTindakanLanjutan::with([
            'tindakan',
            'tindakan.rekap',
            'tindakan.pimpinan',
            'tindakan.picTindakans',
            'pic',
            'attachments'
        ])->find($lanjutanId);
    }

    public function createTindakanLanjutan($data)
    {
        return PengawasanTindakanLanjutan::create($data);
    }

    public function updateTindakanLanjutan($lanjutanId, $data)
    {
        $lanjutan = PengawasanTindakanLanjutan::findOrFail($lanjutanId);
        $lanjutan->update($data);
        return $lanjutan;
    }

    public function delete($lanjutanId): ?bool
    {
        try {
            $lanjutan = PengawasanTindakanLanjutan::findOrFail($lanjutanId);
            $lanjutan->delete();
            return true;
        } catch (\Exception $e) {
            Log::error("Failed to delete tindakan lanjutan with id $lanjutanId: {$e->getMessage()}");
            return false;
        }
    }

    public function getTindakanLanjutanByTindakanId($tindakanId)
    {
        return PengawasanTindakanLanjutan::with([
            'pic',
            'attachments'
        ])->where('pengawasan_tindakan_id', $tindakanId)
        ->first();
    }

    public function getTindakanLanjutanByPIC($picId, int $perPage = 10)
    {
        return PengawasanTindakanLanjutan::where('user_id_pic', $picId)
            ->with([
                'tindakan',
                'tindakan.rekap',
                'tindakan.pimpinan',
                'tindakan.picTindakans'
            ])
            ->orderBy("created_at", "desc")
            ->paginate($perPage);
    }

    public function getTindakanLanjutanByStatus($status, int $perPage = 10)
    {
        return PengawasanTindakanLanjutan::where('status', $status)
            ->with([
                'tindakan',
                'tindakan.rekap',
                'tindakan.pimpinan',
                'tindakan.picTindakans',
                'pic'
            ])
            ->orderBy("created_at", "desc")
            ->paginate($perPage);
    }

    public function getTindakanLanjutanWithTindakan()
    {
        return PengawasanTindakanLanjutan::with('tindakan')->get();
    }

    public function getTindakanLanjutanAttachments($lanjutanId)
    {
        return PengawasanAttachment::where('linked_id', $lanjutanId)
            ->where('linked_type', 'TINDAKAN_LANJUTAN')
            ->get();
    }

    public function deleteByTindakanId($tindakanId): ?bool
    {
        try {
            return PengawasanTindakanLanjutan::where('pengawasan_tindakan_id', $tindakanId)
                ->delete();
        } catch (\Exception $e) {
            Log::error("Failed to delete tindakan lanjutan by tindakan_id $tindakanId: {$e->getMessage()}");
            return false;
        }
    }

    public function getStatusOptions()
    {
        return PengawasanTindakanLanjutan::getStatusOptions();
    }
}
