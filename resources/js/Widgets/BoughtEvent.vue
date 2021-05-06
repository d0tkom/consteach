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
			<inertia-link
				:href="'/teacher/'+data.teacher.id"
			>
				<div class="name text-md font-bold color-primary-dark">
					{{ fromTeacher ? data.student.user.first_name : data.teacher.user.first_name }}
				</div>
			</inertia-link>
			<div class="mb-4 text-sm">
				<b>{{ data.available }}</b> {{ trans.get('dashboard.bought_event_available') }}
			</div>
			<c-btn
				v-if="!fromTeacher"
				icon="event"
				outlined
				medium
				:navigate-to="'/teacher/' + data.teacher.id+'#calendar'"
			>
				{{ trans.get('dashboard.bought_event_book_btn') }}
			</c-btn>
			<c-btn
				v-else
				icon="chat"
				outlined
				medium
			>
				{{ trans.get('dashboard.bought_event_chat_btn') }}
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