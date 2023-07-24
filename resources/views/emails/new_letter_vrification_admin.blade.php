@component('mail::message')
    # TrueILM

    "{{ $user->email }}" Has subscribed to our platform successfully!

    {{-- @component('mail::button', ['url' => ''])
Button Text
@endcomponent --}}

    Thanks,<br>
    {{-- {{ config('app.name') }} --}}
@endcomponent
