<template>
	<div 
		class="teacherWidget relative"
	>
		<div class="teacherWidgetMainCard flex justify-start card p-sm">
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
						<span v-if="false" class="material-icons mr-2 color-green-dark">
							check_circle_outline
						</span>
						<span
							class="capitalize mr-4"
						>{{ data.user.first_name }} {{ data.user.last_name[0] }}.</span>
						<flag
							v-if="data.country"
							class="text-2xl shadow-sm flagWide"
							:iso="data.country === 'en' ? 'us' : data.country"
						/>
					</div>
					<div class="price font-bold color-green-dark text-lg">
						<currency
							:value="data.one_hour_price"
						/> / {{ trans.get('find_teacher.hour') }}
					</div>
				</div>
				<div class="infoBottom flex">
					<div>
						<div class="flex items-center mb-2">
							<span class="material-icons mr-2">school</span>
							<div
								class="mr-6"
								v-for="(language, l) in data.teaching_languages"
								:key="l"
							>
								<span class="capitalize">{{ $root.languageList[language.language] }}</span>
								<c-tag
									class="ml-2"
									type="success"
									small
								>{{ language.level }}</c-tag>
							</div>
						</div>
						<div class="text-lg font-bold color-primary-dark mb-2 flex items-center">
							<span class="material-icons mr-2">person</span>
							{{ data.student_count }} {{ trans.get('find_teacher.student') }} · {{ data.appointment_count }} {{ trans.get('find_teacher.hour') }}
						</div>
						<div>
                            <span class="color-primary-dark font-lg font-bold">{{ trans.get('find_teacher.spoken_languages') }}:</span>
                            <span
                                class="mr-2 capitalize"
                                v-for="(language, l) in data.user.spoken_languages"
                                :key="l"
                            >{{ $root.languageList[language.language] }} ({{ language.level }})</span>
                        </div>
						<div class="color-gray my-1" v-html="data.about_me[0].text"></div>
						<c-btn
							:navigate-to="'/teacher/' + data.id"
							text
						>
							{{ trans.get('find_teacher.more_btn') }} >
						</c-btn>
					</div>
					<div class="actions flex flex-col justify-end items-center">
						<c-btn
							full
							icon="event"
							class="mb-4"
							:navigate-to="'/teacher/' + data.id"
						>{{ trans.get(trialAvailable ? 'find_teacher.free_lesson_book_btn' : 'find_teacher.book_btn') }}</c-btn>
						<c-btn
							v-if="false"
							full
							outlined
							icon="chat"
						>{{ trans.get('find_teacher.chat_btn') }}</c-btn>
					</div>
				</div>
			</div>
		</div>
		<transition name="fadeMoveIn">
			<div
				class="teacherMorePanel p-4 shadow-md blue-border"
				v-if="active"
			>
				<div class="flex justify-center mb-4">
					<iframe width="360" height="315" :src="data.video_url.replace('watch?v=', 'embed/')" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
				</div>
				
				<div class="flex justify-center">
					<c-btn
						class="mt-4"
						:navigate-to="'/teacher/' + data.id"
					>{{ trans.get('find_teacher.profile_btn') }}</c-btn>
				</div>
			</div>
		</transition>
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