@component('mail::message')
# Diagnosis Notification

Hi {{$user->name}}. One of your submissions has been diagnosed.

{{--@component('mail::button', ['url' => "/submissions/{$submission->id}"])--}}
{{--View--}}
{{--@endcomponent--}}


@endcomponent
