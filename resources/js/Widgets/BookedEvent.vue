<template>
	<div class="bookedEvent flex justify-between blue-border">
		<div class="profileImageWrapper mr-4">
			<img
				class="max-w-none blue-border rounded-full overflow-hidden"
				:src="fromTeacher ? data.student.user.profile_photo_url : data.teacher.user.profile_photo_url"
				alt="Tanár képe"
			>
		</div>
		<div class="w-full flex flex-col">
			<div class="name text-2xl font-bold color-primary-dark mb-2">
				{{ fromTeacher ? data.student.user.first_name : data.teacher.user.first_name }}
			</div>
			<div>
				<c-date
					with-day
					:value="data.from"
				/>
			</div>
			<c-date
				class="text-2xl font-bold color-primary-dark"
				only-time
				:value="data.from"
			/>
		</div>
		<div class="actions flex flex-col justify-between items-center">
			<div v-if="isEventLive" class="text-center mb-2 color-green-dark">Az óra elkezdődött</div>
			<c-date
				class="text-center mb-2 color-gray"
				:value="data.from"
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
				Csatlakozás
			</c-btn>
			<c-btn
				full
				small
				icon="chat"
				outlined
				class="mb-2"
				v-if="!isEventInPast"
			>
				Üzenet
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
	</div>
</template>

<script>

import CancelLesson from "@/Popups/CancelLesson";
import LessonNotReady from "@/Popups/LessonNotReady";
export default {
	components: {
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
	data() {
		return {
			cancelLessonPopup: false,
			eventNotReadyPopup: false
		};
	},
	methods: {
		joinEvent() {
			if (this.isEventInPast) {
				return false;
			}
			
			if (this.isEventLive) {
				return alert('TODO:Csatlakozás a videóchat-hez...');
			}
			
			this.eventNotReadyPopup = true;
		}
	},
	computed: {
		isEventInPast() {
			let dateMoment = this.$moment(this.data.from).add(this.data.length, 'minutes');
			let dDiff = this.$moment().diff(dateMoment);
			
			return dDiff > 0;
		},
		isEventLive() {
			const startDate = this.$moment(this.data.from, 'YYYY-MM-DD HH:mm:ss');
			const endDate = this.$moment(this.data.from, 'YYYY-MM-DD HH:mm:ss').add(this.data.length, 'minutes');
			
			const range = this.$moment.range(startDate, endDate);
			
			return range.contains(this.$moment());
		}
	}
}
</script>