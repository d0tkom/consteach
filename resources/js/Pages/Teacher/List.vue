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
                            @change="value => filters.order.value = value"
                            @change-active="active => filters.order.active = active"
                        />
                    </div>
                    <div>
                        <c-btn
                            icon-right="keyboard_arrow_down"
                            outlined
                            class="mr-2"
                            @click="filters.language.active = true"
                        >
	                        <flag
		                        class="flagImg rounded-full"
		                        :iso="filters.language.value === 'en' ? 'us' : filters.language.value"
	                        />
	                        {{ trans.get('find_teacher.language_filter_btn') }}
                        </c-btn>
                        <find-teacher-language
                            :languages="availableLanguages"
                            :languageList="languageList"
                            :locale="locale"
                            :value="filters.language.value"
                            :active="filters.language.active"
                            @change="value => filters.language.value = value"
                            @change-active="active => filters.language.active = active"
                        />
                    </div>
                
                    <div>
                        <c-btn
                            icon-right="keyboard_arrow_down"
                            outlined
                            class="mr-2"
                            @click="filters.price.active = true"
                        >
	                        {{ trans.get('find_teacher.price_filter_btn') }}
                        </c-btn>
                        <find-teacher-price
                            :value="filters.price.value"
                            :active="filters.price.active"
                            @change="value => filters.price.value = value"
                            @change-active="active => filters.price.active = active"
                        />
                    </div>
                    <div>
                        <c-btn
                            icon-right="keyboard_arrow_down"
                            outlined
                            class="mr-2"
                            @click="filters.time.active = true"
                        >
	                        {{ trans.get('find_teacher.time_filter_btn') }}
                        </c-btn>
                        <find-teacher-day
	                        @input="loadFilteredData(); filters.time.active = false"
                            :value="filters.time.value"
                            :active="filters.time.active"
                            @change-day="value => filters.time.value.day = value"
                            @change-time-of-day="value => filters.time.value.timeOfDay = value"
                            @change-active="active => filters.time.active = active"
                        />
                    </div>
                </div>
            </div>
            
            <find-teacher
                v-for="(teacher, t) in teachers"
                :key="t"
                :data="teacher"
                :trial-available="$page.props.user && $page.props.user.extra ? $page.props.user.extra.trial_available : true"
                @mouse-enter="id => mouseEnter(id)"
                @mouse-leave="id => mouseLeave(id)"
                :active="activeTeacher === teacher.id"
            />
	        
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
        },
        data() {
            return {
                activeTeacher: null,
                teachers: this.all_teachers.data,
                moreExists: this.all_teachers.current_page < this.all_teachers.last_page,
                languageList: null,
                total: this.all_teachers.total,
                locale: window.default_locale,
                next_page_url: this.all_teachers.next_page_url ? this.all_teachers.next_page_url.replace('teachers', 'teachers/load-more') : null,
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
                        value: {
                            timeOfDay: [],
                            day: []
                        },
                    },
                },
            };
        },
        created() {
            this.languageList = require('@cospired/i18n-iso-languages');
            this.languageList.registerLocale(require('@cospired/i18n-iso-languages/langs/en.json'));
            this.languageList.registerLocale(require('@cospired/i18n-iso-languages/langs/hu.json'));
            this.languageList.registerLocale(require('@cospired/i18n-iso-languages/langs/de.json'));
        },
        watch: {
            'filters.order.value': function (){
                 this.loadFilteredData();
             },
             'filters.language.value': function (){
                 this.loadFilteredData();
             },
             'filters.price.value': function (){
                 this.loadFilteredData();
             },
        },
        methods: {
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
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            }
        }
    }
</script>