<template>
	<footer>
		<div class="container">
			<div class="column">
				<div class="title font-bold color-primary-dark">{{ trans.get('footer.website_title') }}</div>
				<inertia-link href="#">
					<c-btn
						text
					>
						{{ trans.get('footer.language') }}
					</c-btn>
				</inertia-link>
				<inertia-link href="/faq">
					<c-btn
						text
					>
						{{ trans.get('footer.faq') }}
					</c-btn>
				</inertia-link>
				<inertia-link href="/#registration">
					<c-btn
						text
					>
						{{ trans.get('footer.registration') }}
					</c-btn>
				</inertia-link>
				<inertia-link href="/teacher-landing">
					<c-btn
						text
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
			<div class="column">
				<div class="title font-bold color-primary-dark">
					{{ trans.get('footer.policies_title') }}
				</div>
				<inertia-link href="#">
					<c-btn
						text
					>
						{{ trans.get('footer.privacy') }}
					</c-btn>
				</inertia-link>
				<inertia-link href="#">
					<c-btn
						text
					>
						{{ trans.get('footer.terms_of_use') }}
					</c-btn>
				</inertia-link>
				<inertia-link href="#">
					<c-btn
						text
					>
						{{ trans.get('footer.cookie_policy') }}
					</c-btn>
				</inertia-link>
			</div>
			<div class="column only-screen">
				<div class="title font-bold">
					{{ trans.get('footer.contact_title') }}
				</div>
				<inertia-link class="social" :href="trans.get('footer.facebook_url')">
					<img src="/img/facebook_icon.svg" alt="Facebook icon">
				</inertia-link>
				<inertia-link class="social" :href="trans.get('footer.instagram_url')">
					<img src="/img/instagram_icon.svg" alt=")Instagram icon">
				</inertia-link>
			</div>
		</div>
	</footer>
</template>

<script>
export default {

}
</script>