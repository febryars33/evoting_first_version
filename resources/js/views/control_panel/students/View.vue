<template>
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <Sidenav />
            </div>
            <div class="col-lg" v-if="student !== null">
                <h5 class="text-primary mb-4">
                    <i class="bi bi-mortarboard"></i> Detail Data Mahasiswa
                </h5>
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th>NIM</th>
                                <td>{{ student.student_number }}</td>
                            </tr>
                            <tr>
                                <th>Nama</th>
                                <td>{{ student.name }}</td>
                            </tr>
                            <tr>
                                <th>Tempat Lahir</th>
                                <td>{{ student.place_birth }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Lahir</th>
                                <td>
                                    {{
                                        moment(student.date_birth).format(
                                            'dddd, DD MMMM YYYY'
                                        )
                                    }}
                                </td>
                            </tr>
                            <tr>
                                <th>Program Studi</th>
                                <td>{{ study_program.name }}</td>
                            </tr>
                        </thead>
                    </table>
                </div>
                <h5 class="text-primary mb-4">
                    <i class="bi bi-mortarboard"></i> Detail Akun
                </h5>
                <div class="table-responsive">
                    <table class="table table-borderless" v-if="user !== null">
                        <thead>
                            <tr>
                                <th>Tipe</th>
                                <td>
                                    <span
                                        class="badge bg-danger"
                                        v-if="user.is_admin === true"
                                        >Administrator</span
                                    >
                                    <span class="badge bg-primary" v-else
                                        >User</span
                                    >
                                </td>
                            </tr>
                            <tr>
                                <th>Aktivasi</th>
                                <td>
                                    <span
                                        class="badge bg-success"
                                        v-if="user.is_activated === true"
                                        >Aktif</span
                                    >
                                    <span class="badge bg-danger" v-else
                                        >Belum Aktif</span
                                    >
                                </td>
                            </tr>
                            <tr>
                                <th>Password Bawaan</th>
                                <td>
                                    <span
                                        class="badge bg-success"
                                        v-if="user.is_password_changed === true"
                                        >Sudah Diganti</span
                                    >
                                    <span class="badge bg-danger" v-else
                                        >Belum Diganti</span
                                    >
                                </td>
                            </tr>
                            <tr>
                                <th>Sudah Voting</th>
                                <td>
                                    <span
                                        class="badge bg-success"
                                        v-if="user.is_voted === true"
                                        >Sudah Voting</span
                                    >
                                    <span class="badge bg-danger" v-else
                                        >Belum Voting</span
                                    >
                                </td>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
import Sidenav from '../../../components/Sidenav.vue'

export default {
    name: 'StudentView',
    metaInfo: {
        title: 'Detail Mahasiswa'
    },
    data() {
        return {
            student_number: this.$route.params.student_number,
            student: null,
            study_program: {},
            user: null
        }
    },
    components: {
        Sidenav
    },
    methods: {
        getStudent() {
            axios
                .get('/api/v1/students/student-number/' + this.student_number)
                .then((response) => {
                    this.student = response.data.results.student
                    this.study_program = response.data.results.study_program
                    this.user = response.data.results.user
                })
                .catch((error) => {
                    //
                })
        }
    },
    mounted() {
        this.getStudent()
    }
}
</script>
