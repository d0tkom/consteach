<template>
	<div>
		{{ dateComputed }}
	</div>
</template>

<script>

export default {
	props: {
		value: String,
		format: {
			type: String,
			default: null
		},
		withDay: {
			type: Boolean,
			default: false
		},
		onlyTime: {
			type: Boolean,
			default: false
		},
		lessonStart: {
			type: Boolean,
			default: false
		},
		length: {
			type: Number,
			default: 30
		},
	},
	data: function() {
		return {
			default: {
				basic: 'MMMM DD, YYYY',
				withDay: 'MMMM DD, YYYY [(]dddd[)]',
				onlyTime: 'hh:mm'
			}
		};
	},
	computed: {
		formatComputed() {
			if (this.format) {
				return this.format;
			}
			
			if (this.withDay) {
				return this.default.withDay;
			}
			
			if (this.onlyTime) {
				return this.default.onlyTime;
			}
			
			return this.default.basic;
		},
		dateComputed() {
			if (this.lessonStart) {
				return this.$moment(this.value).fromNow();
			}
			
			return this.$moment(this.value).format(this.formatComputed);
		}
	},
	methods: {

	}
}
</script>