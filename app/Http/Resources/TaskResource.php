<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class TaskResource extends JsonResource
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
            'due_date' => Carbon::parse($this->due_date)->format('Y-m-d H:i:s'),
            'completed_at' => $this->completed_at?Carbon::parse($this->completed_at)->format('Y-m-d H:i:s'):null,
            'duration'=>Carbon::parse($this->due_date)->diff(Carbon::parse($this->completed_at??date('Y-m-d H:i:s')))->format('%Y-%m-%d %H:%i:%s'),
            'deleted_at' => $this->deleted_at?Carbon::parse($this->deleted_at)->format('Y-m-d H:i:s'):null,
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::parse($this->updated_at)->format('Y-m-d H:i:s'),
            'user' => new UserResourceWithoutTask($this->user),
        ];
    }
}
