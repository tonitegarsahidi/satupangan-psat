<?php

namespace App\Repositories;

use App\Models\EarlyWarning;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;

class EarlyWarningRepository
{
    public function getAllEarlyWarnings(int $perPage = 10, string $sortField = null, string $sortOrder = null, String $keyword = null): LengthAwarePaginator
    {
        $queryResult = EarlyWarning::query();

        if (!is_null($sortField) && !is_null($sortOrder)) {
            $queryResult->orderBy($sortField, $sortOrder);
        } else {
            $queryResult->orderBy("updated_at", "desc");
        }

        if (!is_null($keyword)) {
            $queryResult->whereRaw('lower(title) LIKE ?', ['%' . strtolower($keyword) . '%'])
                ->orWhereRaw('lower(content) LIKE ?', ['%' . strtolower($keyword) . '%'])
                ->orWhereRaw('lower(related_product) LIKE ?', ['%' . strtolower($keyword) . '%'])
                ->orWhereRaw('lower(urgency_level) LIKE ?', ['%' . strtolower($keyword) . '%']);
        }

        $paginator = $queryResult->paginate($perPage);
        $paginator->withQueryString();

        return $paginator;
    }

    public function isEarlyWarningTitleExist(String $title){
        return EarlyWarning::where('title', $title)->exists();
    }

    public function getEarlyWarningById($earlyWarningId): ?EarlyWarning
    {
        return EarlyWarning::find($earlyWarningId);
    }

    public function createEarlyWarning($data)
    {
        return EarlyWarning::create($data);
    }

    public function update($earlyWarningId, $data)
    {
        // Find the Early Warning by id
        $earlyWarning = EarlyWarning::where('id', $earlyWarningId)->first();
        if ($earlyWarning) {
            // Update the Early Warning with the provided data
            $earlyWarning->update($data);
            return $earlyWarning;
        } else {
            throw new Exception("Early Warning not found");
        }
    }

    public function deleteEarlyWarningById($earlyWarningId): ?bool
    {
        try {
            $earlyWarning = EarlyWarning::findOrFail($earlyWarningId); // Find the Early Warning by ID
            $earlyWarning->delete(); // Delete the Early Warning
            return true; // Return true on successful deletion
        } catch (\Exception $e) {
            // Handle any exceptions, such as Early Warning not found
            throw $e; // Return false if deletion fails
        }
    }
}
