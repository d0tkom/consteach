<template>
    <div>
        <div class="bg-indigo-700 px-4 py-5 border-b rounded-t sm:px-6">
                  <h3 class="text-lg leading-6 font-medium text-white">
                    Teachers to validate
                  </h3>
                </div>
        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            <ul class="divide-y divide-gray-200">
                    <li v-for="teacher in teachers">
                      <a class="block hover:bg-gray-50">
                        <div class="px-4 py-4 sm:px-6">
                          <div class="flex items-center justify-between">
                            <p class="text-sm font-thin text-gray-700 truncate">
                            {{ teacher.user.first_name }} {{ teacher.user.last_name }}</br>
                            {{ teacher.user.email }}
                            </p>
                            <div class="ml-2 flex-shrink-0 flex">
                              <p class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                <button @click.prevent="validate(teacher)">Validate</button>
                              </p>
                            </div>
                          </div>
                        </div>
                      </a>
                    </li>
            </ul>
        </div>
    </div>
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
            all_teachers: Array,
        },
        data() {
            return {
                teachers: this.all_teachers
            };
        },
        methods: {
            validate: function (teacher) {
                var validatedTeacher = teacher;
                axios.post('/teachers/validate/' + teacher.id)
                    .then(response => {
                        this.teachers = this.teachers.filter(teacher => {
                            return teacher.id != validatedTeacher.id;
                        });
                        let message = this.trans.get('dashboard.submit_success_notification');
                        this.$toast.success(message);
                    })
                    .catch(error => {
                        let message = this.trans.get('dashboard.submit_fail_notification');
                        this.$toast.error(message);
                    });
            }
        }
    }
</script>

                <div class="bg-indigo-700 px-4 py-5 border-b rounded-t sm:px-6">
                  <h3 class="text-lg leading-6 font-medium text-white">
                    Teachers to validate
                  </h3>
                </div>
                <div class="bg-white shadow overflow-hidden sm:rounded-md">
                  <ul class="divide-y divide-gray-200">

                  </ul>

                </div>
