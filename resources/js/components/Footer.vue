<template>
    <div>
        <div class="bg-light mt-5">
            <div class="container py-4">
                <div class="row justify-content-between">
                    <div class="col-lg-4">
                        <router-link to="/">
                            <img
                                src="https://www.stmik-bandung.ac.id/core/public/assets/img/core-img/logo_stmik_kampusmerdeka.png"
                                class="img-fluid mb-3"
                            />
                        </router-link>
                        <h5 class="fw-bold">
                            Sekolah Tinggi Manajemen Informatika dan Komputer
                            Bandung
                        </h5>
                        <p>
                            Jl. Cikutra No. 113, Cikutra, Kec. Cibeunying Kidul,
                            Kota Bandung, Jawa Barat 40124
                        </p>
                    </div>
                    <div class="offset-lg-1 col-lg-2">
                        <h5 class="fw-bold">Informasi</h5>
                        <ul class="list-unstyled">
                            <li>
                                <router-link to="/about-us"
                                    >Tentang Kami</router-link
                                >
                            </li>
                            <li>
                                <router-link to="/privacy-policy"
                                    >Kebijakan Privasi</router-link
                                >
                            </li>
                            <li>
                                <router-link to="/terms-and-conditions"
                                    >Syarat & Ketentuan</router-link
                                >
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-2">
                        <h5 class="fw-bold">Hubungi Kami</h5>
                        <ul class="list-unstyled">
                            <li>
                                <a href="" @click.prevent>Kritik dan Saran</a>
                            </li>
                            <li>
                                <router-link to="/contact-us"
                                    >Hubungi Kami</router-link
                                >
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-2">
                        <h5 class="fw-bold">Temukan Kami</h5>
                        <ul class="list-unstyled">
                            <li>
                                <a
                                    href="https://instagram.com/bemstmikbandung?utm_medium=copy_link"
                                    ><i class="fab fa-instagram"></i>
                                    Instragram</a
                                >
                            </li>
                            <li>
                                <a
                                    href="https://youtube.com/channel/UCY2x0In8MhlIIXtBFKiZANQ"
                                    ><i class="fab fa-youtube"></i> YouTube</a
                                >
                            </li>
                        </ul>
                    </div>
                </div>
                <p class="small mt-4 mb-0">
                    <router-link to="/">STMIK Bandung</router-link> &copy;
                    {{ moment().format('YYYY') }} All Right Reserved.
                </p>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Footer'
}
</script>
