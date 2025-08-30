<?php

namespace App\Services;

use App\Models\PengawasanRekap;
use App\Models\PengawasanRekapPengawasan;
use App\Models\PengawasanTindakan;
use App\Models\PengawasanTindakanLanjutan;
use App\Models\PengawasanAttachment;
use App\Models\User;
use App\Models\MasterJenisPanganSegar;
use App\Models\MasterBahanPanganSegar;
use App\Models\MasterKota;
use App\Models\MasterProvinsi;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\PengawasanRekapRepository;
use App\Repositories\PengawasanRepository;
use App\Repositories\PengawasanAttachmentRepository;
use Exception;

class PengawasanRekapService
{
    private $pengawasanRekapRepository;
    private $pengawasanRepository;
    private $pengawasanAttachmentRepository;
    private $pengawasanTindakanRepository;
    private $pengawasanTindakanLanjutanRepository;

    public function __construct(
        PengawasanRekapRepository $pengawasanRekapRepository,
        PengawasanRepository $pengawasanRepository,
        PengawasanAttachmentRepository $pengawasanAttachmentRepository
    ) {
        $this->pengawasanRekapRepository = $pengawasanRekapRepository;
        $this->pengawasanRepository = $pengawasanRepository;
        $this->pengawasanAttachmentRepository = $pengawasanAttachmentRepository;
    }

    public function listAllRekap($perPage, string $sortField = null, string $sortOrder = null, string $keyword = null): LengthAwarePaginator
    {
        $perPage = !is_null($perPage) ? $perPage : config('constant.CRUD.PER_PAGE');
        return $this->pengawasanRekapRepository->getAllRekap($perPage, $sortField, $sortOrder, $keyword);
    }

    public function getRekapDetail($rekapId): ?PengawasanRekap
    {
        return $this->pengawasanRekapRepository->getRekapById($rekapId);
    }

    public function addNewRekap(array $validatedData)
    {
        DB::beginTransaction();
        try {
            $rekap = $this->pengawasanRekapRepository->createRekap($validatedData);
            DB::commit();
            return $rekap;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to save new rekap to database: {$exception->getMessage()}");
            return null;
        }
    }

    public function updateRekap(array $validatedData, $id)
    {
        DB::beginTransaction();
        try {
            $rekap = $this->pengawasanRekapRepository->updateRekap($id, $validatedData);
            DB::commit();
            return $rekap;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to update rekap in the database: {$exception->getMessage()}");
            return null;
        }
    }

    public function deleteRekap($rekapId): ?bool
    {
        DB::beginTransaction();
        try {
            // Delete related records first
            $this->pengawasanAttachmentRepository->deleteByLinkedId($rekapId, 'REKAP');
            $this->pengawasanTindakanRepository->deleteByRekapId($rekapId);

            $result = $this->pengawasanRekapRepository->delete($rekapId);
            DB::commit();
            return $result;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to delete rekap with id $rekapId: {$exception->getMessage()}");
            return false;
        }
    }

    public function getRekapByAdmin($adminId, int $perPage = 10)
    {
        return $this->pengawasanRekapRepository->getRekapByAdmin($adminId, $perPage);
    }

    public function getRekapByStatus($status, int $perPage = 10)
    {
        return $this->pengawasanRekapRepository->getRekapByStatus($status, $perPage);
    }

    public function getRekapByPIC($picId, int $perPage = 10)
    {
        return $this->pengawasanRekapRepository->getRekapByPIC($picId, $perPage);
    }

    public function getRekapByJenisPsat($jenisPsatId, int $perPage = 10)
    {
        return $this->pengawasanRekapRepository->getRekapByJenisPsat($jenisPsatId, $perPage);
    }

    public function getRekapByProdukPsat($produkPsatId, int $perPage = 10)
    {
        return $this->pengawasanRekapRepository->getRekapByProdukPsat($produkPsatId, $perPage);
    }

    public function getRekapByLocation($provinsiId, $kotaId = null, int $perPage = 10)
    {
        return $this->pengawasanRekapRepository->getRekapByLocation($kotaId, $provinsiId, $perPage);
    }

