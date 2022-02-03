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
                    <card-component :title="formCardTitle" icon="image" class="tile is-child">
                        <form @submit.prevent="submit">
                            <b-field label="ID" horizontal>
                                <b-input v-model="form.id" custom-class="is-static" readonly />
                            </b-field>
                            <hr>
                            <b-field label="Cover" horizontal>
                                <file-picker/>
                            </b-field>
                            <hr>
                            <b-field label="fileName" message="MediaObject fileName" horizontal>
                                <b-input placeholder="e.g. White Album" v-model="form.fileName" required />
                            </b-field>
                            <b-field label="@id" message="MediaObject id" horizontal>
                                <b-input placeholder="" v-model="form['@id']" required />
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
                    <card-component v-if="isMediaObjectExists" title="Album Profile" icon="image" class="tile is-child">
                        <album-cover :cover-uri="form.coverContentUrl" class="image has-max-width is-aligned-center"/>
                            <hr>
                            <b-field label="Title">
                                <b-input :value="form.filePath" custom-class="is-static" readonly/>
                            </b-field>
                            <b-field label="Artist">
                                <b-input :value="form.album" custom-class="is-static" readonly/>
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
import find from 'lodash/find'
import TitleBar from 'admin/components/TitleBar'
import HeroBar from 'admin/components/HeroBar'
import Tiles from 'admin/components/Tiles'
import CardComponent from 'admin/components/CardComponent'
import FilePicker from 'admin/components/FilePicker'
import AlbumCover from 'admin/components/AlbumCover'
import { mapState } from 'vuex'

export default {
    name: 'MediaObjectForm',
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
            isMediaObjectExists: false
        }
    },
    computed: {
        titleStack () {
            let lastCrumb

            if (this.isMediaObjectExists) {
                lastCrumb = this.form.title
            } else {
                lastCrumb = 'New Media Object'
            }

            return [
                'Admin',
                'Media Objects',
                lastCrumb
            ]
        },
        heroTitle () {
            if (this.isMediaObjectExists) {
                return this.form.title
            } else {
                return 'Create Media Object'
            }
        },
        heroRouterLinkTo () {
            if (this.isMediaObjectExists) {
                return { name: 'media_object.new' }
            } else {
                return '/'
            }
        },
        heroRouterLinkLabel () {
            if (this.isMediaObjectExists) {
                return 'New Media Object'
            } else {
                return 'Dashboard'
            }
        },
        formCardTitle () {
            if (this.isMediaObjectExists) {
                return 'Edit Media Object'
            } else {
                return 'New Media Object'
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
                filePath: null,
                album: null,
                coverContentUrl: null,
                created_date: new Date(),
                created_mm_dd_yyyy: null
            }
        },
        getData () {
            if (this.id) {
                axios
                    .get(`/api/media_objects/${this.id}`)
                    .then(result => {
                        const item = result.data
                        if (item) {
                            console.log(item);
                            this.isMediaObjectExists = true
                            this.form = item

                            console.log(this.form);
                            this.form.created_date = new Date(item.created_date)
                            this.createdReadable = dayjs(new Date(item.created_date)).format('MMM D, YYYY')
                        } else {
                            this.$router.push({ name: 'media_object.new' })
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
            axios.put(`/api/media_objects/${this.form.id}`, { cover: this.cover['@id'] })
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
            this.isMediaObjectExists = false

            if (!newValue) {
                this.form = this.getClearFormObject()
            } else {
                this.getData()
            }
        }
    }
}
</script>
