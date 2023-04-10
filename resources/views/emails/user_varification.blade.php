@component('mail::message')


    @component('mail::button', ['url' => url('varified-user')])
        Varify You Email
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
