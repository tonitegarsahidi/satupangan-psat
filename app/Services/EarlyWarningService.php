<?php

namespace App\Services;

use App\Models\EarlyWarning;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\EarlyWarningRepository;
use App\Notifications\EarlyWarningNotification;
use App\Models\User;


class EarlyWarningService
{
    private $EarlyWarningRepository;

    /**
     * =============================================
     *  constructor
     * =============================================
     */
    public function __construct(EarlyWarningRepository $EarlyWarningRepository)
    {
        $this->EarlyWarningRepository = $EarlyWarningRepository;
    }

    /**
     * =============================================
     *  list all EarlyWarnings along with filter, sort, etc
     * =============================================
     */
    public function listAllEarlyWarnings($perPage, string $sortField = null, string $sortOrder = null, string $keyword = null, string $status = null): LengthAwarePaginator
    {
        $perPage = !is_null($perPage) ? $perPage : config('constant.CRUD.PER_PAGE');
        return $this->EarlyWarningRepository->getAllEarlyWarnings($perPage, $sortField, $sortOrder, $keyword, $status);
    }

    /**
     * =============================================
     * get single EarlyWarning data
     * =============================================
     */
    public function getEarlyWarningDetail($EarlyWarningId): ?EarlyWarning
    {
        return $this->EarlyWarningRepository->getEarlyWarningById($EarlyWarningId);
    }


    /**
     * =============================================
     * Check if certain EarlyWarning title is exists or not
     * =============================================
     */
    public function checkEarlyWarningExist(string $title): bool{
        return $this->EarlyWarningRepository->isEarlyWarningTitleExist($title);
    }

    /**
     * =============================================
     * process add new EarlyWarning to database
     * =============================================
     */
    public function addNewEarlyWarning(array $validatedData)
    {
        DB::beginTransaction();
        try {
            $EarlyWarning = $this->EarlyWarningRepository->createEarlyWarning($validatedData);
            DB::commit();
            return $EarlyWarning;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to save new EarlyWarning to database: {$exception->getMessage()}");
            return null;
        }
    }

    /**
     * =============================================
     * process update EarlyWarning data
     * =============================================
     */
    public function updateEarlyWarning(array $validatedData, $id)
    {
        DB::beginTransaction();
        try {
            $EarlyWarning = EarlyWarning::findOrFail($id);

            $this->EarlyWarningRepository->update($id, $validatedData);
            DB::commit();
            return $EarlyWarning;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to update EarlyWarning in the database: {$exception->getMessage()}");
            return null;
        }
    }

    /**
     * =============================================
     * process delete EarlyWarning
     * =============================================
     */
    public function deleteEarlyWarning($EarlyWarningId): ?bool
    {
        DB::beginTransaction();
        try {
            $this->EarlyWarningRepository->deleteEarlyWarningById($EarlyWarningId);
            DB::commit();
            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to delete EarlyWarning with id $EarlyWarningId: {$exception->getMessage()}");
            return false;
        }
    }

    /**
     * =============================================
     *      process publish EarlyWarning
     * =============================================
     */
    public function publishEarlyWarning($earlyWarningId)
    {
        Log::info("Publishing EarlyWarning with id: $earlyWarningId");

        DB::beginTransaction();
        try {
            $earlyWarning = EarlyWarning::findOrFail($earlyWarningId);
            Log::info("Found EarlyWarning: {$earlyWarning->title}, Status: {$earlyWarning->status}");

            // Check if status is already Published
            if ($earlyWarning->status === 'Published') {
                Log::info("EarlyWarning is already published");
                return $earlyWarning;
            }

            // Update status to Published
            $result = $this->EarlyWarningRepository->publishEarlyWarning($earlyWarningId);

            // Dispatch notification to all users with the specified roles
            $this->dispatchEarlyWarning($earlyWarningId);

            DB::commit();
            Log::info("Successfully published EarlyWarning: {$earlyWarning->title}");
            return $earlyWarning;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to publish EarlyWarning with id $earlyWarningId: {$exception->getMessage()}");
            return null;
        }
    }

    /**
     * =============================================
     *      Dispatch EarlyWarning Notification
     * =============================================
     */
    public function dispatchEarlyWarning($earlyWarningId)
    {
        Log::info("Dispatching EarlyWarning notification with id: $earlyWarningId");

        try {
            $earlyWarning = EarlyWarning::findOrFail($earlyWarningId);

            // Get all users with the specified roles
            $users = User::whereHas('roles', function ($query) {
                $query->whereIn('role_code', ['ROLE_OPERATOR', 'ROLE_SUPERVISOR', 'ROLE_ADMIN', 'ROLE_LEADER']);
            })->get();

            Log::info("Found {$users->count()} users to notify for EarlyWarning: {$earlyWarning->title}");

            // Send notification to all users with the specified roles
            foreach ($users as $user) {
                $notification = new EarlyWarningNotification(
                    $earlyWarning->id,
                    $earlyWarning->title,
                    route('earlywarning.detail', $earlyWarning->id)
                );

                $user->notify($notification);
                Log::info("Notification sent to user: {$user->email}");
            }

            Log::info("Successfully dispatched EarlyWarning notification: {$earlyWarning->title}");
            return true;
        } catch (\Exception $exception) {
            Log::error("Failed to dispatch EarlyWarning notification with id $earlyWarningId: {$exception->getMessage()}");
            return false;
        }
    }
}
