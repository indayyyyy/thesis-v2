@component('mail::message')
# Introduction
{{ $details['title'] }}
{{ $details['body'] }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
ddwd
