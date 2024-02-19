@component('mail::message')

    Please click below button to verify you email:
    @component('mail::button', [
        'url' => "https://app.trueilm.com/verify-account?email=$user->email &token=$user->id",
    ])
        Verify Your Email
    @endcomponent

    Thanks
    {{ $user->name }}
@endcomponent
