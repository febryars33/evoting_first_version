<template>
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <Sidenav />
            </div>
            <div class="col-lg">
                <h5 class="text-primary mb-4">
                    <i class="fa fa-user-cog"></i> Konfigurasi Pengguna
                </h5>
                <!-- Voting Expired Configuration -->
                <section id="voting_expired_section">
                    <form class="row g-3">
                        <div class="col-lg-12">
                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    value=""
                                    id="force_active_user"
                                />
                                <label
                                    class="form-check-label h6 fw-bold"
                                    for="force_active_user"
                                >
                                    Paksa Pengguna Aktif
                                </label>
                                <p class="small">
                                    Lorem ipsum dolor sit, amet consectetur
                                    adipisicing elit. Architecto iste asperiores
                                    voluptates quo hic laudantium. Blanditiis et
                                    maiores ut autem itaque nihil optio
                                    praesentium debitis ex, explicabo dolore
                                    ducimus? Architecto.
                                </p>
                                <button
                                    type="button"
                                    class="btn btn-outline-danger"
                                >
                                    Simpan
                                </button>
                            </div>
                        </div>
                        <!-- <div class="col-auto">
              <button
                type="submit"
                class="btn btn-light-danger"
              >Simpan</button>
            </div> -->
                    </form>
                </section>
            </div>
        </div>
    </div>
</template>

<script>
import Sidenav from '../../../components/Sidenav.vue'

export default {
    name: 'UserConfiguration',
    components: {
        Sidenav
    },
    metaInfo: {
        title: 'Konfigurasi User'
    }
}
</script>
