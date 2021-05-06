@component('mail::message')
# {{ __('mail-teacher_registered.title') }}

{!! __('mail-teacher_registered.content', ['url' => url('/')]) !!}
@endcomponent