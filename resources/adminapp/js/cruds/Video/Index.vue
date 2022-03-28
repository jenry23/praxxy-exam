<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">assignment</i>
                        </div>
                        <h4 class="card-title">
                            <strong>Video File Preview</strong>
                        </h4>
                    </div>
                    <div class="card-body">
                        <label>Youtube URL </label>

                        <input
                            type="text"
                            class="form-control"
                            v-model="fields.youtubeUrl"
                            @change="handleFileUpload($event)"
                        />
                        <button class="btn btn-primary" @click="embedYoutubeLink">
                            <i class="fa fa-search" />
                            <span class="youtube-span-tag">Search</span>
                        </button>
                        <div class="owl-custom-video-style">
                            <iframe
                                class="responsive-iframe"
                                width="920"
                                height="720"
                                ref="iframeYoutube"
                                src=""
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

const YOUTUBE_EMBED_LINK = 'https://www.youtube.com/embed/';

export default {

    data () {
        return {
            file: '',
            fields: {
                youtubeUrl: null,
            },
        }
    },

    methods: {
        embedYoutubeLink () {
            let videoId = this.getYoutubeId(this.fields.youtubeUrl);
             this.$refs.iframeYoutube.contentWindow.location.replace(YOUTUBE_EMBED_LINK + videoId);
        },
        handleFileUpload (event) {
            // this.previewVideo();
            console.log(event);
        },

        getYoutubeId (url) {
            const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|&v=)([^#&?]*).*/;
            const match = url.match(regExp);

            return (match && match[2].length === 11) ? match[2] : null;
        },

        submitFile () {
            let formData = new FormData();

            formData.append('file', this.file);

            axios.post('/video-file',
                formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }
            ).then(function () {
                console.log('SUCCESS!!');
            })
                .catch(function () {
                    console.log('FAILURE!!');
                });
        }
    }
}
</script>
