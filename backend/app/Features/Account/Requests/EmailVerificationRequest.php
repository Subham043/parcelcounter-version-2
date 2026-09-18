<?php

namespace App\Features\Account\Requests;

use App\Features\Authentication\Services\AuthCache;
use App\Features\Users\Models\User;
use App\Http\Requests\InputRequest;
use Illuminate\Auth\Events\Verified;
use Illuminate\Validation\Validator;

class EmailVerificationRequest extends InputRequest
{
    private \App\Features\Users\Models\User|null $user = null;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        $this->user = User::with(['roles', 'permissions'])->find($this->route('id'));

        if (! $this->user) {
            return false;
        }

        if (! hash_equals((string) $this->user->getKey(), (string) $this->route('id'))) {
            return false;
        }

        if (! hash_equals(sha1($this->user->getEmailForVerification()), (string) $this->route('hash'))) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }

    /**
     * Fulfill the email verification request.
     *
     * @return void
     */
    public function fulfill()
    {

        if (! $this->user->hasVerifiedEmail()) {
            $this->user->markEmailAsVerified();
            event(new Verified($this->user));
            AuthCache::forget($this->user->id);
        }

    }
    
    public function userInfo()
    {
        return $this->user;
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return \Illuminate\Validation\Validator
     */
    public function withValidator(Validator $validator)
    {
        return $validator;
    }
}
