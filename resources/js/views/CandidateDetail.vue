<template>
    <div class="container">
        <vue-loading
            v-if="vue_loading"
            type="spiningDubbles"
            color="#0092ee"
            :size="{ width: '50px', height: '50px' }"
        ></vue-loading>
        <div class="row" v-else>
            <div class="col-lg-3">
                <div class="text-center">
                    <img
                        :src="
                            $base_url +
                            '/assets/img/candidates/' +
                            candidates.img
                        "
                        class="img-fluid rounded-3 shadow"
                        height="250px"
                        width="250px"
                    />
                </div>
                <div class="text-center my-3">
                    <button
                        type="button"
                        class="btn btn-warning btn-lg"
                        @click="vote($route.params.id)"
                    >
                        <i class="bi bi-check2-square"></i> Pilih
                    </button>
                    <!-- <button
                        v-if="userdata.userdata.is_admin"
                        type="button"
                        class="btn btn-light-dark"
                    >
                        <i class="fa fa-edit"></i> Diskualifikasi
                    </button> -->
                </div>
            </div>
            <div class="offset-lg-1 col-lg-8">
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <h4>Informasi Detail Kandidat</h4>
                        <div class="mb-3">
                            <h5 class="card-title">
                                {{ candidates.student.name }}
                            </h5>
                            <p class="mb-0">
                                - {{ candidates.student.student_number }}
                            </p>
                            <p class="mb-0">
                                - {{ candidates.student.study_program.name }}
                            </p>
                        </div>
                        <!-- Accordion -->
                        <div class="accordion mb-3" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button
                                        class="accordion-button"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#collapseOne"
                                        aria-expanded="true"
                                        aria-controls="collapseOne"
                                    >
                                        Visi & Misi
                                    </button>
                                </h2>
                                <div
                                    id="collapseOne"
                                    class="accordion-collapse collapse show"
                                    aria-labelledby="headingOne"
                                    data-bs-parent="#accordionExample"
                                >
                                    <div class="accordion-body">
                                        <div
                                            v-html="candidates.description"
                                        ></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Back button -->
                        <router-link to="/vote" class="btn btn-primary d-block"
                            ><i class="fa fa-chevron-left"></i>
                            Kembali</router-link
                        >
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
import { mapGetters } from 'vuex'

export default {
    name: 'CandidateDetail',
    metaInfo: {
        title: 'Informasi Detail Kandidat'
    },
    data() {
        return {
            candidates: {},
            vue_loading: true
        }
    },
    computed: {
        ...mapGetters({
            authenticated: 'authenticated',
            userdata: 'user'
        })
    },
    methods: {
        vote(id) {
            this.$swal
                .fire({
                    title: 'Apakah kamu yakin?',
                    text: 'Jika anda sudah memilih maka tidak akan bisa memilih kembali!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Pilih Dia!'
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        axios
                            .post('/api/v1/candidates/vote', {
                                candidates_id: this.$route.params.id
                            })
                            .then((response) => {
                                this.$swal.fire(
                                    'Terpilih!',
                                    'Terima kasih atas waktunya.',
                                    'success'
                                )
                            })
                            .catch((error) => {
                                // console.log(error.response.status)
                                if (error.response.status === 422) {
                                    this.$toast.open({
                                        type: 'error',
                                        message:
                                            error.response.data.results.errors
                                                .candidates_id[0]
                                    })
                                }
                                if (error.response.status === 403) {
                                    this.$swal.fire(
                                        'Oops!',
                                        error.response.data.status.message,
                                        'error'
                                    )
                                    // this.$toast.open({
                                    //   type: 'error',
                                    //   message: error.response.data.status.message
                                    // })
                                }
                            })
                    }
                })
        }
    },
    mounted() {
        axios
            .get('/api/v1/candidates/' + this.$route.params.id)
            .then((response) => {
                this.candidates = response.data.results.candidates
                this.vue_loading = false
                // console.log(this.candidates.student)
            })
            .catch((error) => {
                if (error.response.status === 404) {
                    this.$toast.open({
                        type: 'error',
                        message: error.response.data.status.message
                    })
                    this.$router.replace({ name: 'Vote' })
                }
            })
    }
}
</script>
