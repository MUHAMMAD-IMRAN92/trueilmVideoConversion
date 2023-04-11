@component('mail::message')


    @component('mail::button', [
        'url' => url("localhost:3000/verify-account?email=$user->email &token=$user->id"),
    ])
        Varify You Email
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
