@component('mail::message')
# {{ __('mail-appointment_deleted_teacher.title') }}
{{ __('mail-appointment_deleted_teacher.description') }}

@component('mail::button', ['url' => url(__('mail-appointment_deleted_teacher.cta_url')), 'color' => '#18A0FB'])
{{ __('mail-appointment_deleted_teacher.cta_btn') }}
@endcomponent

@endcomponent
