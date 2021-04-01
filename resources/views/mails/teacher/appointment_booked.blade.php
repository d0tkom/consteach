@component('mail::message')
# {{ __('mail-appointment_booked.title') }}
{!! __('mail-appointment_booked.content', $data) !!}
@endcomponent