<template>
	<div 
		class="teacherWidget relative"
	>
		<div class="teacherWidgetMainCard listPage flex flex-col justify-start card p-sm my-4">
			<div class="flex mb-4">
				<div class="profileImageWrapper mr-4">
					<img
						class="teacherProfileImage max-w-none blue-border rounded-full overflow-hidden mt-4"
						:src="data.user.profile_photo_url"
						alt="Tanár képe"
					>
				</div>
				<div class="cardBody w-full flex flex-col">
					<div class="flex items-center justify-between mb-4">
						<div v-if="data.user" class="name text-lg font-bold color-primary-dark flex items-center">
						<span
							class="capitalize mr-4"
						>
							{{ data.user.first_name }} {{ data.user.last_name[0] }}.
						</span>
							<flag
								v-if="data.country"
								class="text-2xl shadow-sm flagWide"
								:iso="data.country === 'en' ? 'us' : data.country"
							/>
						</div>
						<div class="price font-bold color-green-price text-lg">
							<currency
								:value="data.one_hour_price"
							/> / {{ trans.get('find_teacher.hour') }}
						</div>
					</div>
					<div>
						<div class="flex items-center mb-2">
							<span class="material-icons mr-4">school</span>
							<div
								class="mr-4"
								v-for="(language, l) in data.teaching_languages"
								:key="l"
							>
								<span class="capitalize">{{ $root.languageList[language.language] }}</span>
								<c-tag
									class="mr-2"
									:type="language.level === 'native' ? 'success' : 'primary'"
									small
								>{{ language.level === 'native' ? trans.get('other.native') : language.level }}</c-tag>
							</div>
						</div>
						<div
							v-if="data.student_count === 0 && data.appointment_count === 0"
							class="text-lg font-bold color-primary-dark mb-2 flex items-center"
						>
							<span class="material-icons mr-4">sports_score</span>
							{{ trans.get('find_teacher.new_teacher_tag') }}
						</div>
						<div v-else class="text-lg font-bold color-primary-dark mb-2 flex items-center">
							<span class="material-icons mr-4">person</span>
							{{ data.student_count }} {{ trans.get('find_teacher.student') }} · {{ data.appointment_count }} {{ trans.get('find_teacher.hour') }}
						</div>
						<div>
							<span class="color-primary-dark font-lg font-bold mr-1">{{ trans.get('find_teacher.spoken_languages') }}:</span>
							<span
								class="mr-2 capitalize"
								v-for="(language, l) in data.user.spoken_languages"
								:key="l"
							>{{ $root.languageList[language.language] }} ({{ language.level }})</span>
						</div>
					</div>
				</div>
			</div>
			<div class="flex">
				<div class="color-gray my-1" v-html="data.about_me[0].text"></div>
				<div class="actions flex flex-col justify-end items-center">
					<c-btn
						class="mb-2"
						icon="account_circle"
						:navigate-to="'/teacher/' + data.id"
						outlined
					>
						{{ trans.get('find_teacher.more_btn') }}
					</c-btn>
					<c-btn
						icon="event"
						:navigate-to="'/teacher/' + data.id+'#calendar'"
					>{{ trans.get('find_teacher.book_btn') }}</c-btn>
				</div>
			</div>
		</div>
	</div>
</template>

<script>

export default {
	props: {
		active: {
			type: Boolean,
			default: false
		},
		data: {
			type: Object,
			default: {}
		},
		trialAvailable: {
			type: Boolean,
			default: false
		}
	},
	data() {
		return {
            locale: window.default_locale,
		};
	},
	created() {

    },
	methods: {

	}
}
</script>