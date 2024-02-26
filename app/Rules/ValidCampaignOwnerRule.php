<?php

namespace App\Rules;

use App\Models\Campaign;
use Illuminate\Contracts\Validation\Rule;

class ValidCampaignOwnerRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $user = auth()->user();

        return Campaign::where('id', $value)->where('user_id', $user->id)->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "campaign_id doesn't exit";
    }
}