@component('mail::message')

    Please click below button to reset your password:
    @component('mail::button', [
        'url' => "https://app.trueilm.com/verify-account?email=$user->email &token=$user->id",
    ])
        Reset Password
    @endcomponent

    Thanks
    {{ $user->name }}
@endcomponent
