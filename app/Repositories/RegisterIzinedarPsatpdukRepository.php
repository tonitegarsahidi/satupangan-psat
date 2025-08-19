<?php

namespace App\Repositories;

use App\Models\RegisterIzinedarPsatpduk;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class RegisterIzinedarPsatpdukRepository
{
    public function getAllRegisterIzinedarPsatpduks(
        int $perPage = 10,
        string $sortField = null,
        string $sortOrder = null,
        string $keyword = null,
        $user = null
    ): LengthAwarePaginator
    {
        $queryResult = RegisterIzinedarPsatpduk::query();

        // Filter by user if not supervisor/operator
        if ($user) {
            if (!$user->hasAnyRole(['ROLE_SUPERVISOR', 'ROLE_OPERATOR'])) {
                // Assuming RegisterIzinedarPsatpduk has business_id and Business has user_id
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
                  ->orWhereRaw('lower(nomor_izinedar_pduk) LIKE ?', ['%' . strtolower($keyword) . '%'])
                  ->orWhereRaw('lower(status) LIKE ?', ['%' . strtolower($keyword) . '%'])
                  ->orWhereRaw('lower(file_nib) LIKE ?', ['%' . strtolower($keyword) . '%'])
                  ->orWhereRaw('lower(file_sppb) LIKE ?', ['%' . strtolower($keyword) . '%'])
                  ->orWhereRaw('lower(file_izinedar_psatpduk) LIKE ?', ['%' . strtolower($keyword) . '%']);
            });
        }

        $paginator = $queryResult->paginate($perPage);
        $paginator->withQueryString();

        return $paginator;
    }

    public function isRegisterIzinedarPsatpdukExist(String $nomor_izinedar_pduk){
        return RegisterIzinedarPsatpduk::where('nomor_izinedar_pduk', $nomor_izinedar_pduk)->exists();
    }

    public function getRegisterIzinedarPsatpdukById($registerIzinedarPsatpdukId): ?RegisterIzinedarPsatpduk
    {
        return RegisterIzinedarPsatpduk::with(['business', 'provinsiUnitusaha', 'kotaUnitusaha', 'jenisPsat', 'okkpPenanggungjawab'])->find($registerIzinedarPsatpdukId);
    }

    public function createRegisterIzinedarPsatpduk($data)
    {
        return RegisterIzinedarPsatpduk::create($data);
    }

    public function update($registerIzinedarPsatpdukId, $data)
    {
        $registerIzinedarPsatpduk = RegisterIzinedarPsatpduk::with(['business', 'provinsiUnitusaha', 'kotaUnitusaha', 'jenisPsat', 'okkpPenanggungjawab'])->where('id', $registerIzinedarPsatpdukId)->first();
        if ($registerIzinedarPsatpduk) {
            $registerIzinedarPsatpduk->update($data);
            return $registerIzinedarPsatpduk;
        } else {
            throw new Exception("Register Izin EDAR PSATPDUK not found");
        }
    }

    public function deleteRegisterIzinedarPsatpdukById($registerIzinedarPsatpdukId): ?bool
    {
        try {
            $registerIzinedarPsatpduk = RegisterIzinedarPsatpduk::with(['business', 'provinsiUnitusaha', 'kotaUnitusaha', 'jenisPsat', 'okkpPenanggungjawab'])->findOrFail($registerIzinedarPsatpdukId);
            $registerIzinedarPsatpduk->delete();
            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function updateStatus($registerIzinedarPsatpdukId, $status)
    {
        $registerIzinedarPsatpduk = RegisterIzinedarPsatpduk::findOrFail($registerIzinedarPsatpdukId);
        $registerIzinedarPsatpduk->status = $status;
        $registerIzinedarPsatpduk->save();
        return $registerIzinedarPsatpduk;
    }
}
