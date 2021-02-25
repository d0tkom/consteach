<template>
	<div 
		class="teacherWidget relative"
		@mouseenter="mouseEnter(data.id)"
		@mouseleave="mouseLeave(data.id)"
	>
		<div class="teacherWidgetMainCard flex justify-start card p-sm">
			<div class="profileImageWrapper mr-4">
				<img
					class="teacherProfileImage max-w-none blue-border rounded-full overflow-hidden mt-4"
					:src="data.user.profile_photo_url"
					alt="Tanár képe"
				>
			</div>
			<div class="w-full flex flex-col">
				<div class="flex items-center justify-between mb-4">
					<div class="name text-lg font-bold color-primary-dark flex items-center">
						<span v-if="false" class="material-icons mr-2 color-green-dark">
							check_circle_outline
						</span>
						<span
							class="capitalize mr-4"
						>{{ data.user.first_name }} {{ data.user.last_name[0] }}.</span>
						<country-flag
							:country="data.user.country"
						/>
					</div>
					<div class="price font-bold color-green-dark text-lg">
						{{ data.one_hour_price }} HUF / óra
					</div>
				</div>
				<div class="flex">
					<div>
						<div class="flex items-center mb-2">
							<div
								class="mr-6"
								v-for="(language, l) in data.teaching_languages"
								:key="l"
							>
								<span class="capitalize">{{ languageList.getName(language.language, locale) }}</span>
								<c-tag
									class="ml-2"
									type="success"
									small
								>{{ language.level }}</c-tag>
							</div>
						</div>
						<div class="text-lg font-bold color-primary-dark mb-2 flex items-center">
							<span class="material-icons mr-2">person</span>
							{{ data.student_count }} diák · {{ data.appointment_count }} óra
						</div>
						<div>
                            <span class="color-primary-dark font-lg font-bold">Beszélt nyelvek:</span>
                            <span
                                class="mr-2"
                                v-for="(language, l) in data.user.spoken_languages"
                                :key="l"
                            >{{ languageList.getName(language.language, locale) }} ({{ language.level }})</span>
                        </div>
						<div class="color-gray my-1" v-html="data.about_me[0].text"></div>
						<c-btn
							:navigate-to="'/teacher/' + data.id"
							text
						>
							Tovább >
						</c-btn>
					</div>
					<div class="actions flex flex-col justify-end items-center">
						<c-btn
							full
							icon="event"
							class="mb-4"
						>Órafoglalás</c-btn>
						<c-btn
							full
							outlined
							icon="chat"
						>Üzenet</c-btn>
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
				<div class="flex items-center justify-center text-center">
					<span class="material-icons mr-4">public</span>
					<div class="color-gray">
						Az időpontok a Te időzónádnak megfelelően jelennek meg (GMT +2)
					</div>
				</div>
				<div class="flex justify-center">
					<c-btn
						class="mt-4"
						:navigate-to="'/teacher/' + data.id"
					>Profil megtekintése</c-btn>
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
		}
	},
	data() {
		return {
			languageList: null,
            locale: window.default_locale,
		};
	},
	created() {
        this.languageList = require('@cospired/i18n-iso-languages');
        this.languageList.registerLocale(require('@cospired/i18n-iso-languages/langs/en.json'));
        this.languageList.registerLocale(require('@cospired/i18n-iso-languages/langs/hu.json'));
        this.languageList.registerLocale(require('@cospired/i18n-iso-languages/langs/de.json'));
    },
	methods: {
		mouseEnter(id) {
			this.$emit('mouse-enter', id);
		},
		mouseLeave(id) {
			this.$emit('mouse-leave', id);
		},
	}
}
</script>