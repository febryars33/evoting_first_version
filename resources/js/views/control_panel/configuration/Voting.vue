<template>
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <Sidenav />
            </div>
            <div class="col-lg">
                <h5 class="text-primary mb-4">
                    <i class="fa fa-cogs"></i> Konfigurasi Voting
                </h5>
                <!-- Voting Expired Configuration -->
                <section id="voting_expired_section">
                    <label for="voting_expired" class="h6 fw-bold"
                        >Batas Waktu Voting</label
                    >
                    <p class="small">
                        Jika voting melewati batas waktu voting, maka user yang
                        melakukan voting akan ditolak.
                    </p>
                    <form class="row g-3">
                        <div class="col-lg-4">
                            <input
                                type="datetime-local"
                                class="form-control bg-transparent"
                                id="voting_expired"
                                v-model="config.expire_at"
                            />
                        </div>
                        <div class="col-auto">
                            <button
                                type="button"
                                class="btn btn-light-danger"
                                @click="expiredConfigurations()"
                            >
                                Simpan
                            </button>
                        </div>
                    </form>
                    <hr />
                </section>
                <!-- Voting Score for Student Configuration -->
                <section id="voting_student_score_section">
                    <label for="voting_student_score" class="h6 fw-bold"
                        >Score untuk Mahasiswa</label
                    >
                    <p class="small">
                        Silahkan set skor suara untuk per masing - masing
                        mahasiswa.
                    </p>
                    <form class="row g-3">
                        <div class="col-lg-4">
                            <input
                                type="number"
                                class="form-control bg-transparent"
                                id="voting_student_score"
                                value="1"
                                v-model="config.scores.student"
                            />
                        </div>
                        <div class="col-auto">
                            <button
                                type="button"
                                class="btn btn-light-danger"
                                @click="studentScoreConfigurations()"
                            >
                                Simpan
                            </button>
                        </div>
                    </form>
                    <hr />
                </section>
                <!-- Voting Score for teacher Configuration -->
                <section id="voting_teacher_score_section">
                    <label for="voting_teacher_score" class="h6 fw-bold"
                        >Score untuk Dosen</label
                    >
                    <p class="small">
                        Silahkan set skor suara untuk per masing - masing dosen.
                    </p>
                    <form class="row g-3">
                        <div class="col-lg-4">
                            <input
                                type="number"
                                class="form-control bg-transparent"
                                id="voting_teacher_score"
                                value="1"
                                v-model="config.scores.teacher"
                            />
                        </div>
                        <div class="col-auto">
                            <button
                                type="button"
                                class="btn btn-light-danger"
                                @click="teacherScoreConfigurations()"
                            >
                                Simpan
                            </button>
                        </div>
                    </form>
                    <hr />
                </section>
                <!-- Logo Configuration -->
                <section id="logo_section">
                    <label for="logo" class="h6 fw-bold"
                        >Logo Sekolah / Universitas</label
                    >
                    <p class="small">Logo Sekolah / Universitas</p>
                    <form class="row g-3">
                        <div class="col-lg-4">
                            <input
                                type="file"
                                class="form-control bg-transparent"
                                id="logo"
                                value="1"
                            />
                        </div>
                        <div class="col-auto">
                            <button
                                type="button"
                                class="btn btn-light-primary mb-3"
                            >
                                Simpan
                            </button>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
import Sidenav from '../../../components/Sidenav.vue'
import moment from 'moment'

export default {
    name: 'VotingConfiguration',
    components: {
        Sidenav
    },
    metaInfo: {
        title: 'Konfigurasi Voting'
    },
    data() {
        return {
            config: {
                scores: {
                    teacher: null,
                    previous_teacher: null,
                    student: null,
                    previous_student: null
                },
                expire_at: null
            }
        }
    },
    mounted() {
        this.getConfigurations()
    },
    methods: {
        getConfigurations() {
            axios
                .get('/api/v1/configurations')
                .then((response) => {
                    this.config.scores.teacher =
                        response.data.results.teacher_score

                    this.config.scores.previous_teacher =
                        response.data.results.teacher_score

                    this.config.scores.student =
                        response.data.results.student_score

                    this.config.expire_at = moment(
                        response.data.results.voting_expired
                    ).format('YYYY-MM-DDTHH:mm')
                })
                .catch((error) => {
                    // console.log(error.response.header)
                })
        },

        teacherScoreConfigurations() {
            if (
                this.config.scores.previous_teacher !==
                this.config.scores.teacher
            ) {
                axios
                    .post('/api/v1/configurations/teachers/score', {
                        score: this.config.scores.teacher
                    })
                    .then((response) => {
                        this.$toast.open({
                            type: 'success',
                            message: response.data.results.message
                        })
                        this.getConfigurations()
                    })
                    .catch((error) => {
                        if (error.response.status === 422) {
                            this.$toast.open({
                                type: 'error',
                                message:
                                    error.response.data.results.errors.score[0]
                            })
                        }
                    })
            }
        },

        studentScoreConfigurations() {
            if (
                this.config.scores.previous_student !==
                this.config.scores.student
            ) {
                axios
                    .post('/api/v1/configurations/students/score', {
                        score: this.config.scores.student
                    })
                    .then((response) => {
                        this.$toast.open({
                            type: 'success',
                            message: response.data.results.message
                        })
                        this.getConfigurations()
                    })
                    .catch((error) => {
                        if (error.response.status === 422) {
                            this.$toast.open({
                                type: 'error',
                                message:
                                    error.response.data.results.errors.score[0]
                            })
                        }
                    })
            }
        },

        expiredConfigurations() {
            axios
                .post('/api/v1/configurations/expired-at', {
                    date: moment(this.config.expire_at).format(
                        'YYYY-MM-DD HH:mm:ss'
                    )
                })
                .then((response) => {
                    this.$toast.open({
                        type: 'success',
                        message: response.data.results.message
                    })
                    this.getConfigurations()
                })
                .catch((error) => {
                    console.log(error.response.data)
                })
        }
    }
}
</script>
