<template>
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <router-link to="/">Beranda</router-link>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Hubungi Kami</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-lg-6 align-self-center">
                <div class="card border-0 shadow rounded-4">
                    <div class="card-body">
                        <h3 class="fw-bold text-primary">Hubungi Kami</h3>
                        <p>Jika ada kendala pada aplikasi harap hubungi Panitia melalui</p>
                        <div class="d-grid mt-3">
                            <button type="button" class="btn btn-success rounded-3" @click="openWhatsApp()"><i class="bi bi-whatsapp"></i> WhatsApp</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 d-none d-lg-block">
                <img :src="this.$base_url + '/assets/img/call-center-animate.svg'" alt="Hubungi" class="img-fluid" />
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'ContactUs',
    metaInfo: {
        title: 'Hubungi Kami'
    },
    methods: {
        openWhatsApp() {
            window.open('https://api.whatsapp.com/send?phone=6282319919169')
        }
    }
}
</script>
