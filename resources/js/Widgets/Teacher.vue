<template>
	<div class="teacherWidget card p-sm flex justify-between blue-border">
		<div class="profileImageWrapper mr-4">
			<img
				class="teacherProfileImage max-w-none blue-border rounded-full overflow-hidden"
				:src="data.teacher.user.profile_photo_url"
				alt="Tanár képe"
			>
		</div>
		<div class="w-full flex flex-col">
			<div class="name text-lg font-bold color-primary-dark">
				{{ data.teacher.user.first_name }}
			</div>
			<div>
				<span class="name text-lg color-primary-dark">
					{{ data.teacher.user.country }}
				</span>
				<c-tag class="ml-2" type="success" small>
					{{ trans.get('dashboard.mother_tongue') }}
				</c-tag>
			</div>
			<div class="mt-4">
				<div class="stat mb-2 flex justify-between items-center">
					<span class="text-md">{{ trans.get('dashboard.teacher_widget_booked_lessons') }}</span>
					<span class="text-lg font-bold">{{ data.booked }}</span>
				</div>
				<div class="stat orange mb-2 flex justify-between items-center">
					<span class="text-md">{{ trans.get('dashboard.teacher_widget_bought_lessons') }}</span>
					<span class="text-lg font-bold">{{ data.available }}</span>
				</div>
				<div class="stat purple mb-2 flex justify-between items-center">
					<span class="text-md">{{ trans.get('dashboard.teacher_widget_finished_lessons') }}</span>
					<span class="text-lg font-bold">{{ data.finished }}</span>
				</div>
			</div>
		</div>
		<div class="actions flex flex-col justify-between items-center">
		
		</div>
	</div>
</template>

<script>

export default {
	props: {
		data: Object
	}
}
</script>