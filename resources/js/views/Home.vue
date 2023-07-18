<template>
    <fragment>
        <div class="container">
            <div class="row justify-content-between align-items-center">
                <div class="col-lg-4 mb-5 mb-lg-0 order-lg-first order-last">
                    <h1 class="fw-bold text-primary">
                        Selamat Datang Di eVoting BEM STMIK Bandung
                    </h1>
                    <p>
                        Mulai voting dengan waktu singkat dengan aplikasi
                        eVoting BEM
                    </p>
                    <router-link
                        v-if="!authenticated"
                        to="/login"
                        class="btn btn-outline-primary rounded-pill px-5"
                        ><i class="bi bi-box-arrow-in-right"></i> Vote
                        Sekarang!</router-link
                    >
                    <router-link
                        v-if="authenticated"
                        to="/vote"
                        class="btn btn-outline-primary rounded-pill px-5"
                        ><i class="bi bi-box-arrow-in-right"></i> Vote
                        Sekarang!</router-link
                    >
                </div>
                <div class="col-lg-6">
                    <img
                        :src="this.$base_url + '/assets/img/voting-animate.svg'"
                        class="img-fluid"
                    />
                </div>
            </div>
        </div>

        <div class="bg-white py-5">
            <div class="container">
                <div class="row justify-content-between">
                    <div class="col-lg-4">
                        <h2 class="fw-bold text-primary">
                            Tentang BEM STMIK Bandung
                        </h2>
                        <p>
                            BEM atau Badan Eksekutif Mahasiswa merupakan
                            organisasi yang kegiatannya sangat direkomendasikan
                            untuk diikuti oleh mahasiswa. Sesuai dengan
                            namannya, Badan Eksekutif Mahasiswa sebagai
                            Organisasi mahasiswa intra kampus yang merupakan
                            lembaga eksekutif tingkat universtas dan institut
                        </p>
                        <img
                            src="https://www.stmik-bandung.ac.id/core/public/assets/img/core-img/logo-big.png"
                            class="img-fluid"
                        />
                    </div>
                    <div class="col-lg-8">
                        <h2 class="fw-bold text-primary">Visi Dan Misi</h2>
                        <div class="card bg-light rounded-4 shadow-sm">
                            <div class="card-body p-4">
                                <h5 class="fw-bold text-primary">VISI</h5>
                                <p>
                                    Menjadi Badan Eksekutif Mahasiswa (BEM)
                                    STMIK BANDUNG sebagai potensi unggulan STMIK
                                    BANDUNG, serta menciptakan rasa kekeluargaan
                                    antar anggota Badan Eksekutif Mahasiswa
                                    (BEM) STMIK BANDUNG dan seluruh civitas
                                    STMIK BANDUNG.
                                </p>
                                <h5 class="fw-bold text-primary">MISI</h5>
                                <ol>
                                    <li class="mb-1">
                                        Mengayomi dan menyampaikan aspirasi
                                        mahasiswa/I serta menjembatani atau
                                        menghubungkan idealisme mahasiswa dengan
                                        yayasan.
                                    </li>
                                    <li class="mb-1">
                                        Mengoptimalkan organisasi mahasiswa
                                        STMIK BANDUNG.
                                    </li>
                                    <li class="mb-1">
                                        Mewadahi minat dan bakat mahasiswa STMIK
                                        BANDUNG.
                                    </li>
                                    <li class="mb-1">
                                        Menjadikan Badan Eksekutif Mahasiswa
                                        (BEM) STMIK BANDUNG sebagai organisasi
                                        mahasiswa yang bersosialisasi dengan
                                        baik di internal maupun eksternal STMIK
                                        BANDUNG.
                                    </li>
                                    <li>
                                        Menciptakan dan menjaga lingkungan
                                        organisasi yang professional, bekerja,
                                        sinergis, aspiratif, dan menjunjung
                                        tinggi musyawarah mufakat.
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </fragment>
</template>

<script>
import Vue from 'vue'
import { mapGetters } from 'vuex'
import { Plugin } from 'vue-fragment'
Vue.use(Plugin)

export default {
    name: 'Home',
    metaInfo: {
        title: 'Beranda'
    },
    computed: {
        ...mapGetters({
            authenticated: 'authenticated',
            userdata: 'user'
        })
    }
}
</script>
