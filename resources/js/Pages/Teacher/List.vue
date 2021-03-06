<template>
    <app-layout>
        <div class="findTeacherContainer card lg flat pb-8">
            <div class="top mb-4">
                <div class="color-gray font-bold text-md mb-4">
                    Tanárok ebben a szűrésben ({{ total }})
                </div>
                <div class="flex items-center">
                    <div>
                        <c-btn
                            icon-right="keyboard_arrow_down"
                            outlined
                            class="mr-2"
                            @click="filters.order.active = true"
                        >
                            Rendezés: {{ filters.order.options[filters.order.value].label }}
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
	                        Nyelv
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
                            Ár
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
                            Időpont
                        </c-btn>
                        <find-teacher-day
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
                @mouse-enter="id => mouseEnter(id)"
                @mouse-leave="id => mouseLeave(id)"
                :active="activeTeacher === teacher.id"
            />
	        
            <div class="actions flex justify-center">
                <c-btn
                    v-if="moreExists"
                    @click="loadMoreTeacher"
                >Még több tanár</c-btn>
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
                next_page_url: this.all_teachers.next_page_url.replace('teachers', 'teachers/load-more'),
                filters: {
                    order: {
                        active: false,
                        value: 'one_hour_price',
                        options: {
                            one_hour_price: {
                                label: 'Ár'
                            },
                            appointment_count: {
                                label: 'Megtartott órák száma'
                            }
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
             'filters.time.value': function (){
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