<template>
	<div class="card bookedEvent flex justify-between blue-border">
		<div class="profileImageWrapper mr-4">
			<img
				class="max-w-none blue-border rounded-full overflow-hidden"
				:src="fromTeacher ? data.student.user.profile_photo_url : data.teacher.user.profile_photo_url"
				alt="Tanár képe"
			>
		</div>
		<div class="bookedEventInfo w-full flex flex-col">
			<inertia-link
				:href="'/teacher/'+data.teacher.id"
			>
				<div class="name text-2xl font-bold color-primary-dark mb-2">
					{{ fromTeacher ? data.student.user.first_name : data.teacher.user.first_name }}
				</div>
			</inertia-link>
			<div>
				<c-date
					with-day
					:value="data.start"
				/>
			</div>
			<c-date
				class="text-2xl font-bold color-primary-dark"
				only-time
				:value="data.start"
			/>
		</div>
		<div class="actions flex flex-col justify-between items-center">
			<div v-if="isEventLive" class="text-center mb-2 color-green-dark">{{ trans.get('dashboard.booked_event_lesson_started') }}</div>
			<c-date
				class="text-center mb-2 color-gray"
				:value="data.start"
				lesson-start
				v-else
			/>
			<c-btn
				full
				small
				icon="perm_phone_msg"
				class="mb-2"
				@click="joinEvent"
				v-if="!isEventInPast"
			>
				{{ trans.get('dashboard.booked_event_join_btn') }}
			</c-btn>
			<!--<c-btn
				full
				small
				icon="chat"
				outlined
				class="mb-2"
				v-if="!isEventInPast"
			>
				{{ trans.get('dashboard.booked_event_chat_btn') }}
			</c-btn>-->
			<c-btn
				small
				text
				icon="close"
				@click="appointmentPopup.open = true"
			>
				{{ trans.get('dashboard.booked_event_cancel_btn') }}
			</c-btn>
		</div>
		<cancel-lesson
			v-model="cancelLessonPopup"
			:event="data"
		/>
		<lesson-not-ready
			v-model="eventNotReadyPopup"
			:event="data"
		/>
		<student-appointment
			v-model="appointmentPopup.open"
			:data="data"
			:time-zone="timeZone"
			@submit="deleteAppointment"
		/>
	</div>
</template>

<script>

import CancelLesson from "@/Popups/CancelLesson";
import LessonNotReady from "@/Popups/LessonNotReady";
import StudentAppointment from "@/Popups/StudentAppointment";
export default {
	components: {
		StudentAppointment,
		LessonNotReady,
		CancelLesson
	},
	props: {
		data: Object,
		fromTeacher: {
			type: Boolean,
			default: false
		},
	},
	created() {
		if (this.$page.props.user) {
			this.timeZone = this.$page.props.user.timezone;
		}
	},
	data() {
		return {
			appointmentPopup: {
				open: false,
				data: null
			},
			timeZone: 'Europe/Budapest',
			cancelLessonPopup: false,
			eventNotReadyPopup: false
		};
	},
	methods: {
		joinEvent() {
			if (this.isEventInPast) {
				return false;
			}

			var type = this.fromTeacher ? 'teacher' : 'student';
			
			if (this.isEventLive) {
				axios.post('/appointment/meeting/' + this.data.id, {type: type})
				.then(response => {
					window.open(this.data.meeting_url, '_blank');
				})
				.catch(error => {
					console.error(error);
				});
				
			} else {
				this.eventNotReadyPopup = true;
			}
		},
		deleteAppointment() {
			axios.delete('/appointment/' + this.data.id)
				.then(response => {
					this.appointmentPopup.open = false;
					this.$emit('destroy');
					let message = this.trans.get('dashboard.booked_event_cancel_success_notification');
					this.$toast.success(message);
				})
				.catch(error => {
					console.error(error);
					let message = this.trans.get('dashboard.booked_event_cancel_fail_notification');
					this.$toast.error(message);
				});
		}
	},
	computed: {
		isEventInPast() {
			let dateMoment = this.$moment.utc(this.data.start).tz(this.timeZone).add(60, 'minutes');
			let dDiff = this.$moment().diff(dateMoment);
			
			return dDiff > 0;
		},
		isEventLive() {
			const startDate = this.$moment.utc(this.data.start, 'YYYY-MM-DD HH:mm:ss').tz(this.timeZone).subtract(10, 'minutes');;
			const endDate = this.$moment.utc(this.data.start, 'YYYY-MM-DD HH:mm:ss').tz(this.timeZone).add(60, 'minutes');
			
			const range = this.$moment.range(startDate, endDate);
			
			return range.contains(this.$moment());
		}
	}
}
</script>