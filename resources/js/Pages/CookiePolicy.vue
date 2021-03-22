<template>
	<app-layout>
		<div class="flex flex-col items-center flat card lg lg:px-16">
			<div class="tabs flex mb-8">
				<c-btn
					class="m-2"
					:outlined="$page.component !== 'TermsAndConditions'"
					navigate-to="/terms-and-conditions"
				>{{ trans.get('legal.terms_and_conditions') }}</c-btn>
				<c-btn
					class="m-2"
					:outlined="$page.component !== 'PrivacyPolicy'"
					navigate-to="/privacy-policy"
				>{{ trans.get('legal.privacy_policy') }}</c-btn>
				<c-btn
					class="m-2"
					:outlined="$page.component !== 'CookiePolicy'"
					navigate-to="/cookie-policy"
				>{{ trans.get('legal.cookie_policy') }}</c-btn>
			</div>
			
			<div class="card">
				<h1 class="title text-2xl font-bold mb-4">{{ trans.get('legal.cookie_policy') }}</h1>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec vehicula ante quis pulvinar eleifend. Proin non tellus eu sapien viverra elementum nec at lectus. Vivamus tortor ante, fringilla ut efficitur quis, gravida sed erat. Nullam non odio volutpat, porta sem vitae, rhoncus metus. Fusce quis pellentesque erat. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nulla maximus eget sem ac venenatis. Praesent finibus turpis id iaculis porta.
					Donec cursus accumsan nibh, a fermentum metus. Donec maximus ligula nec tortor dapibus, eu iaculis nulla mattis. Mauris mattis semper augue at hendrerit. Cras imperdiet ante non tortor suscipit, et iaculis metus faucibus. In gravida iaculis diam vitae facilisis. Mauris bibendum interdum libero a porttitor. Suspendisse porttitor nibh et dignissim porttitor. Suspendisse pellentesque a odio vehicula eleifend. Vestibulum quis malesuada sem. Aliquam mattis ipsum et commodo bibendum. Donec a ultrices elit, sit amet tincidunt libero. Nam euismod eros vitae sagittis euismod. Aenean interdum orci tellus. Donec cursus ut magna gravida porta.
					
					Pellentesque iaculis mi sed iaculis iaculis. Sed ac feugiat lectus. Phasellus sagittis ipsum nec leo finibus dapibus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Phasellus euismod pulvinar urna, id laoreet diam sagittis vel. Praesent vulputate iaculis ligula, quis luctus ante mattis sit amet. In hac habitasse platea dictumst. Nulla est erat, maximus nec orci ut, convallis viverra ante. Phasellus consequat luctus vehicula. Curabitur pulvinar, nisi ut pharetra pulvinar, nibh mauris rhoncus ligula, et tempor nisl enim eu tortor. Cras ex augue, imperdiet eget metus sed, porta condimentum magna. Etiam vel elementum nulla.
					
					Quisque imperdiet orci mollis ligula ultrices, a facilisis erat tincidunt. Pellentesque laoreet accumsan massa, id blandit nibh mollis et. Nullam dignissim, metus id lobortis tempor, augue erat scelerisque magna, sit amet iaculis ligula lorem eget magna. Proin tempor ipsum eu metus scelerisque, eu accumsan tortor euismod. Sed congue gravida felis ut congue. In et nibh eu est interdum blandit a a nunc. Maecenas ornare purus efficitur libero auctor imperdiet. Morbi tortor lorem, fringilla condimentum molestie a, varius non nisl. Praesent pellentesque nisl sem, a feugiat libero rhoncus a. Nullam eleifend gravida enim a pulvinar.</p>
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
			tab: 0,
			
		};
	},
	mounted() {
		let title = this.trans.get('legal.cookie_policy_document_title');
		this.$root.documentTitle(title);
	},
	methods: {
	
	}
}
</script>