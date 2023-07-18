<template>
    <div class="container">
        <div class="row justify-content-between order-lg-first order-last">
            <div class="col-lg-4 align-self-center">
                <h1 class="display-1">404</h1>
                <h2>Halaman tidak ditemukan</h2>
                <p>
                    Maaf halaman tidak dapat ditemukan, kemungkinan halaman
                    sudah dihapus atau memang tidak ada.
                </p>
                <p>
                    <router-link to="/" class="btn btn-outline-primary"
                        ><i class="fa fa-chevron-left"></i> Kembali ke
                        Beranda</router-link
                    >
                </p>
            </div>
            <div class="col-lg-6">
                <img
                    :src="this.$base_url + '/assets/img/startled.svg'"
                    alt=""
                    class="img-fluid"
                />
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Error404',
    metaInfo: {
        title: 'Halaman Tidak Ditemukan'
    }
}
</script>
