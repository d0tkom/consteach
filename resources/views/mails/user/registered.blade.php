@component('mail::message')
# {{ __('mail-user_registered.title') }}

{{ __('mail-user_registered.description') }}

@component('mail::button', ['url' => url(__('mail-user_registered.cta_url')), 'color' => '#18A0FB'])
    {{ __('mail-user_registered.cta_btn') }}
@endcomponent

@endcomponent
