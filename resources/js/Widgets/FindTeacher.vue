<template>
	<div 
		class="teacherWidget relative"
	>
		<div class="teacherWidgetMainCard listPage flex flex-col justify-start card p-sm my-4">
			<div class="teacherWidgetTop flex mb-4">
				<div class="profileImageWrapper mr-4">
					<inertia-link
						:href="'/teacher/' + data.id"
					>
						<img
							class="teacherProfileImage max-w-none blue-border rounded-full overflow-hidden mt-4"
							:src="data.user.profile_photo_url"
							alt="Tanár képe"
						>
					</inertia-link>
				</div>
				<div class="cardBody w-full flex flex-col">
					<div class="mainInfoContainer flex items-center justify-between mb-4">
						<div
							v-if="data.user"
							class="name text-lg font-bold color-primary-dark flex items-center"
						>
							<inertia-link
								:href="'/teacher/' + data.id"
							>
								<span
									class="capitalize mr-4"
								>
									{{ data.user.first_name }} {{ data.user.last_name[0] }}.
								</span>
							</inertia-link>
							<flag
								v-if="data.country"
								class="text-2xl shadow-sm flagWide"
								:iso="data.country === 'en' ? 'us' : data.country"
							/>
						</div>
						<c-tag
							rounded
							priceTag
						>
							<currency
								:value="lowestPrice"
							/> / {{ trans.get('find_teacher.hour') }}
						</c-tag>
					</div>
					<div>
						<div class="languagesInfo flex items-center mb-2">
							<span class="material-icons mr-4">school</span>
							<div
								class="mr-2 languageTag"
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
							class="text-sm color-primary-dark mb-2 flex items-center"
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
			<div class="teacherWidgetBottom flex">
				<div class="color-gray my-1" v-html="description"></div>
				<div class="actions flex flex-col justify-end items-center">
					<inertia-link
						v-if="!$root.isCurrentUserTeacher"
						href="'/teacher/' + data.id+'#calendar'"
					>
						<c-btn
							icon="event"
						>{{ trans.get('find_teacher.book_btn') }}</c-btn>
					</inertia-link>
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

	},
	computed: {
		lowestPrice() {
			let prices = [
				this.data.one_hour_price,
				this.data.five_hour_price / 5,
				this.data.ten_hour_price / 10
			];

			return Math.max(...prices) * this.$root.fee;
		},
		description() {
			if (this.data.about_me[0].text.length <= 350) {
				return this.data.about_me[0].text;
			}

			return this.data.about_me[0].text.substring(0, 350);
		}
	}
}
</script>