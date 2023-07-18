<template>
    <div class="col-lg-7 mx-auto">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <router-link to="/">Beranda</router-link>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Tentang Kami
                    </li>
                </ol>
            </nav>
            <div class="card border-0 shadow rounded-4">
                <div class="card-body p-4">
                    <h2 class="fw-bold text-primary">
                        Tentang BEM STMIK Bandung
                    </h2>
                    <p>
                        BEM atau Badan Eksekutif Mahasiswa merupakan organisasi
                        yang kegiatannya sangat direkomendasikan untuk diikuti
                        oleh mahasiswa. Sesuai dengan namannya, Badan Eksekutif
                        Mahasiswa sebagai Organisasi mahasiswa intra kampus yang
                        merupakan lembaga eksekutif tingkat universtas dan
                        institut
                    </p>

                    <h2 class="fw-bold text-primary">Visi dan Misi</h2>
                    <h5 class="fw-bold text-primary">VISI</h5>
                    <p>
                        Menjadi Badan Eksekutif Mahasiswa (BEM) STMIK BANDUNG
                        sebagai potensi unggulan STMIK BANDUNG, serta
                        menciptakan rasa kekeluargaan antar anggota Badan
                        Eksekutif Mahasiswa (BEM) STMIK BANDUNG dan seluruh
                        civitas STMIK BANDUNG.
                    </p>
                    <h5 class="fw-bold text-primary">MISI</h5>
                    <ol>
                        <li class="mb-1">
                            Mengayomi dan menyampaikan aspirasi mahasiswa/I
                            serta menjembatani atau menghubungkan idealisme
                            mahasiswa dengan yayasan.
                        </li>
                        <li class="mb-1">
                            Mengoptimalkan organisasi mahasiswa STMIK BANDUNG.
                        </li>
                        <li class="mb-1">
                            Mewadahi minat dan bakat mahasiswa STMIK BANDUNG.
                        </li>
                        <li class="mb-1">
                            Menjadikan Badan Eksekutif Mahasiswa (BEM) STMIK
                            BANDUNG sebagai organisasi mahasiswa yang
                            bersosialisasi dengan baik di internal maupun
                            eksternal STMIK BANDUNG.
                        </li>
                        <li>
                            Menciptakan dan menjaga lingkungan organisasi yang
                            professional, bekerja, sinergis, aspiratif, dan
                            menjunjung tinggi musyawarah mufakat.
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'AboutUs',
    metaInfo: {
        title: 'Tentang Kami'
    }
}
</script>
