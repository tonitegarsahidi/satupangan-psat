<?php

namespace App\Repositories;

use App\Models\RegisterIzinedarPsatpd;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class RegisterIzinedarPsatpdRepository
{
    public function getAllRegisterIzinedarPsatpds(
        int $perPage = 10,
        string $sortField = null,
        string $sortOrder = null,
        string $keyword = null,
        $user = null
    ): LengthAwarePaginator
    {
        $queryResult = RegisterIzinedarPsatpd::query();

        // Filter by user if not supervisor/operator
        if ($user) {
            if (!$user->hasAnyRole(['ROLE_SUPERVISOR', 'ROLE_OPERATOR'])) {
                // Assuming RegisterIzinedarPsatpd has business_id and Business has user_id
                $queryResult->whereHas('business', function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                });
            }
        }

        if (!is_null($sortField) && !is_null($sortOrder)) {
            $queryResult->orderBy($sortField, $sortOrder);
        } else {
            $queryResult->orderBy("created_at", "desc");
        }

        if (!is_null($keyword)) {
            $queryResult->where(function($q) use ($keyword) {
                $q->whereRaw('lower(nomor_sppb) LIKE ?', ['%' . strtolower($keyword) . '%'])
                  ->orWhereRaw('lower(nomor_izinedar_pd) LIKE ?', ['%' . strtolower($keyword) . '%'])
                  ->orWhereRaw('lower(status) LIKE ?', ['%' . strtolower($keyword) . '%'])
                  ->orWhereRaw('lower(file_nib) LIKE ?', ['%' . strtolower($keyword) . '%'])
                  ->orWhereRaw('lower(file_sppb) LIKE ?', ['%' . strtolower($keyword) . '%'])
                  ->orWhereRaw('lower(file_izinedar_psatpd) LIKE ?', ['%' . strtolower($keyword) . '%']);
            });
        }

        $paginator = $queryResult->paginate($perPage);
        $paginator->withQueryString();

        return $paginator;
    }

    public function isRegisterIzinedarPsatpdExist(String $nomor_izinedar_pd){
        return RegisterIzinedarPsatpd::where('nomor_izinedar_pd', $nomor_izinedar_pd)->exists();
    }

    public function getRegisterIzinedarPsatpdById($registerIzinedarPsatpdId): ?RegisterIzinedarPsatpd
    {
        return RegisterIzinedarPsatpd::with(['business', 'provinsiUnitusaha', 'kotaUnitusaha', 'jenisPsat', 'okkpPenanggungjawab'])->find($registerIzinedarPsatpdId);
    }

    public function createRegisterIzinedarPsatpd($data)
    {
        return RegisterIzinedarPsatpd::create($data);
    }

    public function update($registerIzinedarPsatpdId, $data)
    {
        $registerIzinedarPsatpd = RegisterIzinedarPsatpd::with(['business', 'provinsiUnitusaha', 'kotaUnitusaha', 'jenisPsat', 'okkpPenanggungjawab'])->where('id', $registerIzinedarPsatpdId)->first();
        if ($registerIzinedarPsatpd) {
            $registerIzinedarPsatpd->update($data);
            return $registerIzinedarPsatpd;
        } else {
            throw new Exception("Register Izin EDAR PSATPD not found");
        }
    }

    public function deleteRegisterIzinedarPsatpdById($registerIzinedarPsatpdId): ?bool
    {
        try {
            $registerIzinedarPsatpd = RegisterIzinedarPsatpd::with(['business', 'provinsiUnitusaha', 'kotaUnitusaha', 'jenisPsat', 'okkpPenanggungjawab'])->findOrFail($registerIzinedarPsatpdId);
            $registerIzinedarPsatpd->delete();
            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function updateStatus($registerIzinedarPsatpdId, $status)
    {
        $registerIzinedarPsatpd = RegisterIzinedarPsatpd::findOrFail($registerIzinedarPsatpdId);
        $registerIzinedarPsatpd->status = $status;
        $registerIzinedarPsatpd->save();
        return $registerIzinedarPsatpd;
    }
}
