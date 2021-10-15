<template>
    <app-layout>
        <div class="findTeacherContainer card lg flat pb-8">
            <div class="top mb-4">
                <div class="color-gray font-bold text-md mb-4">
                    {{ trans.get('find_teacher.total_teacher') }} ({{ total }})
                </div>
                <div class="filters flex items-center">
                    <div>
                        <c-btn
                            icon-right="keyboard_arrow_down"
                            outlined
                            class="mr-2 first"
                            @click="filters.order.active = true"
                        >
                            {{ trans.get('find_teacher.order_btn') }}: {{ trans.get('find_teacher.option-'+filters.order.value) }}
                        </c-btn>
                        <find-teacher-order
                            :value="filters.order.value"
                            :active="filters.order.active"
                            :options="filters.order.options"
                            @change="orderFilterChanged"
                            @change-active="active => filters.order.active = active"
                        />
                    </div>
                    <div>
                        <c-btn
                            icon-right="keyboard_arrow_down"
                            :outlined="!urlParameters.language"
                            class="mr-2"
                            @click="filters.language.active = true"
                        >
	                        <flag
		                        class="flagImg rounded-full"
		                        :iso="$root.getCountryCode(filters.language.value)"
	                        />
	                        {{ trans.get('find_teacher.language_filter_btn') }}
                        </c-btn>
                        <find-teacher-language
                            :languages="availableLanguages"
                            :languageList="languageList"
                            :locale="locale"
                            :value="filters.language.value"
                            :active="filters.language.active"
                            @change="languageFilterChanged"
                            @change-active="active => filters.language.active = active"
                        />
                    </div>

                    <div>
                        <c-btn
                            icon-right="keyboard_arrow_down"
                            :outlined="!urlParameters.price"
                            class="mr-2"
                            @click="filters.price.active = true"
                        >
	                        {{ trans.get('find_teacher.price_filter_btn') }}
                        </c-btn>
                        <find-teacher-price
                            :value="filters.price.value"
                            :active="filters.price.active"
                            @change="priceFilterChanged"
                            @change-active="active => filters.price.active = active"
                        />
                    </div>
                    <div>
                        <c-btn
                            icon-right="keyboard_arrow_down"
                            :outlined="!urlParameters.time && !urlParameters.day"
                            class="mr-2"
                            @click="filters.time.active = true"
                        >
	                        {{ trans.get('find_teacher.time_filter_btn') }}
                        </c-btn>
                        <find-teacher-day
	                        @input="loadFilteredData(); filters.time.active = false"
                            :value="filters.time.value"
                            :active="filters.time.active"
                            @change-day="dayFilterChanged"
                            @change-time-of-day="timeFilterChanged"
                            @change-active="active => filters.time.active = active"
                        />
                    </div>
                </div>
            </div>

	        <div
		        @mouseenter="mouseEnter(teacher.id)"
		        @mouseleave="mouseLeave(teacher.id)"
		        v-for="(teacher, t) in teachers"
		        :key="t"
	        >
		        <find-teacher
			        :data="teacher"
			        :trial-available="$page.props.user && $page.props.user.extra ? $page.props.user.extra.trial_available : true"
			        :active="activeTeacher === teacher.id"
		        />
	        </div>
			<div
				v-if="firstLoaded && teachers.length === 0"
				class="flex items-center justify-center flex-col mt-28"
			>
				<span class="material-icons color-primary" style="font-size: 100px">search_off</span>
				<h2
					class="title text-xl my-4"
				>{{ trans.get('find_teacher.no_result_title') }}</h2>
				<c-btn
					@click="resetFilters()"
				>{{ trans.get('find_teacher.no_result_btn') }}</c-btn>
			</div>

            <div class="actions flex justify-center">
                <c-btn
                    v-if="moreExists"
                    @click="loadMoreTeacher"
                >{{ trans.get('find_teacher.more_teacher_btn') }}</c-btn>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import FindTeacher from "@/Widgets/FindTeacher";
    import FindTeacherOrder from "@/Popups/FindTeacherOrder";
    import FindTeacherLanguage from "@/Popups/FindTeacherLanguage";
    import FindTeacherPrice from "@/Popups/FindTeacherPrice";
    import FindTeacherDay from "@/Popups/FindTeacherDay";

    export default {
        components: {
            FindTeacherDay,
            FindTeacherPrice,
            FindTeacherLanguage,
            FindTeacherOrder,
            AppLayout,
            FindTeacher,
        },
        props: {
            all_teachers: Object,
            availableLanguages: Array,
            price: String,
            language: String,
            time: String,
            order: String,
            day: String,
        },
        data() {
            return {
                firstLoaded: false,
                activeTeacher: null,
                teachers: this.all_teachers.data,
                moreExists: this.all_teachers.current_page < this.all_teachers.last_page,
                languageList: null,
                total: this.all_teachers.total,
                locale: window.default_locale,
                next_page_url: this.all_teachers.next_page_url ? this.all_teachers.next_page_url.replace('teachers', 'teachers/filter') : null,
                filters: {
                    order: {
                        active: false,
                        value: 'random',
                        options: {
                            one_hour_price: {},
                            appointment_count: {},
	                        random: {}
                        }
                    },
                    language: {
                        active: false,
                        value: null,
                    },
                    price: {
                        active: false,
                        value: [0,15000],
                    },
                    time: {
                        active: false,
                        timeOfDays: [
                            {
                                start: '00:00',
                                end: '06:00'
                            }, {
                                start: '06:00',
                                end: '12:00'
                            }, {
                                start: '12:00',
                                end: '18:00'
                            }, {
                                start: '18:00',
                                end: '24:00'
                            }
                        ],
                        value: {
                            timeOfDay: [],
                            day: []
                        },
                    },
                },
            };
        },
        computed: {
            urlParameters() {
                let parameters = {};

                if (this.filters.language.value) {
                    parameters.language = this.filters.language.value;
                }

                if (this.filters.order.value && this.filters.order.value !== 'random') {
                    parameters.order = this.filters.order.value;
                }

                if (this.filters.price.value) {
                    if (this.filters.price.value[0] > 0 || this.filters.price.value[1] < 15000) {
                        parameters.price = this.filters.price.value.join('-');
                    }
                }

                if (this.filters.time.value.timeOfDay.length) {
                    let timeOfDays = [];
                    this.filters.time.timeOfDays.forEach((time, timeIndex) => {
                        this.filters.time.value.timeOfDay.forEach((timeSelected, timeIndexSelected) => {
                            if (time.start === timeSelected.start && time.end === timeSelected.end) {
                                timeOfDays.push(timeIndex);
                            }
                        });
                    });

                    parameters.time = timeOfDays.join('-');
                }

                if (this.filters.time.value.day.length) {
                    parameters.day = this.filters.time.value.day.join('-');
                }

                return parameters;
            }
        },
        created() {
            this.languageList = require('@cospired/i18n-iso-languages');
            this.languageList.registerLocale(require('@cospired/i18n-iso-languages/langs/en.json'));
            this.languageList.registerLocale(require('@cospired/i18n-iso-languages/langs/hu.json'));
            this.languageList.registerLocale(require('@cospired/i18n-iso-languages/langs/de.json'));
        },
	    mounted() {
		    let title = this.trans.get('find_teacher.document_title');
		    this.$root.documentTitle(title);

            if (this.language) {
                this.filters.language.value = this.language
            }

            if (this.order) {
                this.filters.order.value = this.order
            }

            if (this.price) {
                this.filters.price.value = this.price.split('-')
            }

            if (this.time || this.day) {
                if (this.time) {
                    const times = this.time.split('-');
                    times.forEach(time => {
                        this.filters.time.value.timeOfDay.push(this.filters.time.timeOfDays[time]);
                    });
                }

                if (this.day) {
                    this.filters.time.value.day = this.day.split('-')
                }
            }

            this.loadFilteredData();
	    },
        watch: {
        },
        methods: {
            dayFilterChanged(value) {
                this.filters.time.value.day = value

                this.$inertia.visit('/teachers', {
                    data: this.urlParameters
                });
            },
            timeFilterChanged(value) {
                this.filters.time.value.timeOfDay = value

                this.$inertia.visit('/teachers', {
                    data: this.urlParameters
                });
            },
            priceFilterChanged(value) {
                this.filters.price.value = value

                this.$inertia.visit('/teachers', {
                    data: this.urlParameters
                });
            },
            languageFilterChanged(value) {
                this.filters.language.value = value

                this.$inertia.visit('/teachers', {
                    data: this.urlParameters
                });
            },
            orderFilterChanged(value) {
                this.filters.order.value = value

                this.$inertia.visit('/teachers', {
                    data: this.urlParameters
                });
            },
			resetFilters() {
                this.filters.order.value = 'random';
                this.filters.language.value = null;
                this.filters.price.value = [0,15000];
                this.filters.time.value = {
                    timeOfDay: [],
                    day: []
                };
			},
            loadMoreTeacher() {
                let self = this;
                axios.get(self.next_page_url, {params: {
                    order_by: this.filters.order.value,
                    language: this.filters.language.value,
                    prices: this.filters.price.value,
                    time: this.filters.time.value
                }})
                .then(function (response) {
                    if (response.data.teachers.current_page < response.data.teachers.last_page) {
                        self.moreExists = true;
                    } else {
                        self.moreExists = false;
                    }
                    Object.values(response.data.teachers.data).forEach(teacher => self.teachers.push(teacher));
                    self.next_page_url = response.data.teachers.next_page_url;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            mouseEnter(id) {
                this.activeTeacher = id;
            },
            mouseLeave(id) {
                this.activeTeacher = null;
            },
            loadFilteredData() {
                let self = this;
                axios.get('/teachers/filter', {params: {
                    order_by: this.filters.order.value,
                    language: this.filters.language.value,
                    prices: this.filters.price.value,
                    time: this.filters.time.value
                }})
                .then(function (response) {
                    if (response.data.teachers.current_page < response.data.teachers.last_page) {
                        self.moreExists = true;
                    } else {
                        self.moreExists = false;
                    }
                    self.teachers = response.data.teachers.data;
                    self.next_page_url = response.data.teachers.next_page_url;
                    self.total = response.data.teachers.total;

                    self.firstLoaded = true;
                })
                .catch(function (error) {
                    console.log(error);
                });
            }
        }
    }
</script>
