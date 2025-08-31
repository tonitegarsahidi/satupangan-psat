<?php

namespace App\Services;

use App\Models\LaporanPengaduanWorkflow;
use App\Models\LaporanPengaduan;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\LaporanPengaduanWorkflowRepository;
use App\Repositories\LaporanPengaduanRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class LaporanPengaduanWorkflowService
{
    private $LaporanPengaduanWorkflowRepository;
    private $LaporanPengaduanRepository;

    public function __construct(
        LaporanPengaduanWorkflowRepository $LaporanPengaduanWorkflowRepository,
        LaporanPengaduanRepository $LaporanPengaduanRepository
    ) {
        $this->LaporanPengaduanWorkflowRepository = $LaporanPengaduanWorkflowRepository;
        $this->LaporanPengaduanRepository = $LaporanPengaduanRepository;
    }

    public function listAllWorkflowEntries($perPage, string $sortField = null, string $sortOrder = null, string $keyword = null, string $status = null): LengthAwarePaginator
    {
        $perPage = !is_null($perPage) ? $perPage : config('constant.CRUD.PER_PAGE');

        $user = Auth::user();

        // Cek apakah user memiliki role admin atau supervisor
        $userId = $user->id;
        if ($user->hasAnyRole(['ROLE_SUPERVISOR', 'ROLE_ADMIN'])) {
            // Admin dan supervisor bisa melihat semua workflow entries
            $userId = null;
        }

        return $this->LaporanPengaduanWorkflowRepository->getAllWorkflowEntries(
            $perPage,
            $sortField,
            $sortOrder,
            $keyword,
            $status,
            $userId
        );
    }

    public function getWorkflowEntryDetail($workflowId): ?LaporanPengaduanWorkflow
    {
        return $this->LaporanPengaduanWorkflowRepository->getWorkflowById($workflowId);
    }

    public function getWorkflowByLaporanId($laporanId): ?LaporanPengaduanWorkflow
    {
        return $this->LaporanPengaduanWorkflowRepository->getWorkflowByLaporanId($laporanId);
    }

    public function getAllWorkflowByLaporanId($laporanId)
    {
        return $this->LaporanPengaduanWorkflowRepository->getAllWorkflowByLaporanId($laporanId);
    }

    public function checkWorkflowExist(string $status, string $message, string $laporanPengaduanId): bool
    {
        return LaporanPengaduanWorkflow::where('status', $status)
            ->where('message', $message)
            ->where('laporan_pengaduan_id', $laporanPengaduanId)
            ->exists();
    }

    public function addNewWorkflowEntry(array $validatedData, $userId = null): ?LaporanPengaduanWorkflow
    {
        DB::beginTransaction();
        try {
            if (is_null($userId)) {
                $userId = Auth::id();
            }

            $validatedData['user_id'] = $userId;
            $validatedData['created_by'] = $userId;
            $validatedData['updated_by'] = $userId;

            $workflowEntry = $this->LaporanPengaduanWorkflowRepository->createWorkflow($validatedData);
            DB::commit();
            return $workflowEntry;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to save new Workflow Entry to database: {$exception->getMessage()}");
            return null;
        }
    }

    public function updateWorkflowEntry(array $validatedData, $workflowId)
    {
        DB::beginTransaction();
        try {
            $workflowEntry = LaporanPengaduanWorkflow::findOrFail($workflowId);

            // Update updated_by user
            $validatedData['updated_by'] = Auth::id();

            $this->LaporanPengaduanWorkflowRepository->update($workflowId, $validatedData);
            DB::commit();
            return $workflowEntry;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to update Workflow Entry with id $workflowId: {$exception->getMessage()}");
            return null;
        }
    }

    public function deleteWorkflowEntry($workflowId): ?bool
    {
        DB::beginTransaction();
        try {
            $this->LaporanPengaduanWorkflowRepository->deleteWorkflowById($workflowId);
            DB::commit();
            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to delete Workflow Entry with id $workflowId: {$exception->getMessage()}");
            return false;
        }
    }

    public function getWorkflowStatistics()
    {
        return $this->LaporanPengaduanWorkflowRepository->getWorkflowStatistics();
    }

    public function getWorkflowByStatusAndDateRange($status, $startDate, $endDate)
    {
        return $this->LaporanPengaduanWorkflowRepository->getWorkflowByStatusAndDateRange($status, $startDate, $endDate);
    }

    public function getLatestWorkflowByUserId($userId)
    {
        return $this->LaporanPengaduanWorkflowRepository->getLatestWorkflowByUserId($userId);
    }

    /**
     * Add workflow entry with automatic status progression based on previous status
     *
     * @param array $validatedData
     * @param string|null $userId
     * @return LaporanPengaduanWorkflow|null
     */
    public function addWorkflowEntryWithStatusProgression(array $validatedData, $userId = null): ?LaporanPengaduanWorkflow
    {
        DB::beginTransaction();
        try {
            if (is_null($userId)) {
                $userId = Auth::id();
            }

            // Get the previous workflow entry to determine the next status
            $previousWorkflow = $this->LaporanPengaduanWorkflowRepository->getWorkflowByLaporanId($validatedData['laporan_pengaduan_id']);

            // Set initial status if this is the first entry
            if (!$previousWorkflow) {
                $validatedData['status'] = 'Dibuat';
                $validatedData['message'] = 'Laporan pengaduan berhasil dibuat';
            } else {
                // Determine the next status based on the previous status
                $validatedData['status'] = $this->getNextStatus($previousWorkflow->status);
                $validatedData['message'] = $this->getStatusMessage($validatedData['status']);
            }

            $validatedData['user_id'] = $userId;
            $validatedData['created_by'] = $userId;
            $validatedData['updated_by'] = $userId;

            $workflowEntry = $this->LaporanPengaduanWorkflowRepository->createWorkflow($validatedData);

            // Update the laporan pengaduan status if needed
            if ($validatedData['status'] === 'SELESAI' || $validatedData['status'] === 'DIBATALKAN' || $validatedData['status'] === 'DITUTUP') {
                $laporanData = [
                    'is_active' => false,
                    'updated_by' => $userId
                ];
                $this->LaporanPengaduanRepository->update($validatedData['laporan_pengaduan_id'], $laporanData);
            }

            DB::commit();
            return $workflowEntry;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to save new Workflow Entry with status progression: {$exception->getMessage()}");
            return null;
        }
    }

    /**
     * Get the next status in the workflow progression
     *
     * @param string $currentStatus
     * @return string
     */
    private function getNextStatus($currentStatus): string
    {
        $statusFlow = [
            'Dibuat' => 'Diproses',
            'Diproses' => 'Dalam Tinjauan',
            'Dalam Tinjauan' => 'Perlu Tindakan',
            'Perlu Tindakan' => 'SELESAI',
            'Dibatalkan' => 'Dibatalkan',
            'SELESAI' => 'SELESAI',
            'DITUTUP' => 'DITUTUP'
        ];

        // Randomly decide if the workflow should be completed or continue
        if (in_array($currentStatus, ['Dalam Tinjauan', 'Perlu Tindakan']) && rand(0, 1)) {
            return $this->getRandomEndStatus();
        }

        return $statusFlow[$currentStatus] ?? $currentStatus;
    }

    /**
     * Get a random end status
     *
     * @return string
     */
    private function getRandomEndStatus(): string
    {
        $endStatuses = ['SELESAI', 'DIBATALKAN', 'DITUTUP'];
        return $endStatuses[array_rand($endStatuses)];
    }

    /**
     * Get the message for a specific status
     *
     * @param string $status
     * @return string
     */
    private function getStatusMessage($status): string
    {
        $messages = [
            'Dibuat' => 'Laporan pengaduan berhasil dibuat',
            'Diproses' => 'Laporan sedang dalam proses penanganan oleh petugas',
            'Dalam Tinjauan' => 'Tim ahli sedang melakukan analisis dan tinjauan laporan',
            'Perlu Tindakan' => 'Ditemukan pelanggaran namun perlu tindakan lebih lanjut dari pihak terkait',
            'SELESAI' => 'Laporan telah selesai ditangani dan tindak lanjut telah diberikan kepada pelapor',
            'DIBATALKAN' => 'Laporan dibatalkan karena informasi yang diberikan tidak lengkap atau tidak valid',
            'DITUTUP' => 'Laporan ditutup setelah tindakan yang telah diambil dan monitoring berjalan sesuai rencana'
        ];

        return $messages[$status] ?? '';
    }
}
