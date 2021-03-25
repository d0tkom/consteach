<template>
	<div
		class="popUpContainer flex items-center justify-center"
		:class="{active, large}"
	>
		<div
			class="popUpBg"
			@click="$emit('close')"
		></div>
		<div class="popupContent bg-white shadow-2xl">
			<logo
				class="brandLogo"
				:width="200"
				:height="60"
			/>
			<c-btn
				class="closeBtn"
				icon="close"
				icon-only
				text
				circle
				@click="$emit('close')"
			></c-btn>
			<h4 v-if="title" class="title text-lg color-primary-dark mb-8 text-center">{{ title }}</h4>
			<slot />
		</div>
	</div>
</template>

<script>
import Logo from "@/Layouts/Partials/Logo";
import scrollLock from 'scroll-lock';

export default {
	components: {Logo},
	props: {
		value: {
			type: Boolean,
			default: false
		},
		large: {
			type: Boolean,
			default: false
		},
		title: {
			type: String,
			default: null
		},
	},
	data: function() {
		return {
			active: this.value
		};
	},
	watch: {
		value(value) {
			this.active = value;
		},
		active(active) {
			this.lockBody(active);
		}
	},
	methods: {
		lockBody(value) {
			if (value) {
				scrollLock.disablePageScroll();
				$('header').addClass('scrollLock');
			} else {
				scrollLock.enablePageScroll();
				$('header').removeClass('scrollLock');
			}
		}
	}
}
</script>