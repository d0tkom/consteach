<template>
	<app-layout>
		<div class="flex flex-col items-center flat card lg lg:px-16">
			<div class="tabs flex mb-12 font-bold text-3xl">
				{{ trans.get('faq.title') }}
			</div>

			<div class="grid grid-cols-2 gap-4">
				<div class="card">
					<h1 class="title text-xl font-bold mb-2">{{ trans.get('faq.question_01_title') }}</h1>
					<p
						v-if="openedQuestion === 0"
					>{{ trans.get('faq.question_01_description') }}</p>
					<p
						v-else
					>{{ trans.get('faq.question_01_description').substring(0, 100) }}</p>
					<c-btn
						v-if="openedQuestion !== 0"
						text
						class="mt-2"
						icon="keyboard_arrow_right"
						@click="openedQuestion = 0"
					>{{ trans.get('faq.more_btn') }}</c-btn>
					<c-btn
						v-else
						text
						class="mt-2"
						icon="keyboard_arrow_up"
						@click="openedQuestion = null"
					>{{ trans.get('faq.less_btn') }}</c-btn>
				</div>
				<div class="card">
					<h1 class="title text-xl font-bold mb-2">{{ trans.get('faq.question_02_title') }}</h1>
					<p
						v-if="openedQuestion === 1"
					>{{ trans.get('faq.question_02_description') }}</p>
					<p
						v-else
					>{{ trans.get('faq.question_02_description').substring(0, 100) }}</p>
					<c-btn
						v-if="openedQuestion !== 1"
						text
						class="mt-2"
						icon="keyboard_arrow_right"
						@click="openedQuestion = 1"
					>{{ trans.get('faq.more_btn') }}</c-btn>
					<c-btn
						v-else
						text
						class="mt-2"
						icon="keyboard_arrow_up"
						@click="openedQuestion = null"
					>{{ trans.get('faq.less_btn') }}</c-btn>
				</div>
				<div class="card">
					<h1 class="title text-xl font-bold mb-2">{{ trans.get('faq.question_03_title') }}</h1>
					<p
						v-if="openedQuestion === 2"
					>{{ trans.get('faq.question_03_description') }}</p>
					<p
						v-else
					>{{ trans.get('faq.question_03_description').substring(0, 100) }}</p>
					<c-btn
						v-if="openedQuestion !== 2"
						text
						class="mt-2"
						icon="keyboard_arrow_right"
						@click="openedQuestion = 2"
					>{{ trans.get('faq.more_btn') }}</c-btn>
					<c-btn
						v-else
						text
						class="mt-2"
						icon="keyboard_arrow_up"
						@click="openedQuestion = null"
					>{{ trans.get('faq.less_btn') }}</c-btn>
				</div>
				<div class="card">
					<h1 class="title text-xl font-bold mb-2">{{ trans.get('faq.question_04_title') }}</h1>
					<p
						v-if="openedQuestion === 3"
					>{{ trans.get('faq.question_04_description') }}</p>
					<p
						v-else
					>{{ trans.get('faq.question_04_description').substring(0, 100) }}</p>
					<c-btn
						v-if="openedQuestion !== 3"
						text
						class="mt-2"
						icon="keyboard_arrow_right"
						@click="openedQuestion = 3"
					>{{ trans.get('faq.more_btn') }}</c-btn>
					<c-btn
						v-else
						text
						class="mt-2"
						icon="keyboard_arrow_up"
						@click="openedQuestion = null"
					>{{ trans.get('faq.less_btn') }}</c-btn>
				</div>
				<div class="card">
					<h1 class="title text-xl font-bold mb-2">{{ trans.get('faq.question_05_title') }}</h1>
					<p
						v-if="openedQuestion === 4"
					>{{ trans.get('faq.question_05_description') }}</p>
					<p
						v-else
					>{{ trans.get('faq.question_05_description').substring(0, 100) }}</p>
					<c-btn
						v-if="openedQuestion !== 4"
						text
						class="mt-2"
						icon="keyboard_arrow_right"
						@click="openedQuestion = 4"
					>{{ trans.get('faq.more_btn') }}</c-btn>
					<c-btn
						v-else
						text
						class="mt-2"
						icon="keyboard_arrow_up"
						@click="openedQuestion = null"
					>{{ trans.get('faq.less_btn') }}</c-btn>
				</div>
				<div class="card">
					<h1 class="title text-xl font-bold mb-2">{{ trans.get('faq.question_06_title') }}</h1>
					<p
						v-if="openedQuestion === 5"
					>{{ trans.get('faq.question_06_description') }}</p>
					<p
						v-else
					>{{ trans.get('faq.question_06_description').substring(0, 100) }}</p>
					<c-btn
						v-if="openedQuestion !== 5"
						text
						class="mt-2"
						icon="keyboard_arrow_right"
						@click="openedQuestion = 5"
					>{{ trans.get('faq.more_btn') }}</c-btn>
					<c-btn
						v-else
						text
						class="mt-2"
						icon="keyboard_arrow_up"
						@click="openedQuestion = null"
					>{{ trans.get('faq.less_btn') }}</c-btn>
				</div>
			</div>
		</div>
	</app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";

export default {
	components: {AppLayout},
	data() {
		return {
			openedQuestion: null,
		};
	},
	mounted() {
		let title = this.trans.get('faq.document_title');
		this.$root.documentTitle(title);
	}
}
</script>