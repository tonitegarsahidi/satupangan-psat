<?php

namespace App\Services;

use App\Models\QrBadanPangan;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\QrBadanPanganRepository;

class QrBadanPanganService
{
    private $qrBadanPanganRepository;

    public function __construct(QrBadanPanganRepository $qrBadanPanganRepository)
    {
        $this->qrBadanPanganRepository = $qrBadanPanganRepository;
    }

    public function listAllQrBadanPangan($perPage, string $sortField = null, string $sortOrder = null, string $keyword = null): LengthAwarePaginator
    {
        $perPage = !is_null($perPage) ? $perPage : config('constant.CRUD.PER_PAGE');
        return $this->qrBadanPanganRepository->getAllQrBadanPangan($perPage, $sortField, $sortOrder, $keyword);
    }

    public function getQrBadanPanganDetail($id): ?QrBadanPangan
    {
        return $this->qrBadanPanganRepository->getQrBadanPanganById($id);
    }

    public function addNewQrBadanPangan(array $validatedData)
    {
        DB::beginTransaction();
        try {
            $qrBadanPangan = $this->qrBadanPanganRepository->createQrBadanPangan($validatedData);
            DB::commit();
            return $qrBadanPangan;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to save new QrBadanPangan to database: {$exception->getMessage()}");
            return null;
        }
    }

    public function updateQrBadanPangan(array $validatedData, $id)
    {
        DB::beginTransaction();
        try {
            $qrBadanPangan = QrBadanPangan::findOrFail($id);
            $this->qrBadanPanganRepository->update($id, $validatedData);
            DB::commit();
            return $qrBadanPangan;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to update QrBadanPangan in the database: {$exception->getMessage()}");
            return null;
        }
    }

    public function deleteQrBadanPangan($id): ?bool
    {
        DB::beginTransaction();
        try {
            $this->qrBadanPanganRepository->deleteQrBadanPanganById($id);
            DB::commit();
            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to delete QrBadanPangan with id $id: {$exception->getMessage()}");
            return false;
        }
    }

    public function getQrBadanPanganByBusinessId($businessId)
    {
        return $this->qrBadanPanganRepository->getQrBadanPanganByBusinessId($businessId);
    }

    public function getQrBadanPanganByStatus($status)
    {
        return $this->qrBadanPanganRepository->getQrBadanPanganByStatus($status);
    }

    public function getQrBadanPanganByAssignee($assigneeId)
    {
        return $this->qrBadanPanganRepository->getQrBadanPanganByAssignee($assigneeId);
    }

    public function getQrBadanPanganByCategory($qrCategory)
    {
        return $this->qrBadanPanganRepository->getQrBadanPanganByCategory($qrCategory);
    }

    public function updateStatus($id, $status, $userId = null)
    {
        DB::beginTransaction();
        try {
            $data = ['status' => $status];

            if ($status === 'reviewed' && $userId) {
                $data['reviewed_by'] = $userId;
                $data['reviewed_at'] = now();
            } elseif ($status === 'approved' && $userId) {
                $data['approved_by'] = $userId;
                $data['approved_at'] = now();
                $data['is_published'] = true;
            }

            $qrBadanPangan = $this->qrBadanPanganRepository->update($id, $data);
            DB::commit();
            return $qrBadanPangan;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to update status for QrBadanPangan with id $id: {$exception->getMessage()}");
            return null;
        }
    }

    public function assignToUser($id, $userId)
    {
        DB::beginTransaction();
        try {
            $data = ['current_assignee' => $userId];
            $qrBadanPangan = $this->qrBadanPanganRepository->update($id, $data);
            DB::commit();
            return $qrBadanPangan;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to assign QrBadanPangan with id $id to user $userId: {$exception->getMessage()}");
            return null;
        }
    }
}
