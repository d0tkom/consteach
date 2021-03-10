<template>
    <app-layout>
        <div class="studentHubContainer mt-8">
            <div class="card flat lg">
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
	                                            <flag
		                                            class="text-2xl shadow-sm flagWide"
		                                            :iso="teacher.country === 'en' ? 'us' : teacher.country"
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
                                    <div class="color-gray my-1" v-html="aboutMeText"></div>
                                    <c-btn
                                        text
                                        :icon-right="aboutMeOpened ? 'keyboard_arrow_up' : 'keyboard_arrow_right'"
                                        @click="aboutMeOpened = !aboutMeOpened"
                                    >
                                        {{ trans.get(aboutMeOpened ? 'teacher_profile.less_btn' : 'teacher_profile.more_btn') }}
                                    </c-btn>
                                </div>
                            </div>
                        </div>
                        <div class="card p-sm">
                            <div class="text-md font-bold color-blue-dark">{{ trans.get('teacher_profile.time_table') }}</div>
                            <FullCalendar :options="calendarOptions" />
	
	                        <div class="flex justify-between items-center mt-2">
		                        <div class="p-4">
			                        <div class="text-sm flex items-center">
				                        <div class="colorSample free mr-2"></div>
				                        <span>{{ trans.get('teacher_profile.bookable') }}</span>
			                        </div>
		                        </div>
		
		                        <div class="flex items-center justify-end">
			                        <div class="mr-6">{{ trans.get('teacher_profile.filter_calendar') }}</div>
			                        <c-select
				                        not-nullable
				                        value-key="value"
				                        label-key="label"
				                        class="mr-4 w-28"
				                        :data="filterCalendarTime.options"
				                        v-model="filterCalendarTime.start"
			                        />
			                        <c-select
				                        not-nullable
				                        class="w-28"
				                        value-key="value"
				                        label-key="label"
				                        :data="filterCalendarTime.options"
				                        v-model="filterCalendarTime.end"
			                        />
		                        </div>
	                        </div>
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
                    </div>
                    <div class="col-span-1">
	                    <div class="card p-sm">
		                    <div class="blue-text-color mb-6 text-center sm:text-left ">
			                    <p class="text-lg font-semibold">
				                    {{ trans.get('teacher_profile.free_lesson_title') }}
			                    </p>
			                    <div class="sm:flex mb-10">
				                    <div class="flex-1 sm:text-left text-center">{{ trans.get('teacher_profile.free_lesson_description') }}</div>
				                    <div class="relative flex flex-col items-end">
					                    <div class="text-gray text-sm">
						                    <currency
							                    class="line-through"
							                    :value="(teacher.one_hour_price*fee)/2"
						                    />
						                </div>
					                    <div class="text-green-500 text-lg">
						                    <currency
							                    :value="0"
						                    />
					                    </div>
				                    </div>
			                    </div>
		                    </div>
		                    <div class="flex flex-col items-end">
			                    <c-btn
				                    color="success"
				                    :navigate-to="route('checkout', teacher.id)"
				                    icon="sentiment_satisfied_alt"
			                    >{{ trans.get('teacher_profile.free_lesson_btn') }}</c-btn>
		                    </div>
	                    </div>
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
                                        <div class="text-green-500 text-lg">
	                                        <currency
		                                        :value="teacher.one_hour_price*fee"
	                                        />
	                                    </div>
                                    </div>
                                </div>
                                <div class="sm:flex mb-10">
                                    <div class="flex-1 sm:text-left text-center">5 {{ trans.get('teacher_profile.hours') }}</div>
                                    <div class="relative">
                                        <div class="text-green-500 text-lg">
	                                        <currency
		                                        :value="(teacher.five_hour_price / 5)*fee"
	                                        />
	                                   </div>
                                    </div>
                                </div>
                                <div class="sm:flex mb-10">
                                    <div class="flex-1 sm:text-left text-center">10 {{ trans.get('teacher_profile.hours') }}</div>
                                    <div class="relative">
                                        <div class="text-green-500 text-lg">
	                                        <currency
		                                        :value="(teacher.ten_hour_price / 10)*fee"
	                                        />
	                                    </div>
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
        <BookAppointment
            v-model="appointmentPopup.open"
            :data="appointmentPopup.data"
            @submit="submitAppointment"
            :time-zone="calendarOptions.timeZone"
        />
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
    import BookAppointment from '@/Popups/BookAppointment';
    
    export default {
        components: {
            Teacher,
            BoughtEvent,
            AppLayout,
            BookedEvent,
            ChangePassword,
            DeleteProfile,
            FullCalendar,
            BookAppointment
        },
        props: {
            teacher: Object,
            appointments: Array,
            availabilities: Array,
        },
        data() {
            return {
	            fee: 1.2,
	            filterCalendarTime: {
		            start: '06:00:00',
		            end: '18:00:00',
		            options: [
			            {
				            label: '00:00',
				            value: '00:00:00'
			            }, {
				            label: '01:00',
				            value: '01:00:00'
			            }, {
				            label: '02:00',
				            value: '02:00:00'
			            }, {
				            label: '03:00',
				            value: '03:00:00'
			            }, {
				            label: '04:00',
				            value: '04:00:00'
			            }, {
				            label: '05:00',
				            value: '05:00:00'
			            }, {
				            label: '06:00',
				            value: '06:00:00'
			            }, {
				            label: '07:00',
				            value: '07:00:00'
			            }, {
				            label: '08:00',
				            value: '08:00:00'
			            }, {
				            label: '09:00',
				            value: '09:00:00'
			            }, {
				            label: '10:00',
				            value: '10:00:00'
			            }, {
				            label: '11:00',
				            value: '11:00:00'
			            }, {
				            label: '12:00',
				            value: '12:00:00'
			            }, {
				            label: '13:00',
				            value: '13:00:00'
			            }, {
				            label: '14:00',
				            value: '14:00:00'
			            }, {
				            label: '15:00',
				            value: '15:00:00'
			            }, {
				            label: '16:00',
				            value: '16:00:00'
			            }, {
				            label: '17:00',
				            value: '17:00:00'
			            }, {
				            label: '18:00',
				            value: '18:00:00'
			            }, {
				            label: '19:00',
				            value: '19:00:00'
			            }, {
				            label: '20:00',
				            value: '20:00:00'
			            }, {
				            label: '21:00',
				            value: '21:00:00'
			            }, {
				            label: '22:00',
				            value: '22:00:00'
			            }, {
				            label: '23:00',
				            value: '23:00:00'
			            }
		            ]
	            },
                languageList: null,
                locale: window.default_locale,
	            aboutMeOpened: false,
                appointmentPopup: {
                    open: false,
                    data: {
                        teacher_name: null,
                        date_start: null,
                        date_end: null,
                        eventClickInfo: null
                    }
                },
                calendarOptions: {
	                validRange: {
		                start: moment().format('YYYY-MM-DD')
	                },
	                dayHeaderContent: ({text}) => {
		                let texts = text.split(' ');
		                return `${texts[0]}\n${texts[1]}`;
	                },
                    plugins: [ timeGridPlugin, interactionPlugin ],
                    initialView: 'timeGridWeek',
                    locale: window.default_locale,
	                slotMinTime: '06:00:00',
	                slotMaxTime: '18:00:00',
	                height: 'auto',
                    buttonText: {
                        today:    'mai nap',
                        month:    'hónap',
                        week:     'hét',
                        day:      'nap',
                        list:     'lista'
                    },
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
                    displayEventTime: false,
                    selectable: false,
                    selectOverlap: false,
                    eventClick: this.addAppointment,
                }
            };
        },
	    watch: {
		    filterCalendarTime: {
			    handler(calendarTime) {
				    let data = JSON.stringify({
					    start: calendarTime.start,
					    end: calendarTime.end
				    });
				
				    localStorage.setItem('teacherCalendarFilter', data);
				
				    this.calendarOptions.slotMinTime = calendarTime.start;
				    this.calendarOptions.slotMaxTime = calendarTime.end;
			    }, deep: true
		    }
	    },
        created() {
            this.calendarOptions.timeZone = this.$page.props.user === null ? 'local' : this.$page.props.user.timezone;

            let availabilities = [];

            Object.values(this.availabilities).forEach(availability => {
                let event = {
	                backgroundColor: '#18A0FB',
                    start: moment.utc(availability.start).tz(this.calendarOptions.timeZone).format(),
                    end: moment.utc(availability.end).tz(this.calendarOptions.timeZone).format(),
                };
                availabilities.push(event);
            });

            let appointments = [];

            Object.values(this.appointments).forEach(appointment => {
                let event = {
                    start: moment.utc(appointment.start).tz(this.calendarOptions.timeZone).format(),
                    end: moment.utc(appointment.end).tz(this.calendarOptions.timeZone).format(),
                };
                appointments.push(event);
            });

            this.calendarOptions.events = availabilities.filter(a => !appointments.find(b => b.start === a.start && b.end === a.end));

            this.languageList = require('@cospired/i18n-iso-languages');
            this.languageList.registerLocale(require('@cospired/i18n-iso-languages/langs/en.json'));
            this.languageList.registerLocale(require('@cospired/i18n-iso-languages/langs/hu.json'));
            this.languageList.registerLocale(require('@cospired/i18n-iso-languages/langs/de.json'));
	
	        let localStorage_calendarFilter = localStorage.getItem('teacherCalendarFilter');
	
	        if (localStorage_calendarFilter) {
		        localStorage_calendarFilter = JSON.parse(localStorage_calendarFilter);
		        this.calendarOptions.slotMinTime = this.filterCalendarTime.start = localStorage_calendarFilter.start;
		        this.calendarOptions.slotMaxTime = this.filterCalendarTime.end = localStorage_calendarFilter.end;
	        }
        },
	    computed: {
		    aboutMeText() {
		    	const maxChar = 100;
		    	let text = null;
		    	this.teacher.about_me.forEach(about_me => {
		    		if (about_me.locale === this.locale) {
		    		    return text = about_me.text;
			        }
			    });
		    	
		    	if (!this.aboutMeOpened && text.length > maxChar) {
				    text = text.substring(0, maxChar)+'...';
			    }
		    	
		    	return text;
		    }
	    },
        methods: {
            submitAppointment() {
                let self = this;
                axios.put('/appointment', {
                    params: {
                        start: this.appointmentPopup.data.date_start,
                        end: this.appointmentPopup.data.date_end,
                        teacher_id: this.teacher.id
                    }
                })
                .then(response => {
                    this.appointmentPopup.data.eventClickInfo.event.remove();
                    this.appointmentPopup.open = false;

                    this.$toast.success('Időpont lefoglalva');

                    setTimeout(() => {
                        this.appointmentPopup.data = {
                            teacher_name: null,
                            date_start: null,
                            date_end: null,
                            eventClickInfo: null
                        };
                    }, 500);
                })
                .catch(error => {
                    if (error.response.status == 423) {
                         this.$inertia.visit('/checkout/' + this.teacher.id  + '?appointment=' + error.response.data);
                    } else {
                        this.$toast.error('Időpont foglalása sikertelen');
                    }
                });
            },
            addAppointment: function (eventClickInfo) {
                let self = this;

                if (!this.$page.props.user) {
	                this.$toast.info('A foglaláshoz jelentkezz be vagy regisztrálj!');
                    this.$inertia.visit('/#login');
                }

                if (this.$page.props.user.role !== 'student') {
                    return false;
                }

                // TODO Check user credit
                let hasCredit = true;

                if (!hasCredit) {
	                this.$toast.info('A foglaláshoz vásárolj kreditet a tanárhoz!');
                    this.$inertia.visit('/checkout/'+this.teacher.id);
                }

                this.appointmentPopup.data = {
                    teacher_name: this.teacher.user.first_name + ' ' + this.teacher.user.last_name,
                    date_start: eventClickInfo.event.startStr,
                    date_end: eventClickInfo.event.endStr,
                    eventClickInfo
                };

                this.appointmentPopup.open = true;
            }
        }
    }
</script>