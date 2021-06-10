<template>
	<div class="cookiePanel p-4 shadow-md">
		<div class="color-primary-dark font-bold pr-16">
			{{ trans.get('landing.cookie_title') }}
			<a
				class="color-primary"
				href="/privacy_policy.pdf"
				target="_blank"
			>{{ trans.get('landing.cookie_link') }}?</a>
		</div>
		<div class="flex justify-center mt-4">
			<c-btn
				@click="$root.cookiePolicy.accepted = true"
			>{{ trans.get('landing.cookie_btn') }}</c-btn>
		</div>
		<c-btn
			icon-only
			text
			circle
			@click="$root.cookiePolicy.accepted = true"
			class="closeIcon"
			icon="close"
		/>
	</div>
</template>

<script>
export default {

}
</script>