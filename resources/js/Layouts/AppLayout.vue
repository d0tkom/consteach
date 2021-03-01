<template>
    <div class="bg mainSiteContainer" :class="{isLanding}">
	    <siteHeader />
	    
	    <div class="siteContent">
		    <slot></slot>
	    </div>
	
	    <siteFooter />
    </div>
</template>

<script>
	import SiteHeader from '@/Layouts/Partials/SiteHeader';
	import SiteFooter from "@/Layouts/Partials/SiteFooter";
	
    export default {
        components: {
	        SiteFooter,
	        SiteHeader,
        },
		computed: {
			isLanding() {
				return this.$inertia.page.component === 'Landing' || this.$inertia.page.component === 'TeacherLanding';
			}
		}
    }
</script>