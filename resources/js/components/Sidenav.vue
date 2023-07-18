<template>
    <div class="border p-3 rounded mb-5">
        <ul class="nav flex-column">
            <li class="nav-item">
                <router-link class="btn btn-inverted-primary d-block text-start" aria-current="page" to="/control-panel" exact>Beranda Control Panel</router-link>
            </li>
        </ul>
        <hr class="bg-secondary" />
        <h6><i class="fa fa-user-check"></i> Kandidat</h6>
        <ul class="nav flex-column">
            <li class="nav-item">
                <router-link class="btn btn-inverted-secondary d-block text-start" aria-current="page" to="/control-panel/candidates" exact>Data Semua Kandidat</router-link>
            </li>
            <li class="nav-item">
                <router-link class="btn btn-inverted-secondary d-block text-start" aria-current="page" to="/control-panel/candidates/create">Buat Data Kandidat Baru</router-link>
            </li>
        </ul>
        <hr class="bg-secondary" />
        <h6><i class="fa fa-user-graduate"></i> Mahasiswa</h6>
        <ul class="nav flex-column">
            <li class="nav-item">
                <router-link class="btn btn-inverted-secondary d-block text-start" aria-current="page" to="/control-panel/students" exact>Data Semua Mahasiswa</router-link>
            </li>
            <li class="nav-item">
                <router-link class="btn btn-inverted-secondary d-block text-start" aria-current="page" to="/control-panel/students/create">Buat Data Mahasiswa Baru</router-link>
            </li>
        </ul>
        <hr class="bg-secondary" />
        <h6><i class="fa fa-user-tie"></i> Dosen</h6>
        <ul class="nav flex-column">
            <li class="nav-item">
                <router-link class="btn btn-inverted-secondary d-block text-start" aria-current="page" to="/control-panel/teachers">Data Semua Dosen</router-link>
            </li>
            <li class="nav-item">
                <router-link class="btn btn-inverted-secondary d-block text-start" aria-current="page" to="/control-panel/teachers/create">Buat Data Dosen Baru</router-link>
            </li>
        </ul>
        <hr class="bg-secondary" />
        <h6><i class="fa fa-cogs"></i> Konfigurasi</h6>
        <ul class="nav flex-column">
            <li class="nav-item">
                <router-link class="btn btn-inverted-secondary d-block text-start" aria-current="page" to="/control-panel/configurations/voting">Voting</router-link>
            </li>
            <li class="nav-item">
                <router-link class="btn btn-inverted-secondary d-block text-start" aria-current="page" to="/control-panel/configurations/user">User</router-link>
            </li>
            <li class="nav-item">
                <router-link class="btn btn-inverted-secondary d-block text-start" aria-current="page" to="/control-panel/configurations/terms-and-conditions">Syarat & Ketentuan</router-link>
            </li>
            <li class="nav-item">
                <router-link class="btn btn-inverted-secondary d-block text-start" aria-current="page" to="/control-panel/configurations/privacy-policy">Kebijakan Privasi</router-link>
            </li>
            <li class="nav-item">
                <router-link class="btn btn-inverted-secondary d-block text-start" aria-current="page" to="/control-panel/configurations/log">Log</router-link>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    name: 'Sidenav'
}
</script>
