@component('mail::message')


    @component('mail::button', [
        'url' => url("localhost:3000/verify-account?email=$user->email &token=$user->id"),
    ])
        Verify You Email
    @endcomponent

    Thanks
    {{ config('app.name') }}
@endcomponent
