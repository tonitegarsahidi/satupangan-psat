<?php

namespace App\Repositories;

use App\Models\RegisterIzinedarPsatpl;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class RegisterIzinedarPsatplRepository
{
    public function getAllRegisterIzinedarPsatpls(
        int $perPage = 10,
        string $sortField = null,
        string $sortOrder = null,
        string $keyword = null,
        $user = null
    ): LengthAwarePaginator
    {
        $queryResult = RegisterIzinedarPsatpl::query();

        // Filter by user if not supervisor/operator
        if ($user) {
            if (!$user->hasAnyRole(['ROLE_SUPERVISOR', 'ROLE_OPERATOR'])) {
                // Assuming RegisterIzinedarPsatpl has business_id and Business has user_id
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
                  ->orWhereRaw('lower(nomor_izinedar_pl) LIKE ?', ['%' . strtolower($keyword) . '%'])
                  ->orWhereRaw('lower(status) LIKE ?', ['%' . strtolower($keyword) . '%'])
                  ->orWhereRaw('lower(file_nib) LIKE ?', ['%' . strtolower($keyword) . '%'])
                  ->orWhereRaw('lower(file_sppb) LIKE ?', ['%' . strtolower($keyword) . '%'])
                  ->orWhereRaw('lower(file_izinedar_psatpl) LIKE ?', ['%' . strtolower($keyword) . '%']);
            });
        }

        $paginator = $queryResult->paginate($perPage);
        $paginator->withQueryString();

        return $paginator;
    }

    public function isRegisterIzinedarPsatplExist(String $nomor_izinedar_pl){
        return RegisterIzinedarPsatpl::where('nomor_izinedar_pl', $nomor_izinedar_pl)->exists();
    }

    public function getRegisterIzinedarPsatplById($registerIzinedarPsatplId): ?RegisterIzinedarPsatpl
    {
        return RegisterIzinedarPsatpl::find($registerIzinedarPsatplId);
    }

    public function createRegisterIzinedarPsatpl($data)
    {
        return RegisterIzinedarPsatpl::create($data);
    }

    public function update($registerIzinedarPsatplId, $data)
    {
        $registerIzinedarPsatpl = RegisterIzinedarPsatpl::where('id', $registerIzinedarPsatplId)->first();
        if ($registerIzinedarPsatpl) {
            $registerIzinedarPsatpl->update($data);
            return $registerIzinedarPsatpl;
        } else {
            throw new Exception("Register Izin EDAR PSATPL not found");
        }
    }

    public function deleteRegisterIzinedarPsatplById($registerIzinedarPsatplId): ?bool
    {
        try {
            $registerIzinedarPsatpl = RegisterIzinedarPsatpl::findOrFail($registerIzinedarPsatplId);
            $registerIzinedarPsatpl->delete();
            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
