<?php

namespace App\Repositories;

use App\Models\PengawasanTindakan;
use App\Models\PengawasanTindakanPic;
use App\Models\PengawasanTindakanLanjutan;
use App\Models\PengawasanRekap;
use App\Models\PengawasanAttachment;
use App\Models\User;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PengawasanTindakanRepository
{
    public function getAllTindakan(int $perPage = 10, string $sortField = null, string $sortOrder = null, String $keyword = null, String $provinceId = null): LengthAwarePaginator
    {
        $queryResult = PengawasanTindakan::query();

        if (!is_null($sortField) && !is_null($sortOrder)) {
            $queryResult->orderBy($sortField, $sortOrder);
        } else {
            $queryResult->orderBy("created_at", "desc");
        }

        $queryResult->with([
            'pimpinan',
            'picTindakans',
            'picTindakans.pic',
            'tindakanLanjutan',
            'tindakanLanjutan.pic',
            'attachments'
        ]);

        // Filter by province if provided
        if (!is_null($provinceId)) {
            $queryResult->whereHas('pimpinan', function($q) use ($provinceId) {
                $q->whereHas('petugas', function($petugasQuery) use ($provinceId) {
                    $petugasQuery->where('penempatan', $provinceId);
                });
            });
        }

        if (!is_null($keyword)) {
            $queryResult->whereRaw('lower(tindak_lanjut) LIKE ?', ['%' . strtolower($keyword) . '%'])
                ->orWhereHas('pimpinan', function($q) use ($keyword) {
                    $q->whereRaw('lower(name) LIKE ?', ['%' . strtolower($keyword) . '%']);
                });
        }

        $paginator = $queryResult->paginate($perPage);
        $paginator->withQueryString();

        return $paginator;
    }

    public function getTindakanById($tindakanId): ?PengawasanTindakan
    {
        return PengawasanTindakan::with([
            'pimpinan',
            'picTindakans',
            'picTindakans.pic',
            'tindakanLanjutan',
            'tindakanLanjutan.pic',
            'attachments'
        ])->find($tindakanId);
    }

    public function createTindakan($data)
    {
        return PengawasanTindakan::create($data);
    }

    public function updateTindakan($tindakanId, $data)
    {
        $tindakan = PengawasanTindakan::findOrFail($tindakanId);
        $tindakan->update($data);
        return $tindakan;
    }

    public function delete($tindakanId): ?bool
    {
        try {
            $tindakan = PengawasanTindakan::findOrFail($tindakanId);
            $tindakan->delete();
            return true;
        } catch (\Exception $e) {
            Log::error("Failed to delete tindakan with id $tindakanId: {$e->getMessage()}");
            return false;
        }
    }


    public function getTindakanByPimpinan($pimpinanId, int $perPage = 10)
    {
        return PengawasanTindakan::where('user_id_pimpinan', $pimpinanId)
            ->with([
                'picTindakans',
                'picTindakans.pic',
                'tindakanLanjutan',
                'tindakanLanjutan.pic'
            ])
            ->orderBy("created_at", "desc")
            ->paginate($perPage);
    }

    public function getTindakanByPIC($picId, int $perPage = 10)
    {
        return PengawasanTindakan::whereHas('picTindakans', function($query) use ($picId) {
            $query->where('pic_id', $picId);
        })
        ->with([
            'pimpinan',
            'picTindakans',
            'picTindakans.pic',
            'tindakanLanjutan',
            'tindakanLanjutan.pic'
        ])
        ->orderBy("created_at", "desc")
        ->paginate($perPage);
    }

    public function getTindakanByStatus($status, int $perPage = 10)
    {
        return PengawasanTindakan::where('status', $status)
            ->with([
                'pimpinan',
                'picTindakans',
                'picTindakans.pic',
                'tindakanLanjutan',
                'tindakanLanjutan.pic'
            ])
            ->orderBy("created_at", "desc")
            ->paginate($perPage);
    }

    public function linkPicToTindakan($tindakanId, $picId)
    {
        return PengawasanTindakanPic::create([
            'tindakan_id' => $tindakanId,
            'pic_id' => $picId
        ]);
    }

    public function deletePicsByTindakanId($tindakanId)
    {
        return PengawasanTindakanPic::where('tindakan_id', $tindakanId)
            ->delete();
    }

    public function getPicsByTindakanId($tindakanId)
    {
        return PengawasanTindakanPic::where('tindakan_id', $tindakanId)
            ->with(['pic'])
            ->get();
    }


    public function getTindakanWithLanjutan()
    {
        return PengawasanTindakan::with('tindakanLanjutan')->get();
    }

    public function getStatusOptions()
    {
        return PengawasanTindakan::getStatusOptions();
    }

    public function getTindakanAttachments($tindakanId)
    {
        return PengawasanAttachment::where('linked_id', $tindakanId)
            ->where('linked_type', 'TINDAKAN')
            ->get();
    }
}
