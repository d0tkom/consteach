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
                        </div>
                        <div class="events">
                            <booked-event
                                v-for="(appointment, a) in appointments"
                                :key="a"
                                from-teacher
                                :data="appointment"
                                @destroy="$delete(appointments, a)"
                            />
                        </div>
                    </div>
                    <div class="col-span-2 card p-sm">
                        <FullCalendar :options="calendarOptions" />
	                    
	                    <div class="flex justify-between items-center mt-2">
		                    <div class="p-4">
			                    <div class="text-sm flex items-center">
				                    <div class="colorSample free mr-2"></div>
				                    <span>{{ trans.get('dashboard.bookable') }}</span>
			                    </div>
			                    <div class="text-sm flex items-center">
				                    <div class="colorSample booked mr-2"></div>
				                    <span>{{ trans.get('dashboard.booked') }}</span>
			                    </div>
		                    </div>
		                    
		                    <div class="flex items-center justify-end">
			                    <div class="mr-6">{{ trans.get('checkout.filter_calendar') }}</div>
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
	
	    <studentAppointment
	        v-model="appointmentPopup.open"
	        :data="appointmentPopup.data"
	        :time-zone="calendarOptions.timeZone"
	        @submit="deleteAppointment"
	    />
	    
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import BookedEvent from "@/Widgets/BookedEvent";
    import BoughtEvent from "@/Widgets/BoughtEvent";
    import FullCalendar from '@fullcalendar/vue';
    import timeGridPlugin from '@fullcalendar/timegrid';
    import interactionPlugin from '@fullcalendar/interaction';
    import StudentAppointment from "@/Popups/StudentAppointment";
    
    export default {
        components: {
	        StudentAppointment,
            BoughtEvent,
            AppLayout,
            BookedEvent,
            FullCalendar,
        },
        props: {
            lessons: Array,
            appointments: Array,
            availabilities: Array,
        },
        data() {
            return {
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
            	appointmentPopup: {
            		open: false,
		            data: {},
		            index: null
	            },
                languageList: null,
                locale: window.default_locale,
                calendarOptions: {
	                slotMinTime: '06:00:00',
	                slotMaxTime: '18:00:00',
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
	                height: 'auto',
                    events: [],
                    displayEventTime: false,
                    selectable: true,
                    selectOverlap: false,
                    select: this.addAvailability,
                    eventClick: this.checkEvent,
                    selectAllow: this.selectAllow,
                }
            };
        },
        created() {
            this.calendarOptions.timeZone = this.$page.props.user === null ? 'local' : this.$page.props.user.timezone;

            let self = this;

            let availabilities = [];

            Object.values(this.availabilities).forEach(availability => {
                let event = {
                	title: '',
                    start: moment.utc(availability.start).tz(this.calendarOptions.timeZone).format(),
                    end: moment.utc(availability.end).tz(this.calendarOptions.timeZone).format(),
                    booked: false,
                    student: false,
                    backgroundColor: '#18A0FB',
                    db_id: availability.id
                };
                availabilities.push(event);
            });

            let appointments = [];

            Object.values(this.appointments).forEach(appointment => {
                let event = {
	                title: appointment.student.user.first_name,
                    start: moment.utc(appointment.start).tz(self.calendarOptions.timeZone).format(),
                    end: moment.utc(appointment.end).tz(self.calendarOptions.timeZone).format(),
                    booked: true,
                    student: appointment.student,
                    backgroundColor: '#10bf1e',
                    db_id: appointment.id
                };
                appointments.push(event);
            });

            availabilities = availabilities.filter(a => !appointments.find(b => b.start === a.start && b.end === a.end));

            this.calendarOptions.events = [...appointments, ...availabilities];

            this.languageList = require('@cospired/i18n-iso-languages');
            this.languageList.registerLocale(require('@cospired/i18n-iso-languages/langs/en.json'));
            this.languageList.registerLocale(require('@cospired/i18n-iso-languages/langs/hu.json'));
            this.languageList.registerLocale(require('@cospired/i18n-iso-languages/langs/de.json'));
	
            let localStorage_calendarFilter = localStorage.getItem('calendarFilter');
            
            if (localStorage_calendarFilter) {
	            localStorage_calendarFilter = JSON.parse(localStorage_calendarFilter);
	            this.calendarOptions.slotMinTime = this.filterCalendarTime.start = localStorage_calendarFilter.start;
	            this.calendarOptions.slotMaxTime = this.filterCalendarTime.end = localStorage_calendarFilter.end;
            }
        },
	    watch: {
        	filterCalendarTime: {
		        handler(calendarTime) {
		        	let data = JSON.stringify({
				        start: calendarTime.start,
				        end: calendarTime.end
			        });
		        	
		        	localStorage.setItem('calendarFilter', data);
		        	
			        this.calendarOptions.slotMinTime = calendarTime.start;
			        this.calendarOptions.slotMaxTime = calendarTime.end;
		        }, deep: true
	        }
	    },
        methods: {
            selectAllow(selectInfo) {
                return this.$moment
                    .utc(selectInfo.startStr)
                    .tz(this.calendarOptions.timeZone)
                    .isSame(this.$moment
                        .utc(selectInfo.endStr)
                        .tz(this.calendarOptions.timeZone), 'date');
            },
            checkEvent(eventClickInfo) {
                if (eventClickInfo.event.extendedProps.booked === true) {
                	this.openAppointmentPopup(eventClickInfo);
                } else {
                    this.deleteAvailability(eventClickInfo);
                }
            },
	        openAppointmentPopup(eventClickInfo) {
		        let event = this.calendarOptions.events.find(event => event.db_id === eventClickInfo.event.extendedProps.db_id);
		        let index = this.calendarOptions.events.indexOf(event);
		
		        this.appointmentPopup.index = index;
		        this.appointmentPopup.data = this.calendarOptions.events[index];
		        this.appointmentPopup.open = true;
		        /*
		        if (index > -1) {
			        this.calendarOptions.events.splice(index, 1);
		        }
		*/
		        
		        /*
		        let availability = this.availabilities.find(availability =>
			        moment.utc(availability.start).tz(this.calendarOptions.timeZone).format() === eventClickInfo.event.startStr &&
			        moment.utc(availability.end).tz(this.calendarOptions.timeZone).format() === eventClickInfo.event.endStr
		        );
		
		        event = {
			        start: moment.utc(availability.start).tz(this.calendarOptions.timeZone).format(),
			        end: moment.utc(availability.end).tz(this.calendarOptions.timeZone).format(),
			        booked: false,
			        student: false,
			        backgroundColor: 'blue',
			        db_id: availability.id
		        };
          */
		        
		       
	        },
            addAvailability(selectionInfo) {
                let slotArray = Array.from(moment.range(selectionInfo.startStr, selectionInfo.endStr).by('minutes', { step: 60 }));

                slotArray.pop();

                slotArray = slotArray.map(m => ({
                    'startStr': m.tz(this.calendarOptions.timeZone, true).format(),
                    'endStr': m.tz(this.calendarOptions.timeZone, true).add(60, 'm').format()
                }));

                slotArray.forEach(slot => {
                    axios.put('/availability', {params: {
                        start: slot.startStr,
                        end: slot.endStr
                    }})
                    .then(response => {
                        let event = {
                        	title: '',
                            start: moment.utc(response.data.start).tz(this.calendarOptions.timeZone).format(),
                            end: moment.utc(response.data.end).tz(this.calendarOptions.timeZone).format(),
                            booked: false,
                            student: false,
	                        backgroundColor: '#18A0FB',
                            db_id: response.data.id
                        };
	                    this.calendarOptions.events.push(event);
	
	                    this.$toast.success('Foglalható időpont hozzáadva');
                    })
                    .catch(error => {
                        console.error(error);
	                    this.$toast.success('Foglalható időpont hozzáadása sikertelen');
                    });
                });
            },
            deleteAvailability(eventClickInfo) {
                axios.delete('/availability/' + eventClickInfo.event.extendedProps.db_id)
                .then(response => {
                    let event = this.calendarOptions.events.find(x => x.db_id === eventClickInfo.event.extendedProps.db_id);
                    let index = this.calendarOptions.events.indexOf(event);
                    if (index > -1) {
                        this.calendarOptions.events.splice(index, 1);
                    }
	
	                this.$toast.success('Foglalható időpont törölve');
                })
                .catch(error => {
                    console.error(error);
	                this.$toast.error('Foglalható időpont törlése sikertelen');
                });
            },
            deleteAppointment() {
                axios.delete('/appointment/' + this.appointmentPopup.data.db_id)
                .then(response => {
                	this.appointmentPopup.open = false;
	                this.$delete(this.calendarOptions.events, this.appointmentPopup.index);
					
	                this.$toast.success('Foglalás törölve');
                })
                .catch(error => {
                    console.error(error);
	                this.$toast.error('Foglalás törlése sikertelen');
                });
            }
        }
    }
</script>