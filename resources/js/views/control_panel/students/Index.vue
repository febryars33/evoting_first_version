<template>
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <Sidenav />
            </div>
            <div class="col-lg">
                <div class="row">
                    <div class="col-lg-4 align-self-center">
                        <h5 class="text-primary mb-4">
                            <i class="bi bi-mortarboard"></i> Data Mahasiswa
                        </h5>
                    </div>

                    <div class="offset-lg-3 col-lg-5">
                        <div class="mb-2">
                            <input
                                type="text"
                                class="form-control bg-transparent"
                                placeholder="Cari NIM / Nama"
                                v-model="search"
                                @input="searchStudents()"
                            />
                        </div>
                    </div>
                </div>

                <vue-loading
                    v-if="loading"
                    type="spiningDubbles"
                    color="#0092ee"
                    :size="{ width: '50px', height: '50px' }"
                ></vue-loading>

                <div class="table-responsive" v-else>
                    <table class="table table-hover table-striped align-middle">
                        <thead>
                            <tr>
                                <th>NIM</th>
                                <th>Nama</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in students.data" :key="item">
                                <td>{{ item.student_number }}</td>
                                <td>{{ item.name }}</td>
                                <td>
                                    <button
                                        type="submit"
                                        class="btn btn-light-danger"
                                        @click="
                                            deleteStudent(item.id, item.name)
                                        "
                                    >
                                        <i class="bi bi-trash"></i>
                                    </button>
                                    <router-link
                                        :to="
                                            '/control-panel/students/' +
                                            item.student_number
                                        "
                                        class="btn btn-light-primary"
                                        ><i class="bi bi-eye"></i
                                    ></router-link>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="row">
                    <div class="col-lg-5">
                        <span
                            >Halaman
                            {{ students.current_page }}
                            -
                            {{ students.last_page }}
                            dari
                            {{ students.total }}
                            data</span
                        >
                    </div>
                    <div class="col-lg">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-end">
                                <li
                                    v-for="item in students.links"
                                    :key="item"
                                    @click="getStudents(item.url)"
                                    v-bind:class="{
                                        active: item.active === true,
                                        disabled: item.url === null
                                    }"
                                    class="page-item"
                                >
                                    <button
                                        v-html="item.label"
                                        class="page-link"
                                    ></button>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
import Sidenav from '../../../components/Sidenav.vue'

export default {
    name: 'Students',
    metaInfo: {
        title: 'Data Semua Mahasiswa'
    },
    data() {
        return {
            students: {},
            search: '',
            pagination: null,
            loading: true
        }
    },
    components: {
        Sidenav
    },
    mounted() {
        this.getStudents()
    },
    methods: {
        getStudents(pagination) {
            pagination = pagination || '/api/v1/students?search=' + this.search
            axios
                .get(pagination)
                .then((response) => {
                    this.students = response.data.results
                    this.loading = false
                })
                .catch((error) => {
                    if (error.response.status === 429) {
                        this.$toast.open({
                            type: 'error',
                            message: 'Too Many Requests'
                        })
                    }
                })
        },
        searchStudents() {
            this.getStudents('/api/v1/students?search=' + this.search)
        },
        deleteStudent(id, name) {
            this.$swal
                .fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        axios
                            .delete('/api/v1/students/' + id)
                            .then((response) => {
                                this.$swal.fire(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    'success'
                                )
                                this.getStudents()
                            })
                            .catch((error) => {
                                this.$swal.fire(
                                    'Error!',
                                    'An error occurred. Code : ' +
                                        error.response.status,
                                    'error'
                                )
                            })
                    }
                })
        }
    }
}
</script>
