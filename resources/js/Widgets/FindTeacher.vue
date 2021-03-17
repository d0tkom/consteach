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
				<div class="calendar mb-4">
					<FullCalendar
						:options="calendarOptions"
					/>
				</div>
				<div class="flex justify-center text-center">
					<span class="material-icons mr-4">public</span>
					<div class="color-gray text-sm">
						{{ trans.get('find_teacher.timezone_info') }}
					</div>
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
import FullCalendar from '@fullcalendar/vue';
import interactionPlugin from '@fullcalendar/interaction';
import dayGridPlugin from '@fullcalendar/daygrid';

export default {
	components: {
		FullCalendar
	},
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
			calendarOptions: {
				validRange: {
					start: moment().format('YYYY-MM-DD')
				},
				dayHeaderContent: ({text}) => {
					let texts = text.split(' ');
					return `${texts[0]}\n${texts[1].substring(0,1).toUpperCase()}`;
				},
				plugins: [ dayGridPlugin, interactionPlugin ],
				initialView: 'dayGridMonth',
				locale: window.default_locale,
				slotMinTime: '06:00:00',
				slotMaxTime: '18:00:00',
				height: 'auto',
				buttonText: {
					today:    'mai nap',
					month:    'hónap',
					week:     'hét',
					day:      'nap',
					list:     'lista'
				},
				firstDay: 1,
				slotDuration: '01:00:00',
				dayHeaderFormat: {
					weekday: 'long' ,
					day: 'numeric',
					omitCommas: true
				},
				slotLabelFormat: {
					hour: '2-digit',
					minute: '2-digit',
					meridiem: 'long'
				},
				headerToolbar: {
					left: 'prev',
					center: 'title',
					right: 'next'
				},
				events: [],
				displayEventTime: false,
				selectable: false,
				selectOverlap: false,
				//eventClick: this.addAppointment,
			}
		};
	},
	created() {
		this.calendarOptions.timeZone = this.$page.props.user === null ? 'local' : this.$page.props.user.timezone;
		
		let availabilities = [];
		
		Object.values(this.data.availabilities).forEach(availability => {
			let event = {
				backgroundColor: '#18A0FB',
				start: moment.utc(availability.start).tz(this.calendarOptions.timeZone).format(),
				end: moment.utc(availability.end).tz(this.calendarOptions.timeZone).format(),
			};
			availabilities.push(event);
		});
		
		let appointments = [];
		
		Object.values(this.data.appointments).forEach(appointment => {
			let event = {
				start: moment.utc(appointment.start).tz(this.calendarOptions.timeZone).format(),
				end: moment.utc(appointment.end).tz(this.calendarOptions.timeZone).format(),
			};
			appointments.push(event);
		});
		
		this.calendarOptions.events = availabilities.filter(a => !appointments.find(b => b.start === a.start && b.end === a.end));
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