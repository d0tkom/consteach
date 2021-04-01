@component('mail::message')
# {{ __('mail-student_registered.title') }}

{!! __('mail-student_registered.content', ['url' => url('/')]) !!}
@endcomponent
