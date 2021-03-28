@component('mail::message')
# {{ __('mail-free_appointment_booked_student.title') }}
{{ __('mail-free_appointment_booked_student.description') }}

@component('mail::button', ['url' => url(__('mail-free_appointment_booked_student.cta_url')), 'color' => '#18A0FB'])
{{ __('mail-free_appointment_booked_student.cta_btn') }}
@endcomponent

@endcomponent
