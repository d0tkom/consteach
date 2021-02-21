<template>
	<div class="boughtEvent flex justify-between card p-sm blue-border">
		<div class="profileImageWrapper mr-4 flex justify-center items-center">
			<img
				class="max-w-none blue-border rounded-full overflow-hidden"
				:src="fromTeacher ? data.student.user.profile_photo_url : data.teacher.user.profile_photo_url"
				alt="Tanár képe"
			>
		</div>
		<div class="w-full flex flex-col">
			<div class="name text-md font-bold color-primary-dark">
				{{ fromTeacher ? data.student.user.first_name : data.teacher.user.first_name }}
			</div>
			<div class="mb-4 text-sm">
				<b>{{ data.available }}</b> óra foglalásra vár
			</div>
			<c-btn
				v-if="!fromTeacher"
				icon="event"
				outlined
				medium
			>
				Órafoglalás
			</c-btn>
			<c-btn
				v-else
				icon="chat"
				outlined
				medium
			>
				Üzenet
			</c-btn>
		</div>
	</div>
</template>

<script>

export default {
	props: {
		fromTeacher: {
			type: Boolean,
			default: false
		},
		data: Object
	}
}
</script>