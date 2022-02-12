<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class TaskResourceWithoutUser extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'task' => $this->task,
            'comment' => $this->comment,
            'due_date' => $this->due_date,
            'completed_at' => $this->completed_at,
            'duration'=>Carbon::parse($this->due_date)->diff(Carbon::parse($this->completed_at??date('Y-m-d H:i:s')))->format('%Y-%m-%d %H:%i:%s'),
            'deleted_at' => $this->deleted_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
