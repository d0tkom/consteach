@component('mail::message')
# {{ __('mail-appointment_booked.title') }}
{{ __('mail-appointment_booked.description') }}

@component('mail::button', ['url' => url(__('mail-appointment_booked.cta_url')), 'color' => '#18A0FB'])
{{ __('mail-appointment_booked.cta_btn') }}
@endcomponent

@endcomponent
