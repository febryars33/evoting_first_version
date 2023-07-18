<template>
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-4 mx-auto">
                <div class="card shadow rounded-4">
                    <div class="card-body">
                        <form method="post" @submit.prevent="loginSubmit">
                            <template v-if="options.is_teacher_login === false">
                                <div class="mb-3">
                                    <label
                                        class="form-label"
                                        for="student_number"
                                        >NIM (Nomor Induk Mahasiswa)</label
                                    >
                                    <input
                                        type="number"
                                        class="form-control"
                                        placeholder="322****"
                                        id="student_number"
                                        min="1"
                                        v-model="forms.data.student_number"
                                    />
                                </div>
                            </template>
                            <template v-else>
                                <div class="mb-3">
                                    <label class="form-label" for="email"
                                        >Email</label
                                    >
                                    <input
                                        type="email"
                                        class="form-control"
                                        placeholder="example@stmik.ac.id"
                                        id="email"
                                        v-model="forms.data.email"
                                    />
                                </div>
                            </template>
                            <label for="password">Password</label>
                            <div class="input-group mb-3">
                                <input
                                    :type="options.password_type"
                                    v-model="forms.data.password"
                                    class="form-control"
                                    :placeholder="options.password_placeholder"
                                    id="password"
                                />
                                <button
                                    class="btn btn-outline-primary"
                                    type="button"
                                    @click="showPassword"
                                    v-html="options.eye_icon"
                                ></button>
                            </div>
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        role="switch"
                                        id="login_type_switch"
                                        v-model="options.is_teacher_login"
                                    />
                                    <label
                                        class="form-check-label"
                                        for="login_type_switch"
                                        >Login sebagai Mahasiswa / Dosen</label
                                    >
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="d-grid">
                                    <button
                                        type="submit"
                                        class="btn btn-primary"
                                        :disabled="options.btn_spinner"
                                    >
                                        <span
                                            v-if="options.btn_spinner === true"
                                            class="spinner-border spinner-border-sm"
                                            role="status"
                                        ></span>
                                        <span
                                            v-if="options.btn_spinner === true"
                                            >Loading...</span
                                        ><span v-else>Login</span>
                                    </button>
                                </div>
                            </div>
                            <p class="mb-0">
                                Lupa Password ?
                                <a
                                    data-bs-toggle="collapse"
                                    href="#forgotPasswordCollapse"
                                    role="button"
                                >
                                    Klik Disini
                                </a>
                            </p>
                            <div class="collapse" id="forgotPasswordCollapse">
                                <div class="card card-body mt-2">
                                    Silahkan hubungi panitia terkait untuk
                                    meminta request penggantian password.
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
import { mapActions } from 'vuex'

export default {
    name: 'Login',
    metaInfo: {
        title: 'Masuk'
    },
    data() {
        return {
            options: {
                is_teacher_login: false,
                btn_spinner: false,
                password_type: 'password',
                password_placeholder: '******',
                eye_icon: '<i class="bi bi-eye"></i>'
            },
            forms: {
                data: {
                    student_number: null,
                    device_name: 'browser',
                    email: null,
                    password: null,
                    login_type: 'STUDENT'
                }
            }
        }
    },
    methods: {
        ...mapActions({
            signIn: 'auth/signIn'
        }),

        showPassword() {
            if (this.options.password_type === 'password') {
                this.options.password_type = 'text'
                this.options.eye_icon = '<i class="bi bi-eye-slash"></i>'
                this.options.password_placeholder = 'Password'
            } else {
                this.options.password_type = 'password'
                this.options.eye_icon = '<i class="bi bi-eye"></i>'
                this.options.password_placeholder = '******'
            }
        },

        loginSubmit() {
            if (this.options.is_teacher_login === false) {
                this.forms.data.login_type = 'STUDENT'
                this.forms.data.email = null
                this.loginAsStudent()
            } else {
                this.forms.data.login_type = 'TEACHER'
                this.forms.data.student_number = null
                this.loginAsTeacher()
            }
        },

        async loginAsStudent() {
            if (
                this.forms.data.student_number === null ||
                this.forms.data.student_number === ''
            ) {
                this.$toast.open({
                    type: 'error',
                    message: 'Form NIM wajib diisi.'
                })
            } else if (
                this.forms.data.password === null ||
                this.forms.data.password === ''
            ) {
                this.$toast.open({
                    type: 'error',
                    message: 'Form Password wajib diisi.'
                })
            } else {
                this.options.btn_spinner = true
                this.$store
                    .dispatch('login', this.forms.data)
                    .then((response) => {
                        this.$router.replace({ name: 'Home' })
                        this.$toast.open({
                            type: 'success',
                            message: 'Selamat Datang :)'
                        })
                    })
                    .catch((error) => {
                        this.options.btn_spinner = false
                        // console.log(error.response)
                        this.$toast.open({
                            type: 'error',
                            message: error.response.data.status.message
                        })
                    })
            }
        },

        async loginAsTeacher() {
            if (
                this.forms.data.email === null ||
                this.forms.data.email === ''
            ) {
                this.$toast.open({
                    type: 'error',
                    message: 'Form Email wajib diisi.'
                })
            } else if (
                this.forms.data.password === null ||
                this.forms.data.password === ''
            ) {
                this.$toast.open({
                    type: 'error',
                    message: 'Form Password wajib diisi.'
                })
            } else {
                this.options.btn_spinner = true
                this.$store
                    .dispatch('login', this.forms.data)
                    .then((response) => {
                        this.$router.replace({ name: 'Home' })
                        this.$toast.open({
                            type: 'success',
                            message: 'Selamat Datang :)'
                        })
                    })
                    .catch((error) => {
                        this.options.btn_spinner = false
                        if (error.response.status === 502) {
                            this.$toast.open({
                                type: 'error',
                                message: 'Error'
                            })
                        }
                        this.$toast.open({
                            type: 'error',
                            message: error.response.data.status.message
                        })
                    })
            }
        }
    }
}
</script>
