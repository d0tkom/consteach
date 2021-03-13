<template>
	<footer>
		<div class="container">
			<div class="column">
				<div class="title font-bold color-primary-dark">{{ trans.get('footer.website_title') }}</div>
				<inertia-link href="#">
					<c-btn
						color="gray"
						text
					>
						{{ trans.get('footer.language') }}
					</c-btn>
				</inertia-link>
				<inertia-link href="/faq">
					<c-btn
						text
						color="gray"
					>
						{{ trans.get('footer.faq') }}
					</c-btn>
				</inertia-link>
				<inertia-link href="/#registration">
					<c-btn
						text
						color="gray"
					>
						{{ trans.get('footer.registration') }}
					</c-btn>
				</inertia-link>
				<inertia-link href="/teacher-landing">
					<c-btn
						text
						color="gray"
					>
						{{ trans.get('footer.teacher_application') }}
					</c-btn>
				</inertia-link>
			</div>
			<div class="column">
				<div class="title font-bold color-primary-dark">
					{{ trans.get('footer.consteach_title') }}
				</div>
				<inertia-link href="#">
					<c-btn
						text
						color="gray"
					>
						{{ trans.get('footer.about_us') }}
					</c-btn>
				</inertia-link>
				<inertia-link href="#">
					<c-btn
						text
						color="gray"
					>
						{{ trans.get('footer.news') }}
					</c-btn>
				</inertia-link>
				<inertia-link href="#">
					<c-btn
						text
						color="gray"
					>
						{{ trans.get('footer.blog') }}
					</c-btn>
				</inertia-link>
				<inertia-link href="#">
					<c-btn
						text
						color="gray"
					>
						{{ trans.get('footer.community') }}
					</c-btn>
				</inertia-link>
			</div>
			<div class="column">
				<div class="title social font-bold color-primary-dark">
					{{ trans.get('footer.social_title') }}
				</div>
				<inertia-link class="social" :href="trans.get('footer.facebook_url')">
					<img src="/img/facebook_icon.svg" alt="Facebook icon">
				</inertia-link>
				<inertia-link class="social" :href="trans.get('footer.instagram_url')">
					<img src="/img/instagram_icon.svg" alt=")Instagram icon">
				</inertia-link>
				<inertia-link class="social" :href="trans.get('footer.linkedin_in_url')">
					<img src="/img/linkedin_icon.svg" alt="Linkedin-in icon">
				</inertia-link>
				<inertia-link class="social" :href="trans.get('footer.twitter_url')">
					<img src="/img/twitter_icon.svg" alt="Twitter icon">
				</inertia-link>
			</div>
			<div class="column">
				<div class="title font-bold color-primary-dark">
					{{ trans.get('footer.policies_title') }}
				</div>
				<inertia-link href="#">
					<c-btn
						text
						color="gray"
					>
						{{ trans.get('footer.privacy') }}
					</c-btn>
				</inertia-link>
				<inertia-link href="#">
					<c-btn
						text
						color="gray"
					>
						{{ trans.get('footer.terms_of_use') }}
					</c-btn>
				</inertia-link>
				<inertia-link href="#">
					<c-btn
						text
						color="gray"
					>
						{{ trans.get('footer.site_map') }}
					</c-btn>
				</inertia-link>
			</div>
			<div class="column only-screen">
				<div class="title font-bold">
					{{ trans.get('footer.contact_title') }}
				</div>
				<inertia-link :href="'mailto:'+trans.get('footer.email_address')">
					<c-btn
						text
					>
						{{ trans.get('footer.email_address') }}
					</c-btn>
				</inertia-link>
			</div>
		</div>
	</footer>
</template>

<script>
export default {

}
</script>