<?php

namespace App\Repositories;

use App\Models\LaporanPengaduanWorkflow;
use App\Models\LaporanPengaduan;
use App\Models\User;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;

class LaporanPengaduanWorkflowRepository
{
    public function getAllWorkflowEntries(int $perPage = 10, string $sortField = null, string $sortOrder = null, string $keyword = null, string $status = null, string $userId = null, string $laporanPengaduanId = null): LengthAwarePaginator
    {
        $queryResult = LaporanPengaduanWorkflow::with(['user', 'laporanPengaduan']);

        // Filter berdasarkan status jika diberikan
        if (!is_null($status)) {
            $queryResult->where('status', $status);
        }

        // Filter berdasarkan user_id jika diberikan
        if (!is_null($userId)) {
            $queryResult->where('user_id', $userId);
        }

        // Filter berdasarkan laporan_pengaduan_id jika diberikan
        if (!is_null($laporanPengaduanId)) {
            $queryResult->where('laporan_pengaduan_id', $laporanPengaduanId);
        }

        if (!is_null($sortField) && !is_null($sortOrder)) {
            $queryResult->orderBy($sortField, $sortOrder);
        } else {
            $queryResult->orderBy("created_at", "desc");
        }

        if (!is_null($keyword)) {
            $queryResult->whereHas('user', function($q) use ($keyword) {
                    $q->whereRaw('lower(name) LIKE ?', ['%' . strtolower($keyword) . '%']);
                })
                ->orWhereHas('laporanPengaduan', function($q) use ($keyword) {
                    $q->whereRaw('lower(nama_pelapor) LIKE ?', ['%' . strtolower($keyword) . '%'])
                      ->orWhereRaw('lower(isi_laporan) LIKE ?', ['%' . strtolower($keyword) . '%']);
                })
                ->orWhereRaw('lower(status) LIKE ?', ['%' . strtolower($keyword) . '%'])
                ->orWhereRaw('lower(message) LIKE ?', ['%' . strtolower($keyword) . '%']);
        }

        $paginator = $queryResult->paginate($perPage);
        $paginator->withQueryString();

        return $paginator;
    }

    public function getWorkflowById($workflowId): ?LaporanPengaduanWorkflow
    {
        return LaporanPengaduanWorkflow::with(['user', 'laporanPengaduan'])->find($workflowId);
    }

    public function getWorkflowByLaporanId($laporanId): ?LaporanPengaduanWorkflow
    {
        return LaporanPengaduanWorkflow::with(['user', 'laporanPengaduan'])
            ->where('laporan_pengaduan_id', $laporanId)
            ->orderBy('created_at', 'desc')
            ->first();
    }

    public function getAllWorkflowByLaporanId($laporanId)
    {
        return LaporanPengaduanWorkflow::with(['user', 'laporanPengaduan'])
            ->where('laporan_pengaduan_id', $laporanId)
            ->orderBy('created_at', 'asc')
            ->get();
    }

    public function createWorkflow($data)
    {
        return LaporanPengaduanWorkflow::create($data);
    }

    public function update($workflowId, $data)
    {
        $workflow = LaporanPengaduanWorkflow::where('id', $workflowId)->first();
        if ($workflow) {
            $workflow->update($data);
            return $workflow;
        } else {
            throw new Exception("Workflow entry not found");
        }
    }

    public function deleteWorkflowById($workflowId): ?bool
    {
        try {
            $workflow = LaporanPengaduanWorkflow::findOrFail($workflowId);
            $workflow->delete();
            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function getWorkflowStatistics()
    {
        return [
            'total' => LaporanPengaduanWorkflow::count(),
            'selesai' => LaporanPengaduanWorkflow::where('status', 'SELESAI')->count(),
            'dibatalkan' => LaporanPengaduanWorkflow::where('status', 'DIBATALKAN')->count(),
            'ditutup' => LaporanPengaduanWorkflow::where('status', 'DITUTUP')->count(),
            'diproses' => LaporanPengaduanWorkflow::where('status', 'Diproses')->count(),
            'dalam_tinjauan' => LaporanPengaduanWorkflow::where('status', 'Dalam Tinjauan')->count(),
        ];
    }

    public function getWorkflowByStatusAndDateRange($status, $startDate, $endDate)
    {
        return LaporanPengaduanWorkflow::with(['user', 'laporanPengaduan'])
            ->where('status', $status)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getLatestWorkflowByUserId($userId)
    {
        return LaporanPengaduanWorkflow::with(['laporanPengaduan'])
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->first();
    }
}
