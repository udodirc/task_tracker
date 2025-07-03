<?php

namespace App\Resource;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Task
 */
class TaskResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'assigned_user_id' => $this->assigned_user_id,
            'created_by_user_id' => $this->created_by_user_id,
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->created_at,
        ];
    }
}
