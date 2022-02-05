<template>
    <div class="is-album-cover">
        <img id="albumCover" :src="newAlbumCover" alt="">
        <div v-if="imageLoaded">
            <span class="is-img-spc is-top">{{  this.coverFilename }}</span>
            <span  class="is-img-spc is-bottom">{{ coverWidth }} x {{ coverHeight }}</span>
            <span  class="is-img-spc is-bottom is-right">{{ coverSize }}</span>
        </div>
    </div>
</template>

<script>
import { mapState } from 'vuex'
import formatBytes from '../../../helpers/formatBytes'

export default {
    name: 'AlbumCover',
    props: {},
    computed: {
        newAlbumCover () {
            if (this.cover) {
                return this.readFile(this.cover.coverContentUrl)
            }

            return 'http://via.placeholder.com/400x400/fefefe'
        },
        ...mapState([
            'cover'
        ])
    },
    data () {
        return {
            imageLoaded: false,
            coverWidth: '',
            coverHeight: '',
            coverSize: '',
            coverFilename: ''
        }
    },
    methods: {
        /**
         * return File instance from src attr
         */
        async fetchFile (src) {
            const response = await fetch(src)
            const blobdata = await response.blob()

            let coverFilename = src.split('/')
            coverFilename = coverFilename[coverFilename.length - 1]

            const coverExt = coverFilename.split('.')[1]

            const metadata = {
                type: `image/${coverExt}`
            }
            const file = new File([blobdata], coverFilename, metadata)
            return file
        },
        readFile (src) {
            const reader = new FileReader()
            this.fetchFile(src).then((file) => {
                this.coverFilename = file.name
                this.coverSize = formatBytes(file.size)
                reader.readAsDataURL(file)
                reader.onload = evt => {
                    const img = new Image()
                    this.imageLoaded = true
                    img.onload = () => {
                        this.coverHeight = img.height
                        this.coverWidth = img.width
                    }
                    img.src = evt.target.result
                }
                reader.onerror = evt => {
                    console.log(evt)
                }
            })
            return src
        }
    }
}
</script>

<style lang="scss">
.is-album-cover {
    position: relative;
}
.is-img-spc {
    position: absolute;
    background-color: rgba(0,0,0,.5);
    box-shadow: 0 0 1px 0 rgba(0,0,0,16);
    padding: 4px;
    line-height: 12px;
    color: #f1f3f4;
    border-radius: 0 2px 0 0;
}
.is-bottom {
    bottom: 0;
}
.is-right {
    right: 0;
}

.is-top {
    top: 0;
}

</style>
