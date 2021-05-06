<template>
	<div class="btnContainer" :class="{iconOnly, loading, 'w-full': full}">
		<div
			@click="onClick"
			class="cBtn inline-flex items-center justify-center"
			:class="[
				outlined && 'outlined',
				circle && 'circle',
				error && 'error',
				disabled && 'disabled',
				text && 'text',
				small && 'small',
				medium && 'medium',
				large && 'large',
				full && 'full',
				glow && 'glow',
				alignLeft && 'align-left',
				'color-'+color
			]"
		>
			<span
				v-if="icon"
				class="material-icons btnIcon"
			>
				{{ icon }}
			</span>
			<span class="btnContent">
				<slot v-if="!iconOnly"/>
			</span>
			<span
				v-if="iconRight"
				class="material-icons btnIcon btnIconRight"
			>
				{{ iconRight }}
			</span>
			
			<span class="spinner">
				<span
					v-if="loading"
					class="material-icons loadingIcon"
				>cached</span>
			</span>
		</div>
	</div>
</template>

<script>
import 'material-icons/iconfont/material-icons.scss';

export default {
	props: {
		error: {
			type: Boolean,
			default: false
		},
		iconOnly: {
			type: Boolean,
			default: false
		},
		text: {
			type: Boolean,
			default: false
		},
		color: {
			type: String,
			default: 'primary'
		},
		outlined: {
			type: Boolean,
			default: false
		},
		full: {
			type: Boolean,
			default: false
		},
		small: {
			type: Boolean,
			default: false
		},
		medium: {
			type: Boolean,
			default: false
		},
		disabled: {
			type: Boolean,
			default: false
		},
		large: {
			type: Boolean,
			default: false
		},
		circle: {
			type: Boolean,
			default: false
		},
		loading: {
			type: Boolean,
			default: false
		},
		icon: {
			type: String,
			default: null
		},
		iconRight: {
			type: String,
			default: null
		},
		alignLeft: {
			type: Boolean,
			default: false
		},
		glow: {
			type: Boolean,
			default: false
		},
		navigateTo: {
			type: String,
			default: null
		}
	},
	methods: {
		onClick(event) {
			if (this.navigateTo) {
				return this.$inertia.visit(this.navigateTo);
			}
			
			this.$emit('click', event);
		}
	}
}
</script>