@component('mail::message')

    Please click below button to reset your password:
    @component('mail::button', [
        'url' => "https://app.trueilm.com/change-passowrd?token=$user->id",
    ])
        Reset Password
    @endcomponent

    Thanks
    {{ $user->name }}
@endcomponent
