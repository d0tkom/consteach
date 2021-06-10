<template>
	<footer>
		<div class="container">
			<div class="column">
				<div class="title font-bold color-primary-dark">{{ trans.get('footer.website_title') }}</div>
				<div class="footerSectionContent">
					<inertia-link href="#">
						<c-btn
							text
						>
							{{ trans.get('footer.language') }}
						</c-btn>
					</inertia-link>
					<inertia-link href="/faq-student">
						<c-btn
							text
						>
							{{ trans.get('footer.faq') }}
						</c-btn>
					</inertia-link>
					<c-btn
						@click="$root.openRegistrationPopup()"
						text
					>
						{{ trans.get('footer.registration') }}
					</c-btn>
					<c-btn
						text
						:navigate-to="'/#teach-with-us'"
					>
						{{ trans.get('footer.teacher_application') }}
					</c-btn>
				</div>
			</div>
			<div class="column">
				<div class="title font-bold color-primary-dark">
					{{ trans.get('footer.consteach_title') }}
				</div>
				<div class="footerSectionContent">
					<inertia-link href="#">
						<c-btn
							text
						>
							{{ trans.get('footer.about_us') }}
						</c-btn>
					</inertia-link>
					<inertia-link href="#">
						<c-btn
							text
						>
							{{ trans.get('footer.news') }}
						</c-btn>
					</inertia-link>
					<inertia-link href="#">
						<c-btn
							text
						>
							{{ trans.get('footer.blog') }}
						</c-btn>
					</inertia-link>
				</div>
			</div>
			<div class="column">
				<div class="title font-bold color-primary-dark">
					{{ trans.get('footer.policies_title') }}
				</div>
				<div class="footerSectionContent">
					<c-btn
						text
					>
						<a style="color: #18A0FB" target="_blank" href="/privacy_policy.pdf">{{ trans.get('footer.privacy') }}</a>
					</c-btn>
					<c-btn
						text
					>
						<a style="color: #18A0FB" target="_blank" href="/terms_and_conditions.pdf">{{ trans.get('footer.terms_of_use') }}</a>
					</c-btn>
					<!-- <inertia-link href="/privacy_policy.pdf" target="_blank">
						<c-btn
							text
						>
							{{ trans.get('footer.privacy') }}
						</c-btn>
					</inertia-link>
					<inertia-link href="/terms_and_conditions.pdf" target="_blank">
						<c-btn
							text
						>
							{{ trans.get('footer.terms_of_use') }}
						</c-btn>
					</inertia-link> -->
					<inertia-link href="/cookie-policy">
						<c-btn
							text
						>
							{{ trans.get('footer.cookie_policy') }}
						</c-btn>
					</inertia-link>
				</div>
			</div>
			<div class="contact column only-screen">
				<div class="title font-bold">
					{{ trans.get('footer.contact_title') }}
				</div>
				<div class="footerSectionContent">
					<a class="social" target="_blank" :href="trans.get('footer.facebook_url')">
						<img src="/img/facebook_icon.svg" alt="Facebook icon">
					</a>
					<a class="social" target="_blank" :href="trans.get('footer.instagram_url')">
						<img src="/img/instagram_icon.svg" alt=")Instagram icon">
					</a>
				</div>
			</div>
		</div>
	</footer>
</template>

<script>
export default {

}
</script>