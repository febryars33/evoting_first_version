<template>
  <div class="container">
    <div class="row">
      <div class="col-lg-3">
        <Sidenav />
      </div>
      <div class="col-lg">
        <h5 class="text-primary mb-4"><i class="fa fa-user-check"></i> Data Kandidat</h5>
      </div>
    </div>
  </div>
</template>

<script>
import Sidenav from '../../../components/Sidenav.vue'

export default {
  name: 'CandidatesIndex',
  metaInfo: {
    title: 'Data Kandidat',
  },
  components: {
    Sidenav
  }
}
</script>