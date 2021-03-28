@component('mail::message')
# {{ __('mail-contact_form.title') }}
{{ __('mail-contact_form.description') }}
<br/>
<br/>
{{ $message }}
<br/>
<br/>
@endcomponent
