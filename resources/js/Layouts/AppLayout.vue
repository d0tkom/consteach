<template>
    <div class="bg">
	    <site-header />
	    
	    <div class="siteContent">
		    <slot></slot>
	    </div>
    </div>
</template>

<script>
	import SiteHeader from '@/Layouts/Partials/SiteHeader';
	
    export default {
        components: {
	        SiteHeader,
        },
    }
</script>