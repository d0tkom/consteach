<template>
	<div class="threadContainer bg-white w-full">
		<div class="message">
		m
		</div>
	</div>
</template>

<script>

export default {
	props: {
		activeThread: {
			type: Object,
			default() {
				return {
					id: null,
					name: null,
					profile_image: null,
					messages: []
				};
			}
		},
	},
	methods: {

	}
}
</script>