    /**
     * Get rekap by provinsi
     *
     * @param string $provinsiId
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getRekapByProvinsi($provinsiId, int $perPage = 10)
    {
        return $this->pengawasanRekapRepository->getRekapByProvinsi($provinsiId, $perPage);
    }

    public function getRekapWithTindakan()
    {
        return $this->pengawasanRekapRepository->getRekapWithTindakan();
    }

    public function linkPengawasanToRekap($pengawasanId, $rekapId)
    {
        return $this->pengawasanRekapRepository->linkPengawasanToRekap($pengawasanId, $rekapId);
    }

    public function unlinkPengawasanFromRekap($pengawasanId, $rekapId)
    {
        return $this->pengawasanRekapRepository->unlinkPengawasanFromRekap($pengawasanId, $rekapId);
    }

    public function getRekapAttachments($rekapId)
    {
        return $this->pengawasanRekapRepository->getRekapAttachments($rekapId);
    }

    public function getRekapTindakan($rekapId)
    {
        return $this->pengawasanRekapRepository->getRekapTindakan($rekapId);
    }

    public function getRekapTindakanLanjutan($tindakanId)
    {
        return $this->pengawasanRekapRepository->getRekapTindakanLanjutan($tindakanId);
    }

    public function createTindakanForRekap($rekapId, array $tindakanData)
    {
        DB::beginTransaction();
        try {
            $tindakanData['pengawasan_rekap_id'] = $rekapId;
            $tindakan = $this->pengawasanTindakanRepository->createTindakan($tindakanData);

            // Link PICs to tindakan
            if (isset($tindakanData['pic_tindakan_ids']) && is_array($tindakanData['pic_tindakan_ids'])) {
                foreach ($tindakanData['pic_tindakan_ids'] as $picId) {
                    $this->pengawasanTindakanRepository->linkPicToTindakan($tindakan->id, $picId);
                }
            }

            DB::commit();
            return $tindakan;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to create tindakan for rekap $rekapId: {$exception->getMessage()}");
            return null;
        }
    }

    public function updateTindakanForRekap($rekapId, array $tindakanData)
    {
        DB::beginTransaction();
        try {
            $rekap = $this->pengawasanRekapRepository->getRekapById($rekapId);

            if (!$rekap || !$rekap->tindakan) {
                throw new Exception("Tindakan not found for this rekap");
            }

            // Update tindakan
            // $tindakan = $this->pengawasanTindakanRepository->updateTindakan($rekap->tindakan->id, $tindakanData);

            // Update PICs
            if (isset($tindakanData['pic_tindakan_ids']) && is_array($tindakanData['pic_tindakan_ids'])) {
                // Delete existing PIC links
                // $this->pengawasanTindakanRepository->deletePicsByTindakanId($tindakan->id);

                // Create new PIC links
                // foreach ($tindakanData['pic_tindakan_ids'] as $picId) {
                //     $this->pengawasanTindakanRepository->linkPicToTindakan($tindakan->id, $picId);
                // }
            }

            DB::commit();
            return null; // Temporarily return null until repository is implemented
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to update tindakan for rekap $rekapId: {$exception->getMessage()}");
            return null;
        }
    }

    public function createTindakanLanjutanForTindakan($tindakanId, array $lanjutanData)
    {
        DB::beginTransaction();
        try {
            $lanjutanData['pengawasan_tindakan_id'] = $tindakanId;
            $lanjutan = $this->pengawasanTindakanLanjutanRepository->createTindakanLanjutan($lanjutanData);

            DB::commit();
            return $lanjutan;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to create tindakan lanjutan for tindakan $tindakanId: {$exception->getMessage()}");
            return null;
        }
    }

    public function updateTindakanLanjutanForTindakan($tindakanId, array $lanjutanData)
    {
        DB::beginTransaction();
        try {
            $tindakan = $this->pengawasanTindakanRepository->getTindakanById($tindakanId);

            if (!$tindakan || !$tindakan->tindakanLanjutan) {
                throw new Exception("Tindakan lanjutan not found for this tindakan");
            }

            // $lanjutan = $this->pengawasanTindakanLanjutanRepository->updateTindakanLanjutan($tindakan->tindakanLanjutan->id, $lanjutanData);

            DB::commit();
            return null; // Temporarily return null until repository is implemented
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to update tindakan lanjutan for tindakan $tindakanId: {$exception->getMessage()}");
            return null;
        }
    }

    public function addAttachmentToRekap($rekapId, array $attachmentData)
    {
        DB::beginTransaction();
        try {
            $attachmentData['linked_id'] = $rekapId;
            $attachmentData['linked_type'] = 'REKAP';
            $attachment = $this->pengawasanAttachmentRepository->createAttachment($attachmentData);

            DB::commit();
            return $attachment;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to add attachment to rekap $rekapId: {$exception->getMessage()}");
            return null;
        }
    }

    public function removeAttachmentFromRekap($attachmentId)
    {
        // return $this->pengawasanAttachmentRepository->deleteAttachment($attachmentId);
        return false; // Temporarily return false until repository is implemented
    }

    public function getStatusOptions()
    {
        return PengawasanRekap::getStatusOptions();
    }

    /**
     * Get lampiran fields
     *
     * @return array
     */
    public function getLampiranFields()
    {
        return $this->pengawasanRekapRepository->getLampiranFields();
    }

    /**
     * Get rekap with lampirans
     *
     * @param string $rekapId
     * @return PengawasanRekap|null
     */
    public function getRekapWithLampirans($rekapId)
    {
        return $this->pengawasanRekapRepository->getRekapWithLampirans($rekapId);
    }

    /**
     * Update lampiran for rekap
     *
     * @param string $rekapId
     * @param array $lampiranData
     * @return PengawasanRekap|null
     */
    public function updateLampiranForRekap($rekapId, array $lampiranData)
    {
        DB::beginTransaction();
        try {
            $rekap = $this->pengawasanRekapRepository->getRekapById($rekapId);

            if (!$rekap) {
                throw new Exception("Rekap not found");
            }

            // Update lampiran fields
            foreach ($lampiranData as $field => $value) {
                if (in_array($field, $this->getLampiranFields())) {
                    $rekap->$field = $value;
                }
            }

            $rekap->save();

            DB::commit();
            return $rekap;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to update lampiran for rekap $rekapId: {$exception->getMessage()}");
            return null;
        }
    }
}
