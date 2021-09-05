<template>
	<app-layout>
		<div class="flex flex-col items-center flat card lg lg:px-16">
			<div class="tabs flex mb-12 font-bold text-3xl">
				{{ trans.get('faq_teacher.title') }}
			</div>
			
			<div class="card">
				<div class="text-md font-bold color-blue-dark">{{ trans.get('faq_teacher.contact_title') }}</div>
				<p v-html="trans.get('faq_teacher.contact_description')"></p><br>
				<cInput
                    v-model="contact.email"
                    class="mb-4"
                    :label="trans.get('settings.email_label')"
                ></cInput>
				<c-text-area
					:hint="trans.get('faq_teacher.contact_max_char')"
					:max="250"
					class="mb-4"
					v-model="contact.text"
				/>
				<c-btn
					:loading="contact.loading"
					@click="submitContactForm"
					:disabled="contact.text.length > 1000 || contact.text.length < 3"
				>
					{{ trans.get('faq_teacher.contact_btn') }}
				</c-btn>
			</div>
			
			<div class="tabs flex-col sm:flex-row flex my-8 items-center">
				<c-btn
					class="m-2"
					:outlined="$page.component !== 'Student/Faq'"
					navigate-to="/faq-student"
				>{{ trans.get('faq_teacher.faq_tab_student') }}</c-btn>
				<c-btn
					class="m-2"
					:outlined="$page.component !== 'Teacher/Faq'"
					navigate-to="/faq-teacher"
				>{{ trans.get('faq_teacher.faq_tab_teacher') }}</c-btn>
			</div>

			<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
				<div class="card">
					<h1 class="title text-xl font-bold mb-2">{{ trans.get('faq_teacher.question_01_title') }}</h1>
					<p
						v-if="openedQuestion === 0"
					>{{ trans.get('faq_teacher.question_01_description') }}</p>
					<p
						v-else
					>{{ trans.get('faq_teacher.question_01_description').substring(0, 100) }}</p>
					<c-btn
						v-if="openedQuestion !== 0"
						text
						class="mt-2"
						icon="keyboard_arrow_right"
						@click="openedQuestion = 0"
					>{{ trans.get('faq_teacher.more_btn') }}</c-btn>
					<c-btn
						v-else
						text
						class="mt-2"
						icon="keyboard_arrow_up"
						@click="openedQuestion = null"
					>{{ trans.get('faq_teacher.less_btn') }}</c-btn>
				</div>
				<div class="card">
					<h1 class="title text-xl font-bold mb-2">{{ trans.get('faq_teacher.question_02_title') }}</h1>
					<p
						v-if="openedQuestion === 1"
					>{{ trans.get('faq_teacher.question_02_description') }}</p>
					<p
						v-else
					>{{ trans.get('faq_teacher.question_02_description').substring(0, 100) }}</p>
					<c-btn
						v-if="openedQuestion !== 1"
						text
						class="mt-2"
						icon="keyboard_arrow_right"
						@click="openedQuestion = 1"
					>{{ trans.get('faq_teacher.more_btn') }}</c-btn>
					<c-btn
						v-else
						text
						class="mt-2"
						icon="keyboard_arrow_up"
						@click="openedQuestion = null"
					>{{ trans.get('faq_teacher.less_btn') }}</c-btn>
				</div>
				<div class="card">
					<h1 class="title text-xl font-bold mb-2">{{ trans.get('faq_teacher.question_03_title') }}</h1>
					<p
						v-if="openedQuestion === 2"
					>{{ trans.get('faq_teacher.question_03_description') }}</p>
					<p
						v-else
					>{{ trans.get('faq_teacher.question_03_description').substring(0, 100) }}</p>
					<c-btn
						v-if="openedQuestion !== 2"
						text
						class="mt-2"
						icon="keyboard_arrow_right"
						@click="openedQuestion = 2"
					>{{ trans.get('faq_teacher.more_btn') }}</c-btn>
					<c-btn
						v-else
						text
						class="mt-2"
						icon="keyboard_arrow_up"
						@click="openedQuestion = null"
					>{{ trans.get('faq_teacher.less_btn') }}</c-btn>
				</div>
				<div class="card">
					<h1 class="title text-xl font-bold mb-2">{{ trans.get('faq_teacher.question_04_title') }}</h1>
					<p
						v-if="openedQuestion === 3"
					>{{ trans.get('faq_teacher.question_04_description') }}</p>
					<p
						v-else
					>{{ trans.get('faq_teacher.question_04_description').substring(0, 100) }}</p>
					<c-btn
						v-if="openedQuestion !== 3"
						text
						class="mt-2"
						icon="keyboard_arrow_right"
						@click="openedQuestion = 3"
					>{{ trans.get('faq_teacher.more_btn') }}</c-btn>
					<c-btn
						v-else
						text
						class="mt-2"
						icon="keyboard_arrow_up"
						@click="openedQuestion = null"
					>{{ trans.get('faq_teacher.less_btn') }}</c-btn>
				</div>
				<div class="card">
					<h1 class="title text-xl font-bold mb-2">{{ trans.get('faq_teacher.question_05_title') }}</h1>
					<p
						v-if="openedQuestion === 4"
					>{{ trans.get('faq_teacher.question_05_description') }}</p>
					<p
						v-else
					>{{ trans.get('faq_teacher.question_05_description').substring(0, 100) }}</p>
					<c-btn
						v-if="openedQuestion !== 4"
						text
						class="mt-2"
						icon="keyboard_arrow_right"
						@click="openedQuestion = 4"
					>{{ trans.get('faq_teacher.more_btn') }}</c-btn>
					<c-btn
						v-else
						text
						class="mt-2"
						icon="keyboard_arrow_up"
						@click="openedQuestion = null"
					>{{ trans.get('faq_teacher.less_btn') }}</c-btn>
				</div>
				<div class="card">
					<h1 class="title text-xl font-bold mb-2">{{ trans.get('faq_teacher.question_06_title') }}</h1>
					<p
						v-if="openedQuestion === 5"
					>{{ trans.get('faq_teacher.question_06_description') }}</p>
					<p
						v-else
					>{{ trans.get('faq_teacher.question_06_description').substring(0, 100) }}</p>
					<c-btn
						v-if="openedQuestion !== 5"
						text
						class="mt-2"
						icon="keyboard_arrow_right"
						@click="openedQuestion = 5"
					>{{ trans.get('faq_teacher.more_btn') }}</c-btn>
					<c-btn
						v-else
						text
						class="mt-2"
						icon="keyboard_arrow_up"
						@click="openedQuestion = null"
					>{{ trans.get('faq_teacher.less_btn') }}</c-btn>
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
			contact: {
				loading: false,
				text: '',
				email: '',
			}
		};
	},
	mounted() {
		let title = this.trans.get('faq_teacher.document_title');
		this.$root.documentTitle(title);
	},
	methods: {
		submitContactForm() {
			this.contact.loading = true;
			axios.post('/contact', {
				text: this.contact.text,
				email: this.contact.email
			}).then(({data}) => {
				this.contact.submitted = true;
				this.contact.loading = false;
				this.contact.text = "";
				this.contact.email = "";
				this.$toast.success(this.trans.get('faq.submit_success_notification'));
			}).catch(error => {
				console.error(error);
				this.contact.loading = false;
				this.$toast.error(this.trans.get('faq.submit_fail_notification'));
			});
		}
	}
}
</script>