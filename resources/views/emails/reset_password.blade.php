@component('mail::message')

    Please click below button to reset your password:
    @component('mail::button', [
        'url' => "https://staging.trueilm.com/new-password?token=$user->id",
    ])
        Reset Password
    @endcomponent

    Thanks
    {{ $user->name }}
@endcomponent
