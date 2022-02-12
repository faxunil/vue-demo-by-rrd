<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public User $user;

    public function authorize()
    {
        $this->user=$user = Auth::guard('sanctum')->user();

        return $this->user?1:0;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id'    => ['required', 'numeric', 'min:1','exists:users,id'],
            'task'       => ['required', 'string','min:1','max:50'],
            'comment'    => ['nullable', 'string',],
            'due_date'  => ['nullable', 'date'],
            'completed_at'  => ['nullable', 'date'],
        ];
    }
}
