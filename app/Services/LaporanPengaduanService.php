<?php

namespace App\Services;

use App\Models\LaporanPengaduan;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\LaporanPengaduanRepository;
use App\Repositories\UserRepository;
use App\Repositories\WorkflowActionRepository;
use App\Repositories\WorkflowRepository;
use App\Repositories\WorkflowThreadRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class LaporanPengaduanService
{
    private $LaporanPengaduanRepository;
    private $WorkflowRepository;
    private $UserRepository;
    private $WorkflowThreadRepository;
    private $WorkflowActionRepository;

    public function __construct(
        LaporanPengaduanRepository $LaporanPengaduanRepository,
        UserRepository $UserRepository,
        WorkflowRepository $WorkflowRepository,
        WorkflowThreadRepository $WorkflowThreadRepository,
        WorkflowActionRepository $WorkflowActionRepository
    ) {
        $this->LaporanPengaduanRepository = $LaporanPengaduanRepository;
        $this->UserRepository = $UserRepository;
        $this->WorkflowRepository = $WorkflowRepository;
        $this->WorkflowThreadRepository = $WorkflowThreadRepository;
        $this->WorkflowActionRepository = $WorkflowActionRepository;
    }

    public function listAllLaporanPengaduan($perPage, string $sortField = null, string $sortOrder = null, string $keyword = null): LengthAwarePaginator
    {
        $perPage = !is_null($perPage) ? $perPage : config('constant.CRUD.PER_PAGE');

        //check apakah role user atau diatasnya
        $user = Auth::user(); // Ambil user yang sedang login

        // dd($user->hasAnyRole(['ROLE_SUPERVISOR','ROLE_ADMIN']));
        // Cek apakah user memiliki role 'ROLE_OPERATOR'
        $userId = $user->id;
        if ($user->hasAnyRole(['ROLE_SUPERVISOR', 'ROLE_ADMIN'])) {
            // Kalau tidak punya role tersebut, batasi hanya laporan dari user ini
            $userId = null;
        }

        return $this->LaporanPengaduanRepository->getAllLaporanPengaduan($perPage, $sortField, $sortOrder, $keyword,  $userId);
    }

    public function getLaporanPengaduanDetail($laporanId): ?LaporanPengaduan
    {
        return $this->LaporanPengaduanRepository->getLaporanById($laporanId);
    }

    public function checkLaporanExist(string $nama_pelapor, string $isi_laporan): bool
    {
        return $this->LaporanPengaduanRepository->isLaporanExist($nama_pelapor, $isi_laporan);
    }

    public function addNewLaporanPengaduan(array $validatedData, $userId = null): ?LaporanPengaduan
    {
        DB::beginTransaction();
        try {
            //dapatkan user id yang default ter assignee
            $assignedUser = $this->UserRepository->getUserByEmail(config('constant.LAPORAN_PENGADUAN_ASSIGNEE'));
            $userIdAssignee = $assignedUser ? $assignedUser->id : null;


            // Buat Workflow terlebih dahulu
            $workflowData = [
                'user_id_initiator' => $userId,
                'type' => config('workflow.types.LAPORAN'),
                'status' => config('workflow.statuses.DALAM_REVIEW'),
                'title' => config('constant.LAPORAN_PENGADUAN_TITLE'),
                // 'title' => $validatedData['isi_laporan'],
                'current_assignee_id' => $userIdAssignee,
                'category' => config('workflow.categories.TEKNIS'),
                'due_date' => null, // Atur sesuai kebutuhan
                'is_active' => true,
                'created_by' => $userId,
                'updated_by' => $userId,
                'parent_id' => null, // Atur sesuai kebutuhan
            ];
            $workflow = $this->WorkflowRepository->createWorkflow($workflowData);

             //tambahkan workfow Thread disini
            $workflowThreadData = [
                'workflow_id' => $workflow->id,
                'user_id' => $userId,
                'message' => $validatedData['isi_laporan'],
                'link_url' => null,
                'is_internal' => false,
                'is_active' => true,
                'created_by' => $userId,
                'updated_by' => $userId,
            ];

            $workflowThread = $this->WorkflowThreadRepository->createThread($workflowThreadData);

            //tambahkan workflow action dan thread disini
            $workflowActionData = [
                'workflow_id'  => $workflow->id,
                'user_id' => $userId,
                'action_time' => Carbon::now(),
                'action_type' => config('workflow.action_types.INIT'),
                'action_target' => null,
                'description' => null,
                'previous_status' => null,
                'new_status' => config('workflow.statuses.DIBUAT'),
                'created_by' => $userId,
                'updated_by' => $userId,
            ];
            $workflowAction = $this->WorkflowActionRepository->createAction($workflowActionData);


            $workflowActionData2 = [
                'workflow_id'  => $workflow->id,
                'user_id' => $userIdAssignee,
                'action_time' => Carbon::now(),
                'action_type' => config('workflow.action_types.DISPOSISI'),
                'action_target' => $userIdAssignee,
                'description' => null,
                'previous_status' => config('workflow.statuses.DIBUAT'),
                'new_status' => config('workflow.statuses.DALAM_REVIEW'),
                'created_by' => $userId,
                'updated_by' => $userId,
            ];
            $workflowAction2 = $this->WorkflowActionRepository->createAction($workflowActionData2);



            // tambahkan user_id ke dalam data yang akan disimpan
            $validatedData['user_id'] = $userId;
            // tambahkan workflow_id ke dalam data yang akan disimpan
            $validatedData['workflow_id'] = $workflow->id;
            $validatedData['tindak_lanjut_pertama'] = null;
            $validatedData['is_active'] = true;


            $laporan = $this->LaporanPengaduanRepository->createLaporan($validatedData);
            DB::commit();
            return $laporan;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to save new LaporanPengaduan to database: {$exception->getMessage()}");
            return null;
        }
    }

    public function updateLaporanPengaduan(array $validatedData, $id)
    {
        DB::beginTransaction();
        try {
            $laporan = LaporanPengaduan::findOrFail($id);
            $this->LaporanPengaduanRepository->update($id, $validatedData);
            DB::commit();
            return $laporan;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to update LaporanPengaduan in the database: {$exception->getMessage()}");
            return null;
        }
    }

    public function deleteLaporanPengaduan($laporanId): ?bool
    {
        DB::beginTransaction();
        try {
            $this->LaporanPengaduanRepository->deleteLaporanById($laporanId);
            DB::commit();
            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to delete LaporanPengaduan with id $laporanId: {$exception->getMessage()}");
            return false;
        }
    }
}
