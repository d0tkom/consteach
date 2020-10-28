<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ trans.get('titles.profile') }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <p>First name: {{ $page.props.user.first_name }}</p>
                    <p>Last name: {{ $page.props.user.last_name }}</p>
                    <p>Nationality: {{ $page.props.user.country }}</p>
                    <p>Phone: {{ $page.props.user.phone_number }}</p>
                    <p>Video: {{ $page.props.user.video }}</p>
                    <p>Email: {{ $page.props.user.email }}</p>
                    <p>Email: {{ $page.props.user.email }}</p>
                    <p>Email: {{ $page.props.user.email }}</p>
                    <p>Email: {{ $page.props.user.email }}</p>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from './../Layouts/AppLayout'
    import Welcome from './../Jetstream/Welcome'

    export default {
        components: {
            AppLayout,
            Welcome,
        },
    }
</script>
