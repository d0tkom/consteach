<template>
	<div class="cookiePanel p-4 shadow-md">
		<div class="color-primary-dark font-bold pr-16">
			{{ trans.get('landing.cookie_title') }}
			<inertia-link
				class="color-primary"
				href="/cookie-policy"
			>{{ trans.get('landing.cookie_link') }}?</inertia-link>
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