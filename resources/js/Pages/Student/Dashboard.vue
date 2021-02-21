<template>
    <app-layout>
        <div class="studentHubContainer mt-8">
            <div class="card flat lg">
                <div class="card p-sm">
                    <div class="flex">
                        <div class="profileImg mr-4">
                            <img class="blue-border rounded-full overflow-hidden" :src="$page.props.user.profile_photo_url" alt="Profilkép">
                        </div>
                        <div class="flex flex-col justify-around">
                            <div class="name text-xl font-bold color-primary-dark">
                                {{ $page.props.user.first_name }}
                            </div>
                            <div>
                                <b class="color-primary-dark text-md">Anyanyelv:</b> {{ $page.props.user.country }}
                            </div>
                            <div class="text-md">
                                <b class="color-primary-dark">Beszélt nyelvek:</b>
                                <span v-for="language in $page.props.user.spoken_languages">
                                    {{ language.language }}({{ language.level }})
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                    <div class="col-span-2">
                        <div class="card p-sm">
                            <div class="flex justify-between mb-4">
                                <div class="color-primary-dark text-lg font-bold">Lefoglalt óráim</div>
                                <div class="color-gray">2020. január 21.</div>
                            </div>
                            <div class="events">
                                <booked-event v-for="(appointment, a) in appointments" :key="a" :data="appointment"
                                />
                            </div>
                        </div>
                    </div>
                    <div class="col-span-1">
                        <div class="card p-sm">
                            <div class="color-primary-dark text-lg font-bold mb-4">Tanáraim</div>
                            <teacher
                                v-for="(lesson, l) in lessons"
                                :key="l"
                                :data="lesson"
                            />
                            <div class="flex justify-center">
                                <c-btn
                                    icon="search"
                                >
                                    Új tanárt keresek
                                </c-btn>
                            </div>
                        </div>
                        <div class="card p-sm">
                            <div class="color-primary-dark text-lg font-bold mb-4">Megvásárolt óráim</div>
                            <bought-event
                                v-for="(lesson, l) in lessons"
                                :key="l"
                                
                                :data="lesson"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import BookedEvent from "@/Widgets/BookedEvent";
    import ChangePassword from '@/Popups/ChangePassword'
    import DeleteProfile from "@/Popups/DeleteProfile";
    import BoughtEvent from "@/Widgets/BoughtEvent";
    import Teacher from "@/Widgets/Teacher";
    
    export default {
        components: {
            Teacher,
            BoughtEvent,
            AppLayout,
            BookedEvent,
            ChangePassword,
            DeleteProfile,
        },
        props: {
            lessons: Array,
            appointments: Array
        }
    }
</script>