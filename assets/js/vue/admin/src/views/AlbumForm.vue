<template>
    <div>
        <title-bar :title-stack="titleStack"/>
            <hero-bar>
                {{ heroTitle }}
                <router-link slot="right" :to="heroRouterLinkTo" class="button">
                    {{ heroRouterLinkLabel }}
                </router-link>
            </hero-bar>
            <section class="section is-main-section">
                <hr>
                <!-- <notification class="is-info">
                    <div>
                    <span><b>Demo only.</b> No data will be saved/updated</span>
                    </div>
                    </notification> -->
                    <tiles>
                    <card-component :title="formCardTitle" icon="album" class="tile is-child">
                        <form @submit.prevent="submit">
                            <b-field label="ID" horizontal>
                                <b-input v-model="form.id" custom-class="is-static" readonly />
                            </b-field>
                            <hr>
                            <b-field label="Cover" horizontal>
                                <file-picker/>
                            </b-field>
                            <hr>
                            <b-field label="Title" message="Album title" horizontal>
                                <b-input placeholder="e.g. White Album" v-model="form.title" required />
                            </b-field>
                            <b-field label="Artist" message="Album's artist" horizontal>
                                <b-input placeholder="e.g. the Beatles" v-model="form.artist.name" required />
                            </b-field>
                            <b-field label="Created" horizontal>
                                <b-datepicker
                                    @input="input"
                                    v-model="form.created_date"
                                    placeholder="Click to select..."
                                    icon="calendar-today">
                                </b-datepicker>
                            </b-field>
                            <b-field horizontal>
                                <b-button type="is-primary" :loading="isLoading" native-type="submit">Submit</b-button>
                            </b-field>
                        </form>
                    </card-component>
                    <card-component v-if="isAlbumExists" title="Album Profile" icon="image" class="tile is-child">
                        <album-cover  class="image has-max-width is-aligned-center"/>
                        <hr>
                        <b-field label="Title">
                            <b-input :value="form.title" custom-class="is-static" readonly/>
                        </b-field>
                        <b-field label="Artist">
                            <b-input :value="form.artist.name" custom-class="is-static" readonly/>
                        </b-field>
                        <b-field label="Created">
                            <b-input :value="createdReadable" custom-class="is-static" readonly/>
                        </b-field>
                    </card-component>
                    </tiles>
            </section>
    </div>
</template>

<script>
import axios from 'axios'
import dayjs from 'dayjs'
import TitleBar from 'admin/components/TitleBar'
import HeroBar from 'admin/components/HeroBar'
import Tiles from 'admin/components/Tiles'
import CardComponent from 'admin/components/CardComponent'
import FilePicker from 'admin/components/FilePicker'
import AlbumCover from 'admin/components/AlbumCover'
import { mapState } from 'vuex'

export default {
    name: 'AlbumForm',
    components: { AlbumCover, FilePicker, CardComponent, Tiles, HeroBar, TitleBar },
    props: {
        id: {
            default: null
        }
    },
    data () {
        return {
            isLoading: false,
            form: this.getClearFormObject(),
            createdReadable: null,
            isAlbumExists: false
        }
    },
    computed: {
        titleStack () {
            let lastCrumb

            if (this.isAlbumExists) {
                lastCrumb = this.form.title
            } else {
                lastCrumb = 'New album'
            }

            return [
                'Admin',
                'Albums',
                lastCrumb
            ]
        },
        heroTitle () {
            if (this.isAlbumExists) {
                return this.form.title
            } else {
                return 'Create Album'
            }
        },
        heroRouterLinkTo () {
            if (this.isAlbumExists) {
                return { name: 'album.new' }
            } else {
                return '/'
            }
        },
        heroRouterLinkLabel () {
            if (this.isAlbumExists) {
                return 'New Album'
            } else {
                return 'Dashboard'
            }
        },
        formCardTitle () {
            if (this.isAlbumExists) {
                return 'Edit Album'
            } else {
                return 'New Album'
            }
        },
        ...mapState([
            'cover'
        ])
    },
    created () {
        this.getData()
    },
    methods: {
        getClearFormObject () {
            return {
                id: null,
                title: null,
                artist: {},
                created_date: new Date(),
                created_mm_dd_yyyy: null
            }
        },
        getData () {
            if (this.id) {
                axios
                    .get(`/api/albums/${this.id}`)
                    .then(result => {
                        const item = result.data
                        if (item) {
                            this.isAlbumExists = true
                            this.form = item
                            this.$store.commit('cover', item.cover[0])
                            this.form.created_date = new Date(item.created_date)
                            this.createdReadable = dayjs(new Date(item.created_date)).format('MMM D, YYYY')
                        } else {
                            this.$router.push({ name: 'album.new' })
                        }
                    })
                    .catch(e => {
                        this.$buefy.toast.open({
                            message: `Error: ${e.message}`,
                            type: 'is-danger',
                            queue: false
                        })
                    })
            }
        },
        input (v) {
            this.createdReadable = dayjs(v).format('MMM D, YYYY')
        },
        submit () {
            this.isLoading = true
            axios.put(`/api/albums/${this.form.id}`, { cover: [this.cover['@id']] })
                .then((res) => {
                    console.log(res)
                    this.isLoading = false
                    this.$buefy.snackbar.open({
                        message: 'Cover updated',
                        queue: false
                    })
                })
        }
    },
    watch: {
        id (newValue) {
            this.isAlbumExists = false

            if (!newValue) {
                this.form = this.getClearFormObject()
            } else {
                this.getData()
            }
        }
    }
}
</script>
