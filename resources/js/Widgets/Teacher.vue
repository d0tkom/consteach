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
			<inertia-link
				:href="'/teacher/'+data.teacher.id"
				class="name text-lg font-bold color-primary-dark"
			>
				{{ data.teacher.user.first_name }}
			</inertia-link>
			<div
				class="mr-2 mb-2"
				v-for="(language, l) in data.teacher.teaching_languages"
				:key="l"
			>
				<span class="capitalize">{{ $root.languageList[language.language] }}</span>
				<c-tag
					class="mr-2"
					:type="language.level === 'native' ? 'success' : 'primary'"
					small
				>{{ language.level === 'native' ? trans.get('other.native') : language.level }}</c-tag>
			</div>
			<div class="mt-4">
				<div class="stat mb-2 flex justify-between items-center">
					<span class="text-md">{{ trans.get('dashboard.teacher_widget_booked_lessons') }}</span>
					<span class="text-lg font-bold">{{ calcBookedLessons() }}</span>
				</div>
				<div class="stat orange mb-2 flex justify-between items-center">
					<span class="text-md">{{ trans.get('dashboard.teacher_widget_bought_lessons') }}</span>
					<span class="text-lg font-bold">{{ calcAvailableLessons() }}</span>
				</div>
				<div class="stat purple mb-2 flex justify-between items-center">
					<span class="text-md">{{ trans.get('dashboard.teacher_widget_finished_lessons') }}</span>
					<span class="text-lg font-bold">{{ calcFinishedLessons() }}</span>
				</div>
			</div>
		</div>
	</div>
</template>

<script>

export default {
	props: {
		data: Object
	},
	methods: {
		calcBookedLessons: function () {
			let filtered = this.data.teacher.lessons.filter(lesson => {
				return lesson.student_id == this.$page.props.user.extra.id && lesson.status == 1;
			});
			return filtered.length; 
		},
		calcAvailableLessons: function () {
			let filtered = this.data.teacher.lessons.filter(lesson => {
				return lesson.student_id == this.$page.props.user.extra.id && lesson.status == 0;
			});
			return filtered.length; 
		},
		calcFinishedLessons: function () {
			let filtered = this.data.teacher.lessons.filter(lesson => {
				return lesson.student_id == this.$page.props.user.extra.id && lesson.status == 2;
			});
			return filtered.length; 
		}
	}
}
</script>