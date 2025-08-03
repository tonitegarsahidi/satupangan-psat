<?php

namespace App\Repositories;

use App\Models\QrBadanPangan;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;

class QrBadanPanganRepository
{
    public function getAllQrBadanPangan(int $perPage = 10, string $sortField = null, string $sortOrder = null, string $keyword = null): LengthAwarePaginator
    {
        $query = QrBadanPangan::with(['business', 'currentAssignee', 'requestedBy', 'reviewedBy', 'approvedBy', 'jenisPsat']);

        if (!is_null($sortField) && !is_null($sortOrder)) {
            $query->orderBy($sortField, $sortOrder);
        } else {
            $query->orderBy("created_at", "desc");
        }

        if (!is_null($keyword)) {
            $query->where(function($q) use ($keyword) {
                $q->whereRaw('lower(qr_code) LIKE ?', ['%' . strtolower($keyword) . '%'])
                  ->orWhereRaw('lower(nama_komoditas) LIKE ?', ['%' . strtolower($keyword) . '%'])
                  ->orWhereRaw('lower(nama_latin) LIKE ?', ['%' . strtolower($keyword) . '%'])
                  ->orWhereRaw('lower(merk_dagang) LIKE ?', ['%' . strtolower($keyword) . '%'])
                  ->orWhereRaw('lower(status) LIKE ?', ['%' . strtolower($keyword) . '%'])
                  ->orWhereHas('business', function($query) use ($keyword) {
                      $query->whereRaw('lower(nama_perusahaan) LIKE ?', ['%' . strtolower($keyword) . '%']);
                  });
            });
        }

        $paginator = $query->paginate($perPage);
        $paginator->withQueryString();

        return $paginator;
    }

    public function getQrBadanPanganById($id): ?QrBadanPangan
    {
        return QrBadanPangan::with(['business', 'currentAssignee', 'requestedBy', 'reviewedBy', 'approvedBy', 'jenisPsat',
                                    'referensiSppb', 'referensiIzinedarPsatpl', 'referensiIzinedarPsatpd',
                                    'referensiIzinedarPsatpduk', 'referensiIzinrumahPengemasan', 'referensiSertifikatKeamananPangan'])
                            ->find($id);
    }

    public function createQrBadanPangan($data)
    {
        return QrBadanPangan::create($data);
    }

    public function update($id, $data)
    {
        $qrBadanPangan = QrBadanPangan::where('id', $id)->first();
        if ($qrBadanPangan) {
            $qrBadanPangan->update($data);
            return $qrBadanPangan;
        } else {
            throw new Exception("QrBadanPangan not found");
        }
    }

    public function deleteQrBadanPanganById($id): ?bool
    {
        try {
            $qrBadanPangan = QrBadanPangan::findOrFail($id);
            $qrBadanPangan->delete();
            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function getQrBadanPanganByBusinessId($businessId)
    {
        return QrBadanPangan::where('business_id', $businessId)
                            ->with(['currentAssignee', 'requestedBy', 'reviewedBy', 'approvedBy', 'jenisPsat'])
                            ->orderBy('created_at', 'desc')
                            ->get();
    }

    public function getQrBadanPanganByStatus($status)
    {
        return QrBadanPangan::where('status', $status)
                            ->with(['business', 'currentAssignee', 'requestedBy', 'reviewedBy', 'approvedBy', 'jenisPsat'])
                            ->orderBy('created_at', 'desc')
                            ->get();
    }

    public function getQrBadanPanganByAssignee($assigneeId)
    {
        return QrBadanPangan::where('current_assignee', $assigneeId)
                            ->with(['business', 'requestedBy', 'jenisPsat'])
                            ->orderBy('created_at', 'desc')
                            ->get();
    }
}
