<template>
    <app-layout>
        <div class="studentHubContainer mt-8">
	        <div v-if="noData" class="card flat md">
		        <div class="card p-sm">
			        <div class="flex">
				        <div class="profileImg mr-4">
					        <img class="blue-border rounded-full overflow-hidden" :src="$page.props.user.profile_photo_url" alt="Profilkép">
				        </div>
				        <div class="flex flex-col justify-around">
					        <div class="name text-xl font-bold color-primary-dark">
						        {{ $page.props.user.first_name }}
					        </div>
				        </div>
			        </div>
		        </div>
		        <div class="card">
			        <h2 class="title font-bold text-xl color-primary-dark mb-2">{{ trans.get('dashboard.fresh_start_title') }}</h2>
			        <p>{{ trans.get('dashboard.fresh_start_description') }}</p>
			        <c-btn
				        class="mt-4"
				        icon="search"
			            navigate-to="/teachers"
			        >{{ trans.get('dashboard.fresh_start_search_teacher_btn') }}</c-btn>
		        </div>
	        </div>
            <div v-else class="card flat lg">
                <div class="card p-sm">
                    <div class="flex">
                        <div class="profileImg mr-4">
                            <img class="blue-border rounded-full overflow-hidden" :src="$page.props.user.profile_photo_url" alt="Profilkép">
                        </div>
                        <div class="flex flex-col justify-around">
                            <div class="name text-xl font-bold color-primary-dark">
                                {{ $page.props.user.first_name }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                    <div class="col-span-2">
                        <div class="card p-sm">
                            <div class="flex justify-between mb-4">
                                <div class="color-primary-dark text-lg font-bold">{{ trans.get('dashboard.booked_lessons') }}</div>
                                <div class="color-gray"></div>
                            </div>
                            <div class="events">
                                <booked-event
                                    v-for="(appointment, a) in appointments"
                                    :key="a"
                                    :data="appointment"
                                />
                            </div>
                        </div>
                    </div>
                    <div class="col-span-1">
                        <div class="card p-sm">
                            <div class="color-primary-dark text-lg font-bold mb-4">{{ trans.get('dashboard.teachers') }}</div>
                            <teacher
                                v-for="(lesson, l) in lessons"
                                :key="l"
                                :data="lesson"
                            />
                            <div class="flex justify-center">
                                <inertia-link href="/teachers">
                                    <c-btn
                                        icon="search"
                                    >
                                        {{ trans.get('dashboard.find_new_teacher_btn') }}
                                    </c-btn>
                                </inertia-link>
                            </div>
                        </div>
                        <div class="card p-sm">
                            <div class="color-primary-dark text-lg font-bold mb-4">{{ trans.get('dashboard.bought_lessons') }}</div>
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
        },
	    computed: {
		    noData() {
		    	if (this.appointments.length) {
		    		return false;
			    }
			
			    if (this.lessons.length) {
					return false;
			    }
			    
			    return true;
		    }
	    }
    }
</script>