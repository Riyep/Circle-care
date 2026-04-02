<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::check();
    }

    public function rules()
    {
        $isAdmin = Auth::user()->role->name === 'admin';

        if ($isAdmin) {
            return [
                'mt_username' => 'required|string|max:255',
                'mt_useremail' => 'required|email|unique:users,mt_useremail,' . $this->route('user')->id,
                'mt_userpass' => 'nullable|string|min:6',
                'mt_departements_id' => 'required|exists:departements,id',
                'mt_positions_id' => 'required|exists:positions,id',
                'mt_role_id' => 'required|exists:roles,id',
            ];
        }

        return [
            'mt_username' => 'required|string|max:255',
            'mt_departements_id' => 'required|exists:departements,id',
            'mt_positions_id' => 'required|exists:positions,id',
        ];
    }
}

