<template>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm sticky-top mb-5">
        <div class="container">
            <router-link class="navbar-brand" to="/">
                <img src="https://www.stmik-bandung.ac.id/core/public/assets/img/core-img/logo-big.png" alt="" width="100" />
            </router-link>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <router-link class="nav-link" to="/" active-class="active fw-bold" exact>Beranda</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link v-if="authenticated" class="nav-link" to="/vote" active-class="active fw-bold">Vote</router-link>
                    </li>
                    <!-- <li class="nav-item">
                        <router-link class="nav-link" to="/quick-count" active-class="active fw-bold">Quick Count</router-link>
                    </li> -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"> Halaman </a>
                        <ul class="dropdown-menu border-0 shadow-sm p-2">
                            <li>
                                <router-link class="dropdown-item rounded-2" to="/about-us" active-class="active fw-bold">Tentang Kami</router-link>
                            </li>
                            <li>
                                <router-link class="dropdown-item rounded-2" to="/contact-us" active-class="active fw-bold">Hubungi Kami</router-link>
                            </li>
                        </ul>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item" v-if="!authenticated">
                        <router-link to="/login" class="btn btn-outline-light rounded-pill border-2 px-4" active-class="no-effect"><i class="bi bi-box-arrow-in-right"></i> Masuk</router-link>
                    </li>
                    <li class="nav-item dropdown" v-else>
                        <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <span v-if="userdata.student_id !== null">{{ userdata.personal_data.student_number }}</span>
                            <span v-if="userdata.teacher_id !== null">{{ userdata.personal_data.email }}</span>
                        </a>
                        <ul class="dropdown-menu border-0 shadow-sm w-auto p-2" style="width: 18rem">
                            <li>
                                <h6 class="dropdown-header pb-0">Halo,</h6>
                                <h6 class="dropdown-header fw-bold">
                                    {{ userdata.personal_data.name }}
                                </h6>
                            </li>
                            <li>
                                <hr class="dropdown-divider" />
                            </li>
                            <li>
                                <router-link v-if="userdata.userdata.is_admin" class="dropdown-item rounded-2" to="/control-panel"><i class="fa fa-server"></i> Control Panel</router-link>
                            </li>
                            <li>
                                <a class="dropdown-item rounded-2" href="" @click.prevent="logout()"><i class="fa fa-sign-out-alt"></i> Keluar</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
    name: 'Navbar',
    computed: {
        ...mapGetters({
            authenticated: 'authenticated',
            userdata: 'user'
        })
    },
    data() {
        return {
            current_url: window.location.href
        }
    },
    mounted() {
        // console.log(this.userdata.userdata)
    },
    methods: {
        logout() {
            this.$store
                .dispatch('logout')
                .then(() => {
                    this.$toast.open({
                        message: 'Logout Successfully.',
                        type: 'success'
                    })
                    this.$router.push({ name: 'Home' })
                })
                .catch(() => {
                    this.$toast.open({
                        type: 'error',
                        message: 'Logout Berhasil'
                    })
                })
        }
    }
}
</script>
