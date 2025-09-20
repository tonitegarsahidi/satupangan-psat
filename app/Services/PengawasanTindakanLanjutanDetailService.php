<?php

namespace App\Services;

use App\Models\PengawasanTindakanLanjutanDetail;
use App\Models\PengawasanTindakanLanjutan;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\PengawasanTindakanLanjutanDetailRepository;
use Exception;

class PengawasanTindakanLanjutanDetailService
{
    private $pengawasanTindakanLanjutanDetailRepository;

    public function __construct(PengawasanTindakanLanjutanDetailRepository $pengawasanTindakanLanjutanDetailRepository)
    {
        $this->pengawasanTindakanLanjutanDetailRepository = $pengawasanTindakanLanjutanDetailRepository;
    }

    public function listAllDetails($perPage, string $sortField = null, string $sortOrder = null, string $keyword = null): LengthAwarePaginator
    {
        $perPage = !is_null($perPage) ? $perPage : config('constant.CRUD.PER_PAGE');
        return $this->pengawasanTindakanLanjutanDetailRepository->getAllDetails($perPage, $sortField, $sortOrder, $keyword);
    }

    public function getDetailById($detailId)
    {
        return $this->pengawasanTindakanLanjutanDetailRepository->getDetailById($detailId);
    }

    public function createDetail($lanjutanId, $data)
    {
        DB::beginTransaction();
        try {
            // Ensure the lanjutan exists
            $lanjutan = PengawasanTindakanLanjutan::findOrFail($lanjutanId);

            // Add the lanjutan ID to the data
            $data['pengawasan_tindakan_lanjutan_id'] = $lanjutanId;

            // Set created_by if not provided
            if (!isset($data['created_by'])) {
                $data['created_by'] = Auth::id();
            }

            $detail = $this->pengawasanTindakanLanjutanDetailRepository->createDetail($data);

            DB::commit();
            return $detail;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to create tindakan lanjutan detail: {$exception->getMessage()}");
            return null;
        }
    }

    public function updateDetail($detailId, $data)
    {
        DB::beginTransaction();
        try {
            // Set updated_by if not provided
            if (!isset($data['updated_by'])) {
                $data['updated_by'] = Auth::id();
            }

            $detail = $this->pengawasanTindakanLanjutanDetailRepository->updateDetail($detailId, $data);

            DB::commit();
            return $detail;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to update tindakan lanjutan detail with id $detailId: {$exception->getMessage()}");
            return null;
        }
    }

    public function deleteDetail($detailId): ?bool
    {
        return $this->pengawasanTindakanLanjutanDetailRepository->delete($detailId);
    }

    public function deleteDetailsByLanjutanId($lanjutanId): ?bool
    {
        return $this->pengawasanTindakanLanjutanDetailRepository->deleteByLanjutanId($lanjutanId);
    }

    public function getDetailsByLanjutanId($lanjutanId)
    {
        return $this->pengawasanTindakanLanjutanDetailRepository->getDetailsByLanjutanId($lanjutanId);
    }

    public function getDetailsByCreator($creatorId, int $perPage = 10)
    {
        return $this->pengawasanTindakanLanjutanDetailRepository->getDetailsByCreator($creatorId, $perPage);
    }

    public function getDetailsByUpdater($updaterId, int $perPage = 10)
    {
        return $this->pengawasanTindakanLanjutanDetailRepository->getDetailsByUpdater($updaterId, $perPage);
    }

    public function getDetailsByPIC($picId, int $perPage = 10)
    {
        return $this->pengawasanTindakanLanjutanDetailRepository->getDetailsByPIC($picId, $perPage);
    }

    public function getLatestDetailByLanjutanId($lanjutanId)
    {
        return $this->pengawasanTindakanLanjutanDetailRepository->getLatestDetailByLanjutanId($lanjutanId);
    }

    public function getDetailCountByLanjutanId($lanjutanId): int
    {
        return $this->pengawasanTindakanLanjutanDetailRepository->getDetailCountByLanjutanId($lanjutanId);
    }

    public function getAllDetailByLanjutanId(string $lanjutanId, int $perPage = 10): LengthAwarePaginator
    {
        return $this->pengawasanTindakanLanjutanDetailRepository->getAllDetailByLanjutanId($lanjutanId, $perPage);
    }

    public function validateDetailData($data)
    {
        $errors = [];

        if (empty($data['message'])) {
            $errors['message'] = 'Message is required';
        }

        if (isset($data['pengawasan_tindakan_lanjutan_id']) && !PengawasanTindakanLanjutan::find($data['pengawasan_tindakan_lanjutan_id'])) {
            $errors['pengawasan_tindakan_lanjutan_id'] = 'Related tindakan lanjutan not found';
        }

        return $errors;
    }

    public function getDetailWithAttachments($detailId)
    {
        $detail = $this->pengawasanTindakanLanjutanDetailRepository->getDetailById($detailId);

        if ($detail) {
            // Format lampiran fields
            $attachments = [];
            for ($i = 1; $i <= 6; $i++) {
                $lampiranKey = "lampiran{$i}";
                if (!empty($detail->$lampiranKey)) {
                    $attachments[] = [
                        'name' => $lampiranKey,
                        'path' => $detail->$lampiranKey,
                        'url' => asset($detail->$lampiranKey)
                    ];
                }
            }

            $detail->attachments = $attachments;
        }

        return $detail;
    }
}
