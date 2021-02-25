<template>
    <app-layout>
        <div class="studentHubContainer mt-8">
            <div class="card flat lg">
                <div class="font-bold text-md mb-4">{{ trans.get('teacher_profile.page_title') }}</div>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                    <div class="col-span-2">
                        <div class="card p-sm">
                            <iframe
	                            class="mb-8 w-full"
	                            height="400"
	                            :src="teacher.video_url.replace('watch?v=', 'embed/')"
	                            frameborder="0"
	                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
	                            allowfullscreen
                            ></iframe>
                            <hr class="mb-4">
                            <div class="teacherInfo">
                                <div class="teacherWidgetMainCard flex justify-start">
                                    <div class="profileImageWrapper mr-4">
                                        <img
                                            class="teacherProfileImage max-w-none blue-border rounded-full overflow-hidden mt-4"
                                            :src="teacher.user.profile_photo_url"
                                            alt="Tanár képe"
                                        >
                                    </div>
                                    <div class="w-full flex flex-col">
                                        <div class="flex items-center justify-between mb-4">
                                            <div class="name text-lg font-bold color-primary-dark flex items-center">
                                                <span v-if="false" class="material-icons mr-2 color-green-dark">
                                                    check_circle_outline
                                                </span>
                                                <span class="capitalize mr-4">{{ teacher.user.first_name }}  {{ teacher.user.last_name[0] }}.</span>
	                                            <country-flag
		                                            :country="teacher.user.country"
	                                            />
                                            </div>
                                        </div>
                                        <div>
                                            <div class="text-lg font-bold color-primary-dark flex items-center mb-3">
                                                <span class="material-icons mr-2">school</span>
                                                <div class="flex items-center">
	                                                <div
		                                                v-for="(language, l) in teacher.teaching_languages"
		                                                :key="l"
		                                                class="mr-4"
	                                                >
		                                                <span
		                                                    class="capitalize"
		                                                >{{ languageList.getName(language.language, locale) }}</span>
		                                                <c-tag
			                                                class="ml-4"
			                                                type="success"
			                                                small
		                                                >{{ language.level }}</c-tag>
	                                                </div>
                                                </div>
                                            </div>
                                            <div class="text-lg font-bold color-primary-dark mb-2 flex items-center">
                                                <span class="material-icons mr-2">person</span>
                                                {{ teacher.student_count }} {{ trans.get('teacher_profile.student') }} · {{ teacher.appointment_count }} {{ trans.get('teacher_profile.lessons') }}
                                            </div>
                                            <div>
                                                <span class="color-primary-dark font-lg font-bold">{{ trans.get('teacher_profile.spoken_languages') }}</span>
                                                <span
                                                    class="mr-2"
                                                    v-for="(language, l) in teacher.user.spoken_languages"
                                                    :key="l"
                                                >{{ languageList.getName(language.language, locale) }} ({{ language.level }})</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <div class="text-md font-bold color-blue-dark">{{ trans.get('teacher_profile.introduction') }}</div>
                                    <div class="color-gray my-1" v-html="teacher.about_me[0].text"></div>
                                    <c-btn
                                        navigate-to="#"
                                        text
                                        icon-right="keyboard_arrow_right"
                                    >
                                        {{ trans.get('teacher_profile.more_btn') }}
                                    </c-btn>
                                </div>
                            </div>
                        </div>
                        <div class="card p-sm">
                            <div class="text-md font-bold color-blue-dark">{{ trans.get('teacher_profile.time_table') }}</div>
                        </div>
                        <div class="card p-sm">
                            <div class="text-md font-bold color-blue-dark">{{ trans.get('teacher_profile.resume') }}</div>
                            <div class="resume flex p-4 blue-border">
                                <img class="mr-6" src="/img/resume-studies.svg" alt="Tanulmányok ikon">
                                <div class="flex flex-col items-start">
                                    <div class="mb-4">{{ trans.get('teacher_profile.studies') }}</div>
                                    <ul>
                                        <li class="flex">
                                            <div class="year mr-4">2010 - 2015</div>
                                            <div class="font-bold mr-2">ELTE BTK</div>
                                            <div>Angol szak</div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card p-sm">
                            <FullCalendar :options="calendarOptions" />
                        </div>
                    </div>
                    <div class="col-span-1">
                        <div class="card p-sm">
                            <div class="blue-text-color mb-6 text-center sm:text-left ">
                                <p class="text-lg font-semibold">
	                                {{ trans.get('teacher_profile.private_lessons') }}
                                </p>
                                <p class="">
                                    60 {{ trans.get('teacher_profile.minutes') }} / {{ trans.get('teacher_profile.event') }}
                                </p>
                            </div>
                            <div class="text-center blue-text-color">
                                <div class="sm:flex mb-10">
                                    <div class="flex-1 sm:text-left text-center">1 {{ trans.get('teacher_profile.hour') }}</div>
                                    <div class="relative">
                                        <div class="text-green-500 text-lg">{{ teacher.one_hour_price*1.2 }} HUF</div>
                                    </div>
                                </div>
                                <div class="sm:flex mb-10">
                                    <div class="flex-1 sm:text-left text-center">5 {{ trans.get('teacher_profile.hours') }}</div>
                                    <div class="relative">
                                        <div class="sm:absolute -top-4 right-0 sm:w-28 sm:text-right text-center text-xs text-gray-500 line-through">{{ teacher.one_hour_price*1.2*5 }} HUF</div>
                                        <div class="text-green-500 text-lg">{{ teacher.five_hour_price*1.2 }} HUF</div>
                                    </div>
                                </div>
                                <div class="sm:flex mb-10">
                                    <div class="flex-1 sm:text-left text-center">10 {{ trans.get('teacher_profile.hours') }}</div>
                                    <div class="relative">
                                        <div class="sm:absolute -top-4 right-0 sm:w-28 sm:text-right text-center text-xs text-gray-500 line-through">{{ teacher.one_hour_price*1.2*10 }} HUF</div>
                                        <div class="text-green-500 text-lg">{{ teacher.ten_hour_price*1.2 }} HUF</div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col items-end">
                                <c-btn
                                    class="mb-4"
                                    :navigate-to="route('checkout', teacher.id)"
                                    icon="account_balance_wallet"
                                >{{ trans.get('teacher_profile.buy_btn') }}</c-btn>

                                <c-btn
                                    outlined
                                    icon="chat"
                                >{{ trans.get('teacher_profile.message_btn') }}</c-btn>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout';
    import BookedEvent from "@/Widgets/BookedEvent";
    import ChangePassword from '@/Popups/ChangePassword'
    import DeleteProfile from "@/Popups/DeleteProfile";
    import BoughtEvent from "@/Widgets/BoughtEvent";
    import Teacher from "@/Widgets/Teacher";
    import FullCalendar from '@fullcalendar/vue';
    import timeGridPlugin from '@fullcalendar/timegrid';
    import interactionPlugin from '@fullcalendar/interaction';
    
    export default {
        components: {
            Teacher,
            BoughtEvent,
            AppLayout,
            BookedEvent,
            ChangePassword,
            DeleteProfile,
            FullCalendar,
        },
        props: {
            teacher: Object
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
                    selectable: true,
                    selectOverlap: false,
                    
                }
            };
        },
        created() {
            this.languageList = require('@cospired/i18n-iso-languages');
            this.languageList.registerLocale(require('@cospired/i18n-iso-languages/langs/en.json'));
            this.languageList.registerLocale(require('@cospired/i18n-iso-languages/langs/hu.json'));
            this.languageList.registerLocale(require('@cospired/i18n-iso-languages/langs/de.json'));
        }
    }
</script>