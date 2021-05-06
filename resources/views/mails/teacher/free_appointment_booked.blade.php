@component('mail::message')
# {{ __('mail-free_appointment_booked_teacher.title') }}
{{ __('mail-free_appointment_booked_teacher.description') }}

@component('mail::button', ['url' => url(__('mail-free_appointment_booked_teacher.cta_url')), 'color' => '#18A0FB'])
{{ __('mail-free_appointment_booked_teacher.cta_btn') }}
@endcomponent

@endcomponent
