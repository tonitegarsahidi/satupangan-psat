<?php

namespace App\Repositories;

use App\Models\RegisterSppb;
use App\Models\MasterJenisPanganSegar;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;

class RegisterSppbRepository
{
    public function getAllRegisterSppbs(int $perPage = 10, string $sortField = null, string $sortOrder = null, String $keyword = null): LengthAwarePaginator
    {
        $queryResult = RegisterSppb::query();

        if (!is_null($sortField) && !is_null($sortOrder)) {
            $queryResult->orderBy($sortField, $sortOrder);
        } else {
            $queryResult->orderBy("created_at", "desc");
        }

        if (!is_null($keyword)) {
            $queryResult->whereRaw('lower(nomor_registrasi) LIKE ?', ['%' . strtolower($keyword) . '%'])
                ->orWhereRaw('lower(status) LIKE ?', ['%' . strtolower($keyword) . '%']);
        }

        $paginator = $queryResult->paginate($perPage);
        $paginator->withQueryString();

        return $paginator;
    }

    public function isRegisterSppbExist(String $nomor_registrasi){
        return RegisterSppb::where('nomor_registrasi', $nomor_registrasi)->exists();
    }

    public function getRegisterSppbById($registerSppbId): ?RegisterSppb
    {
        return RegisterSppb::find($registerSppbId);
    }

    public function createRegisterSppb($data)
    {
        return RegisterSppb::create($data);
    }

    public function update($registerSppbId, $data)
    {
        $registerSppb = RegisterSppb::where('id', $registerSppbId)->first();
        if ($registerSppb) {
            $registerSppb->update($data);
            return $registerSppb;
        } else {
            throw new Exception("Register SPPB not found");
        }
    }

    public function deleteRegisterSppbById($registerSppbId): ?bool
    {
        try {
            $registerSppb = RegisterSppb::findOrFail($registerSppbId);
            $registerSppb->delete();
            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
