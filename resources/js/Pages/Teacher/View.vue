<template>
    <app-layout>
        <div class="studentHubContainer mt-8">
            <div class="card flat lg">
                <div
	                class="mainGrid grid grid-cols-1 gap-4"
	                :class="!$root.isCurrentUserTeacher ? 'lg:grid-cols-3' : 'currentUserTeacher'"
                >
                    <div class="col-span-2">
                        <div class="mobileReversedCol card p-sm">
                            <iframe
	                            class="mb-8 w-full"
	                            height="400"
	                            :src="videoUrl"
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
                                    <div class="teacherInfo w-full flex flex-col">
                                        <div class="teacherInfoTop flex items-center justify-between mb-4">
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
                                                <span class="studentInfoIcon material-icons mr-2">school</span>
                                                <div class="teacherLanguagesContainer flex items-center">
	                                                <div
		                                                v-for="(language, l) in teacher.teaching_languages"
		                                                :key="l"
		                                                class="languageItem mr-4"
	                                                >
		                                                <span
		                                                    class="capitalize"
		                                                >{{ languageList.getName(language.language, locale) }}</span>
		                                                <c-tag
			                                                class="ml-4"
			                                                :type="language.level === 'native' ? 'success' : 'primary'"
			                                                small
		                                                >{{ language.level === 'native' ? trans.get('other.native') : language.level }}</c-tag>
	                                                </div>
                                                </div>
                                            </div>
                                            <div class="text-lg font-bold color-primary-dark mb-2 flex items-center">
                                                <span class="studentInfoIcon material-icons mr-2">person</span>
	                                            <span class="studentStats">
		                                            <span>{{ teacher.student_count }} {{ trans.get('teacher_profile.student') }}</span>
		                                            <span> · </span>
		                                            <span>{{ teacher.appointment_count }} {{ trans.get('teacher_profile.lessons') }}</span>
	                                            </span>
                                            </div>
                                            <div>
                                                <span class="color-primary-dark font-lg font-bold">{{ trans.get('teacher_profile.spoken_languages') }}</span>
                                                <span
                                                    class="capitalize mr-2"
                                                    v-for="(language, l) in teacher.user.spoken_languages"
                                                    :key="l"
                                                >{{ languageList.getName(language.language, locale) }} ({{ language.level }})</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <div class="text-md font-bold color-blue-dark">{{ trans.get('teacher_profile.introduction') }}</div>
                                    <div class="color-gray my-1" v-html="aboutMeText.value"></div>
                                    <c-btn
	                                    v-if="!aboutMeText.full"
                                        text
                                        :icon-right="aboutMeOpened ? 'keyboard_arrow_up' : 'keyboard_arrow_right'"
                                        @click="aboutMeOpened = !aboutMeOpened"
                                    >
                                        {{ trans.get(aboutMeOpened ? 'teacher_profile.less_btn' : 'teacher_profile.more_btn') }}
                                    </c-btn>
                                </div>
                            </div>
                        </div>
                        <div
	                        v-if="!$root.isCurrentUserTeacher"
	                        class="card p-sm"
	                        id="calendar"
                        >
                            <div class="text-md font-bold color-blue-dark mb-4">{{ trans.get('teacher_profile.time_table') }}</div>
	
	                        <div class="title text-md font-bold color-primary-dark">
		                        {{ trans.get('teacher_profile.calendar_title') }}
	                        </div>
	                        <p class="mb-8">
		                        {{ trans.get('teacher_profile.calendar_subtitle') }}
	                        </p>
	                        
	                        <FullCalendar :options="calendarOptions" />
	
	                        <div class="calendarFooter flex justify-between items-center mt-2">
		                        <div class="calendarFooterLabels p-4">
			                        <div class="text-sm flex items-center">
				                        <div class="colorSample free mr-2"></div>
				                        <span>{{ trans.get('teacher_profile.bookable') }}</span>
			                        </div>
		                        </div>
		
		                        <div class="calendarFooterOptions flex items-center justify-end">
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
	                    <!--
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
                        -->
                    </div>
                    <div
	                    v-if="!$root.isCurrentUserTeacher"
	                    class="col-span-1"
                    >
	                    <div v-if="$page.props.user ? $page.props.user.extra.trial_available : true" class="card freeLessonCard p-sm">
		                    <div class="blue-text-color mb-6 text-center sm:text-left ">
			                    <p class="text-lg font-semibold">
				                    {{ trans.get('teacher_profile.free_lesson_title') }}
			                    </p>
			                    <div class="sm:flex mb-10">
				                    <div class="flex-1 sm:text-left text-center">{{ trans.get('teacher_profile.free_lesson_description') }}</div>
				                    <div class="price relative flex flex-col items-end">
					                    <div class="originalPrice text-gray text-sm">
						                    <currency
							                    class="line-through"
							                    :value="(teacher.one_hour_price/$root.fee)"
						                    />
						                </div>
					                    <div class="newPRice text-green-500 text-lg">
						                    <currency
							                    :value="0"
						                    />
                                             / {{ trans.get('teacher_profile.hour') }}
					                    </div>
				                    </div>
			                    </div>
		                    </div>
		                    <div class="ctaContainer flex flex-col items-end">
			                    <c-btn
				                    color="success"
				                    icon="sentiment_satisfied_alt"
				                    @click="clickedFreeLessonBtn"
				                    v-scroll-to="'#calendar'"
			                    >{{ trans.get('teacher_profile.free_lesson_btn') }}</c-btn>
		                    </div>
	                    </div>
                        <div
	                        v-if="!$root.isCurrentUserTeacher"
	                        class="priceTableCard card p-sm"
                        >
                            <div class="blue-text-color mb-6 text-center sm:text-left ">
                                <p class="text-lg font-semibold">
	                                {{ trans.get('teacher_profile.private_lessons') }}
                                </p>
                                <p class="">
                                    60 {{ trans.get('teacher_profile.minutes') }} / {{ trans.get('teacher_profile.event') }}
                                </p>
                            </div>
                            <div class="text-center blue-text-color">
                                <div class="priceItem sm:flex mb-10">
                                    <div class="title flex-1 sm:text-left text-center">1 {{ trans.get('teacher_profile.hour') }}</div>
                                    <div class="relative">
                                        <div class="value text-green-500 text-lg">
	                                        <currency
		                                        :value="teacher.one_hour_price/$root.fee"
	                                        />
                                             / {{ trans.get('teacher_profile.hour') }}
	                                    </div>
                                    </div>
                                </div>
                                <div class="priceItem sm:flex mb-10">
                                    <div class="title flex-1 sm:text-left text-center">5 {{ trans.get('teacher_profile.hour') }}</div>
                                    <div class="relative">
                                        <div class="value text-green-500 text-lg">
	                                        <currency
		                                        :value="(teacher.five_hour_price / 5)/$root.fee"
	                                        />
                                             / {{ trans.get('teacher_profile.hour') }}
	                                   </div>
                                    </div>
                                </div>
                                <div class="priceItem sm:flex mb-10">
                                    <div class="title flex-1 sm:text-left text-center">10 {{ trans.get('teacher_profile.hour') }}</div>
                                    <div class="relative">
                                        <div class="value text-green-500 text-lg">
	                                        <currency
		                                        :value="(teacher.ten_hour_price / 10) / $root.fee"
	                                        />
                                             / {{ trans.get('teacher_profile.hour') }}
	                                    </div>
                                    </div>
                                </div>
	                            <div class="priceItem sm:flex mb-10">
		                            <div class="title flex-1 sm:text-left text-center">20 {{ trans.get('teacher_profile.hour') }}</div>
		                            <div class="relative">
			                            <div class="value text-green-500 text-lg">
				                            <currency
					                            :value="(teacher.twenty_hour_price / 20) / $root.fee"
				                            />
				                            / {{ trans.get('teacher_profile.hour') }}
			                            </div>
		                            </div>
	                            </div>
                            </div>
                            <div class="actions flex flex-col items-end">
                                <c-btn
                                    class="mb-4"
                                    @click="clickedBuyBtn"
                                    icon="account_balance_wallet"
                                >{{ trans.get('teacher_profile.buy_btn') }}</c-btn>

                                <!-- <c-btn
                                    outlined
                                    icon="chat"
                                >{{ trans.get('teacher_profile.message_btn') }}</c-btn> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <BookAppointment
	        :loading="appointmentPopup.loading"
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
    import getVideoId from 'get-video-id';
    
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
	            aboutMeMaxChar: 1000,
	            filterCalendarTime: {
		            start: '05:00:00',
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
				            value: '23:59:00'
			            }
		            ]
	            },
                languageList: null,
                locale: window.default_locale,
	            aboutMeOpened: false,
                appointmentPopup: {
                    open: false,
	                loading: false,
                    data: {
                        teacher_name: null,
                        date_start: null,
                        date_end: null,
                        eventClickInfo: null
                    }
                },
                calendarOptions: {
	                validRange: {
		                start: moment().format('YYYY-MM-DD'),
		                end: moment().add(2, 'month').format('YYYY-MM-DD')
	                },
	                dayHeaderContent: ({text}) => {
		                let texts = text.split(' ');
		                return `${texts[0]}\n${texts[1]}`;
	                },
                    plugins: [ timeGridPlugin, interactionPlugin ],
                    initialView: this.$root.calendarType,
                    locale: window.default_locale,
	                slotMinTime: '05:00:00',
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
            this.calendarOptions.timeZone = this.$page.props.user == null ? 'Europe/Budapest' : this.$page.props.user.timezone;

            let availabilities = [];

            Object.values(this.availabilities).forEach(availability => {
                let event = {
                	availability_id: availability.id,
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
	    mounted() {
        	let name = `${this.teacher.user.first_name} ${this.teacher.user.last_name[0]}.`;
		    let title = this.trans.get('teacher_profile.document_title', {name});
		    this.$root.documentTitle(title);
		
		    this.$root.initHashScroll();
	    },
	    computed: {
		    aboutMeText() {
		    	let text = null;
		    	let full = true;
		    	this.teacher.about_me.forEach(about_me => {
		    		if (about_me.locale === this.locale) {
		    		    return text = about_me.text;
			        }
			    });
		    	
		    	if (!this.aboutMeOpened && text && text.length > this.aboutMeMaxChar) {
		    		full = false;
				    text = text.substring(0, this.aboutMeMaxChar)+'...';
			    }
		    	
		    	return {
		    		value: text,
				    full: full
			    };
		    },
            videoUrl() {
                return 'https://www.youtube.com/embed/' + getVideoId(this.teacher.video_url).id;
            }
	    },
        methods: {
        	clickedFreeLessonBtn() {
		        let message = this.trans.get('teacher_profile.free_lesson_btn_notification');
		        this.$toast.info(message);
	        },
	        clickedBuyBtn() {
		        if (!this.$page.props.user) {
			        let message = this.trans.get('teacher_profile.no_auth_notification');
			        this.$toast.info(message);
			        this.$root.openRegistrationPopup();
			        
			        this.$root.registrationAddonData = {
				        teacher_id: this.teacher.id,
				        availability_id: null
			        };
			        
			        return;
		        }
		        
	            this.$inertia.visit('/checkout/'+this.teacher.id);
	        },
            submitAppointment() {
	            if (!this.$page.props.user) {
		            let message = this.trans.get('teacher_profile.no_auth_notification');
		            this.$toast.info(message);
		            this.$root.registrationAddonData = {
		                teacher_id: this.teacher.id,
			            availability_id: this.appointmentPopup.data.availability_id
		            };
		            this.$root.openRegistrationPopup();
	            }
	
	            if (this.$page.props.user.role !== 'student') {
		            return false;
	            }
             
	            this.appointmentPopup.loading = true;
	            
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

                    let message = this.trans.get('teacher_profile.submit_appointment_success_notification');
                    this.$toast.success(message);

                    setTimeout(() => {
                        this.appointmentPopup.data = {
                            teacher_name: null,
                            date_start: null,
                            date_end: null,
                            eventClickInfo: null
                        };
                    }, 500);
                    
	                this.appointmentPopup.loading = false;
                })
                .catch(error => {
	                this.appointmentPopup.loading = false;
	
	                if (error.response.status === 423) {
                         this.$inertia.visit('/checkout/' + this.teacher.id  + '?appointment=' + error.response.data);
                    } else {
	                    let message = this.trans.get('teacher_profile.submit_appointment_fail_notification');
                        this.$toast.error(message);
                    }
                });
            },
            addAppointment: function (eventClickInfo) {
                let self = this;

                // TODO Check user credit
                let hasCredit = true;

                if (!hasCredit) {
                	let message = this.trans.get('teacher_profile.no_credit_notification');
	                this.$toast.info(message);
                    this.$inertia.visit('/checkout/'+this.teacher.id);
                }
                
                this.appointmentPopup.data = {
                    teacher_name: this.teacher.user.first_name + ' ' + this.teacher.user.last_name[0]+'.',
                    date_start: eventClickInfo.event.startStr,
                    date_end: eventClickInfo.event.endStr,
	                availability_id: eventClickInfo.event.extendedProps.availability_id,
                    eventClickInfo
                };

                this.appointmentPopup.open = true;
            }
        }
    }
</script>