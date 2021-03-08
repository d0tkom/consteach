<template>
	<footer>
		<div class="container">
			<div class="column">
				<div class="title font-bold color-primary-dark">{{ trans.get('footer.website_title') }}</div>
				<a href="#">{{ trans.get('footer.language') }}</a>
				<a href="/faq">{{ trans.get('footer.language') }}</a>
				<a href="/#registration">{{ trans.get('footer.registration') }}</a>
				<a href="/teacher-landing">{{ trans.get('footer.teacher_application') }}</a>
			</div>
			<div class="column">
				<div class="title font-bold color-primary-dark">{{ trans.get('footer.consteach_title') }}</div>
				<a href="#">{{ trans.get('footer.about_us') }}</a>
				<a href="#">{{ trans.get('footer.news') }}</a>
				<a href="#">{{ trans.get('footer.blog') }}</a>
				<a href="#">{{ trans.get('footer.community') }}</a>
			</div>
			<div class="column">
				<div class="title font-bold color-primary-dark">{{ trans.get('footer.social_title') }}</div>
				<a href="#"><i class="fab fa-facebook"></i></a>
				<a href="#"><i class="fab fa-instagram"></i></a>
				<a href="#"><i class="fab fa-linkedin-in"></i></a>
				<a href="#"><i class="fab fa-twitter"></i></a>
			</div>
			<div class="column">
				<div class="title font-bold color-primary-dark">{{ trans.get('footer.policies_title') }}</div>
				<a href="#">{{ trans.get('footer.privacy') }}</a>
				<a href="#">{{ trans.get('footer.terms_of_use') }}</a>
				<a href="#">{{ trans.get('footer.site_map') }}</a>
			</div>
			<div class="column only-screen">
				<div class="title font-bold">{{ trans.get('footer.contact_title') }}</div>
				<a :href="'mailto:'+trans.get('footer.email_address')">info@consteach.com</a>
			</div>
		</div>
	</footer>
</template>

<script>
export default {

}
</script>