@component('mail::message')
    

    @component('mail::button', ['url' => ''])
        Varify You Email
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
