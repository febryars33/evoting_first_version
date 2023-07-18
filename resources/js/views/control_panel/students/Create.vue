<template>
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <Sidenav />
            </div>
            <div class="col-lg">
                <h5 class="text-primary mb-4">
                    <i class="bi bi-person-add"></i> Buat Data Mahasiswa
                </h5>
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <form
                            action=""
                            method="post"
                            @submit.prevent="formSubmit()"
                        >
                            <div class="row mb-3">
                                <div class="col-lg-4 align-self-center">
                                    <label for="student_number"
                                        >NIM (Nomor Induk Mahasiswa)</label
                                    >
                                </div>
                                <div class="col-lg">
                                    <input
                                        type="number"
                                        class="form-control"
                                        id="student_number"
                                        placeholder="322****"
                                        v-model="forms.student_number"
                                    />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-4 align-self-center">
                                    <label for="student_name"
                                        >Nama Lengkap</label
                                    >
                                </div>
                                <div class="col-lg">
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="student_name"
                                        placeholder="Nama"
                                        v-model="forms.name"
                                    />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-4 align-self-center">
                                    <label for="place_birth"
                                        >Tempat Lahir</label
                                    >
                                </div>
                                <div class="col-lg">
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="place_birth"
                                        placeholder="Bandung"
                                        v-model="forms.place_birth"
                                    />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-4 align-self-center">
                                    <label for="date_birth"
                                        >Tanggal Lahir</label
                                    >
                                </div>
                                <div class="col-lg">
                                    <input
                                        type="date"
                                        class="form-control"
                                        id="date_birth"
                                        v-model="forms.date_birth"
                                    />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-4 align-self-center">
                                    <label for="study_program"
                                        >Program Studi</label
                                    >
                                </div>
                                <div class="col-lg">
                                    <select
                                        class="form-control"
                                        id="study_program"
                                        v-model="forms.study_program_id"
                                    >
                                        <option selected disabled>
                                            Pilih Program Studi
                                        </option>
                                        <option
                                            v-for="item in study_programs"
                                            :key="item"
                                            v-bind:value="item.id"
                                        >
                                            {{ item.name }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="offset-md-4 col-lg-8">
                                    <div class="d-grid">
                                        <button class="btn btn-light-primary">
                                            Simpan
                                        </button>
                                    </div>
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
import Sidenav from '../../../components/Sidenav.vue'

export default {
    name: 'StudentsCreat',
    metaInfo: {
        title: 'Buat Data Mahasiswa'
    },
    components: {
        Sidenav
    },
    data() {
        return {
            forms: {
                study_program_id: '',
                student_number: '',
                name: '',
                place_birth: '',
                date_birth: ''
            },
            study_programs: {},
            errors: {}
        }
    },
    mounted() {
        this.getStudyPrograms()
    },
    methods: {
        getStudyPrograms() {
            axios
                .get('/api/v1/study-programs')
                .then((response) => {
                    this.study_programs = response.data.results
                })
                .catch((error) => {
                    console.log(error.response.data)
                })
        },
        formSubmit() {
            axios
                .post('/api/v1/students', this.forms)
                .then((response) => {
                    this.forms.student_number = ''
                    this.forms.name = ''
                    this.forms.place_birth = ''
                    this.forms.date_birth = ''
                    this.forms.study_program_id = ''
                    this.forms.errors = {}
                    this.$toast.open({
                        type: 'success',
                        message: 'Data berhasil ditambahkan.'
                    })
                })
                .catch((error) => {
                    this.errors = error.response.data.results.errors
                    switch (error.response.status) {
                        case 422:
                            if (this.errors.student_number) {
                                this.$toast.open({
                                    type: 'error',
                                    message: this.errors.student_number[0]
                                })
                            } else if (this.errors.name) {
                                this.$toast.open({
                                    type: 'error',
                                    message: this.errors.name[0]
                                })
                            } else if (this.errors.place_birth) {
                                this.$toast.open({
                                    type: 'error',
                                    message: this.errors.place_birth[0]
                                })
                            } else if (this.errors.date_birth) {
                                this.$toast.open({
                                    type: 'error',
                                    message: this.errors.date_birth[0]
                                })
                            } else if (this.errors.study_program_id) {
                                this.$toast.open({
                                    type: 'error',
                                    message: this.errors.study_program_id[0]
                                })
                            }
                            break
                    }
                })
        }
    }
}
</script>
