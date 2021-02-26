<template>
    <app-layout>
        <div class="teacherHubContainer mt-8">
            <div class="card flat lg">
                <div class="card p-sm">
                    <div class="flex justify-between">
                        <div class="flex items-center">
                            <div class="profileImg blue-border rounded-full overflow-hidden mr-8">
                                <img :src="$page.props.user.profile_photo_url" alt="Profilkép">
                            </div>
                            <div class="name text-3xl font-bold color-primary-dark">
                                {{ $page.props.user.first_name }}
                            </div>
                        </div>
                        <div class="flex items-center">
                            <div class="infoItem flex mx-4">
                                <div class="mr-4">
                                    <img
	                                    height="40"
	                                    src="/img/student_icon.svg"
	                                    alt="Diák ikon"
                                    >
                                </div>
                                <div class="text-center">
                                    <div class="color-primary-dark font-bold">
                                        {{ $page.props.user.extra.student_count }}
                                    </div>
                                    <div class="color-gray font-bold">{{ trans.get('dashboard.student') }}</div>
                                </div>
                            </div>
                            <div class="infoItem flex mx-4">
                                <div  class="mr-4">
                                    <img
	                                    height="40"
	                                    src="/img/sand_glass.svg"
	                                    alt="Diák ikon"
                                    >
                                </div>
                                <div class="text-center">
                                    <div class="color-primary-dark font-bold">
                                        {{ $page.props.user.extra.appointment_count }}
                                    </div>
                                    <div class="color-gray font-bold">{{ trans.get('dashboard.lesson') }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col justify-center">
                            <div class="flex items-center">
                                <span class="walletIcon material-icons mr-2 text-2xl color-primary-dark">account_balance_wallet</span>
                                <span class="font-bold text-2xl color-green-dark">15,000 HUF</span>
                            </div>
                            <div class="text-right">{{ trans.get('dashboard.balance') }}</div>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                    <div class="col-span-2 card p-sm">
                        <div class="flex justify-between mb-4">
                            <div class="color-primary-dark text-lg font-bold">{{ trans.get('dashboard.booked_lessons') }}</div>
                            <div class="color-gray">2020. január 21.</div>
                        </div>
                        <div class="events">
                            <booked-event
                                v-for="(appointment, a) in appointments"
                                :key="a"
                                from-teacher
                                :data="appointment"
                            />
                        </div>
                    </div>
                    <div class="col-span-2 card p-sm">
                        <FullCalendar :options="calendarOptions" />
                    </div>
                    <!-- Sidebar -->
                    <div class="col-span-1">
                        <div class="card p-sm">
                            <div class="color-primary-dark text-lg font-bold mb-4">{{ trans.get('dashboard.my_students') }}</div>
                            <bought-event
                                v-for="(lesson, l) in lessons"
                                :key="l"
                                from-teacher
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
    import BoughtEvent from "@/Widgets/BoughtEvent";
    import FullCalendar from '@fullcalendar/vue';
    import timeGridPlugin from '@fullcalendar/timegrid';
    import interactionPlugin from '@fullcalendar/interaction';
    
    export default {
        components: {
            BoughtEvent,
            AppLayout,
            BookedEvent,
            FullCalendar,
        },
        props: {
            lessons: Array,
            appointments: Array,
        },
        data() {
            return {
                languageList: null,
                locale: window.default_locale,
                calendarOptions: {
                    plugins: [ timeGridPlugin, interactionPlugin ],
                    initialView: 'timeGridWeek',
                    locale: window.default_locale,
                    buttonText: {
                        today:    'mai nap',
                        month:    'hónap',
                        week:     'hét',
                        day:      'nap',
                        list:     'lista'
                    },
                    allDayText: 'egész nap',
                    firstDay: 1,
                    slotDuration: '01:00:00',
                    dayHeaderFormat: { 
                        weekday: 'long' ,
                        day: 'numeric',
                        omitCommas: true
                    },
                    allDaySlot: false,
                    slotLabelFormat: {
                        hour: '2-digit',
                        minute: '2-digit',
                        meridiem: 'long'
                    },
                    headerToolbar: {
                        left: 'prev',
                        center: 'title',
                        right: 'next'
                    },
                    events: [],
                    selectable: true,
                    selectOverlap: false,
                    select: function (selectionInfo) {
                        console.log(selectionInfo);
                        axios.put('/availability', {params: {
                            start: selectionInfo.startStr,
                            end: selectionInfo.endStr
                        }})
                            .then(function (response) {
                                console.log(response);
                            })
                            .catch(function (error) {
                                console.log(error);
                            });
                    },
                }
            };
        },
        created() {
            this.calendarOptions.timeZone = this.$page.props.user === null ? 'local' : this.$page.props.user.timezone;
        },
        methods: {
        }
    }
</script>