<template>
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <Sidenav />
            </div>
            <div class="col-lg">
                <h5 class="text-primary mb-4">
                    <i class="bi bi-person-add"></i> Buat Kandidat Baru
                </h5>
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="row">
                                <label for="search_student_number"
                                    >Cari NIM (Nomor Induk Mahasiswa) /
                                    Nama</label
                                >
                                <form
                                    class="row"
                                    action=""
                                    method="post"
                                    @submit.prevent="searchStudents"
                                >
                                    <div class="col-8 col-lg-6">
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="search_student_number"
                                            placeholder="NIM / Nama"
                                            v-model="search"
                                        />
                                    </div>
                                    <div class="col-3 col-lg">
                                        <button
                                            type="submit"
                                            class="btn btn-primary"
                                        >
                                            <i class="bi bi-search"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card card-body mb-4">
                            <h5 class="card-title">Data Mahasiswa</h5>
                            <!-- before -->
                            <div
                                class="table-responsive"
                                v-if="selected.student_id === null"
                            >
                                <table
                                    class="table table-hover table-bordered align-middle"
                                >
                                    <thead>
                                        <tr>
                                            <th>NIM</th>
                                            <th>Nama</th>
                                            <th>Program Studi</th>
                                            <th>#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="(item, index) in students"
                                            :key="index"
                                        >
                                            <td>{{ item.student_number }}</td>
                                            <td>{{ item.name }}</td>
                                            <td>
                                                {{ item.study_program_name }}
                                            </td>
                                            <td>
                                                <button
                                                    type="button"
                                                    class="btn btn-light-success"
                                                    @click="
                                                        selectedStudent(
                                                            item.id,
                                                            item.student_number,
                                                            item.name,
                                                            item.study_program_name,
                                                            item.study_program_id
                                                        )
                                                    "
                                                >
                                                    <i
                                                        class="bi bi-check-lg"
                                                    ></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div v-else class="table-responsive">
                                <table
                                    class="table table-hover table-bordered align-middle"
                                >
                                    <thead>
                                        <tr>
                                            <th>NIM</th>
                                            <th>Nama</th>
                                            <th>Program Studi</th>
                                            <th>#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                {{ selected.student_number }}
                                            </td>
                                            <td>{{ selected.name }}</td>
                                            <td>
                                                {{ selected.study_program }}
                                            </td>
                                            <td>
                                                <button
                                                    type="button"
                                                    class="btn btn-light-danger"
                                                    @click="removeSelected"
                                                >
                                                    <i class="bi bi-x-lg"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card card-body mb-4">
                            <div class="mb-3">
                                <h5 class="card-title">
                                    Isi Informasi Kandidat
                                </h5>
                                <label for="vision_and_missions"
                                    >Visi & Misi</label
                                >
                                <editor
                                    api-key="no-api-key"
                                    v-model="forms.description"
                                    :init="{
                                        height: 500,
                                        menubar: false,
                                        plugins: [
                                            'advlist autolink lists link image charmap print preview anchor',
                                            'searchreplace visualblocks code fullscreen',
                                            'insertdatetime media table paste code help wordcount'
                                        ],
                                        toolbar:
                                            'undo redo | formatselect | bold italic backcolor | \
                                        alignleft aligncenter alignright alignjustify | \
                                        bullist numlist outdent indent | removeformat | help'
                                    }"
                                />
                                <!-- <textarea
                                    id="vision_and_missions"
                                    class="form-control"
                                    rows="6"
                                    v-model="forms.description"
                                ></textarea> -->
                            </div>
                            <div class="col-lg-2 mb-3">
                                <label for="chart_color">Warna Chart</label>
                                <input
                                    type="color"
                                    id="chart_color"
                                    class="form-control"
                                    v-model="forms.colors"
                                />
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label for="candidates_image"
                                    >Foto Kandidat</label
                                >
                                <input
                                    type="file"
                                    class="form-control"
                                    id="candidates_image"
                                />
                            </div>
                        </div>
                        <button
                            type="button"
                            class="btn btn-light-primary"
                            @click="submitForms"
                        >
                            Simpan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
import Sidenav from '../../../components/Sidenav.vue'
import Editor from '@tinymce/tinymce-vue'

export default {
    name: 'CandidatesCreate',
    metaInfo: {
        title: 'Buat Data Kandidat'
    },
    components: {
        Sidenav,
        editor: Editor
    },
    data() {
        return {
            search: null,
            forms: {
                colors: '0, 0, 0',
                description: null
            },
            selected: {
                student_id: null,
                student_number: null,
                name: null,
                study_program: null,
                study_program_id: null
            },
            students: {}
        }
    },
    methods: {
        searchStudents() {
            if (this.search !== '') {
                axios
                    .get('/api/v1/students?search=' + this.search)
                    .then((response) => {
                        this.students = response.data.results.data
                    })
                    .catch((error) => {
                        console.log(error.response.data)
                    })
            } else {
                this.students = {}
            }
        },

        selectedStudent(
            student_id,
            student_number,
            name,
            study_program,
            study_program_id
        ) {
            this.selected.student_id = student_id
            this.selected.student_number = student_number
            this.selected.name = name
            this.selected.study_program = study_program
            this.selected.study_program_id = study_program_id
        },

        removeSelected() {
            this.selected.student_id = null
            this.selected.student_number = null
            this.selected.name = null
            this.selected.study_program = null
        },

        submitForms() {
            axios
                .post('/api/v1/candidates', {
                    id: this.selected.student_id,
                    description: this.forms.description,
                    color: this.forms.colors
                })
                .then((response) => {
                    this.selected.student_id = null
                    this.selected.student_number = null
                    this.selected.name = null
                    this.selected.study_program = null
                    this.selected.study_program_id = null
                    this.forms.description = null
                    this.forms.colors = '0, 0, 0'
                    this.$toast.open({
                        type: 'success',
                        message: response.data.status.message
                    })
                })
                .catch((error) => {
                    console.log(error.response.data)
                })
        }
    }
}
</script>

<style>
.tox .tox-notification {
    display: none;
}
</style>
