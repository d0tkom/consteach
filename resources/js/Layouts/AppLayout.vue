<template>
    <div class="mainSiteContainer" :class="{isLanding}">
	    <div class="pageBg" v-if="!isLanding">
		    <span class="top"></span>
		    <span class="bottom"></span>
	    </div>
	    
	    <siteHeader />
	    
	    <div class="siteContent">
		    <slot></slot>
	    </div>
	
	    <siteFooter />
	
	    <transition name="cookiefade">
		    <cookie-panel
		        v-if="!$root.cookiePolicy.accepted"
		    />
	    </transition>
	    <vue-progress-bar></vue-progress-bar>
    </div>
</template>

<script>
	import SiteHeader from '@/Layouts/Partials/SiteHeader';
	import SiteFooter from "@/Layouts/Partials/SiteFooter";
	import CookiePanel from "@/Layouts/Partials/CookiePanel";
	
    export default {
        components: {
	        CookiePanel,
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