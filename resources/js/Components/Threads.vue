<template>
	<div class="threadsContainer bg-white blue-border">
		<div class="top p-2">
			<c-input
				v-model="search"
				placeholder="Beszélgetés keresése"
			/>
		</div>
		<div class="threads p-2">
			<div
				class="thread flex blue-border p-1 mb-2"
				v-for="(thread, t) in threads"
				:key="t"
			>
				<img
					class="profileImg mr-2 blue-border"
					:src="thread.profile_image"
					alt="Tanár képe"
				>
				<div>
					<div class="text-md font-bold">{{ thread.name }}</div>
					<div>{{ thread.last_message }}</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>

export default {
	props: {
		threads: {
			type: Array,
			default() {
				return [];
			}
		}
	},
	data: function() {
		return {
			search: ''
		};
	},
	methods: {

	}
}
</script>