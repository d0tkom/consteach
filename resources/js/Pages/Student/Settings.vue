<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ trans.get('titles.settings') }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg flex justify-center">
                    <edit-profile-data />
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from './../../Layouts/StudentLayout'
    import EditProfileData from './../../Components/Student/EditProfileData'

    export default {
        components: {
            AppLayout,
            EditProfileData,
        },
    }
</script>
