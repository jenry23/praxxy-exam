<template>
  <div>
     <input type="text" class="form-control" @change="handleFileUpload($event)" />
        <video id="video-preview" controls v-show="file != ''" />
  </div>
</template>

<script>
export default {
    props: {
        url: {
            type: String,
            default: '',
        },
    },

}
</script>

<style scoped>
.badge {
  font-size: 0.875rem;
  font-weight: 500;
  text-transform: none;
}
</style>
