@component('mail::message')
# {{ __('mail-appointment_deleted_student.title') }}
{{ __('mail-appointment_deleted_student.description') }}

@component('mail::button', ['url' => url(__('mail-appointment_deleted_student.cta_url')), 'color' => '#18A0FB'])
{{ __('mail-appointment_deleted_student.cta_btn') }}
@endcomponent

@endcomponent
