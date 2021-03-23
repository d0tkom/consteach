<template>
	<c-pop-up
		:value="value"
		@close="$emit('input', false)"
		:title="trans.get('student_appointment_popup.popup_title')"
	>
		<div class="studentAppointmentPopup flex flex-col items-center">
			<div
				class="font-bold text-xl mb-2"
				v-if="data.student"
			>{{ data.student.user.first_name }} {{ data.student.user.last_name }}</div>
			<div class="date">{{ date }}</div>
			<div class="time text-2xl mb-4">{{ time }}</div>
			<div class="actions flex w-full px-6 mt-6 max-w-sm justify-center">
				<c-btn
					:outlined="!approved"
					color="error"
					@click="deleteAppointment"
				>{{ !approved ? trans.get('student_appointment_popup.delete_appointment_btn') : trans.get('student_appointment_popup.delete_appointment_approve_btn') }}</c-btn>
			</div>
		</div>
	</c-pop-up>
</template>

<script>

export default {
	components: {
		
	},
	props: {
		value: {
			type: Boolean,
			default: false
		},
		timeZone: {
			type: String,
			default: 'locale'
		},
		data: {
			type: Object,
			default() {
				return {
					student: {}
				}
			}
		},
	},
	watch: {
		value(value) {
			if (value) {
				this.approved = false;
			}
		}
	},
	mounted() {
	},
	data: function() {
		return {
			approved: false,
			active: this.value,
			loading: false,
		};
	},
	computed: {
		date() {
			return this.$moment.utc(this.data.start).tz(this.timeZone).format('YYYY. MMMM DD.');
		},
		time() {
			return this.$moment.utc(this.data.start).tz(this.timeZone).format('hh:mm');
		}
	},
	methods: {
		deleteAppointment() {
			if (this.approved) {
				this.$emit('submit');
				return;
			}
			
			this.approved = true;
		}
	}
}
</script>