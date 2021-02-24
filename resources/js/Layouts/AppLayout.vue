<template>
    <div class="bg">
	    <site-header />
	    
	    <div class="siteContent">
		    <slot></slot>
	    </div>
	
	    <site-footer />
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
    }
</script>