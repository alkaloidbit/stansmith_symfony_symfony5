<template>
    <div>
        <modal-box :is-active="isModalActive" :trash-object-name="trashObjectName" @confirm="trashConfirm"
            @cancel="trashCancel"/>
        <b-table
            :checked-rows.sync="checkedRows"
            :checkable="checkable"
            :loading="isLoading"
            :paginated="paginated"
            :per-page="perPage"
            :striped="true"
            :hoverable="true"
            default-sort="name"
            :data="albums">

            <b-table-column label="id" field="company" sortable v-slot="props">
                {{ props.row.id }}
            </b-table-column>
            <b-table-column cell-class="has-no-head-mobile is-image-cell" v-slot="props">
                <div class="image">
                    <img v-if="props.row.cover[0]" :src="props.row.cover[0].contentUrl" class="">
                    <img v-else src="http://via.placeholder.com/400x400/fefefe" alt="">
                </div>
            </b-table-column>
            <b-table-column label="Title" field="title" sortable v-slot="props">
                {{ props.row.title }}
            </b-table-column>
            <b-table-column label="Artist" field="artist" sortable v-slot="props">
                {{ props.row.artist.name }}
            </b-table-column>
            <b-table-column label="Created" v-slot="props">
                <small class="has-text-grey is-abbr-like" :title="props.row.created">{{ props.row.created_date | formatDate }}</small>
            </b-table-column>
            <b-table-column custom-key="actions" cell-class="is-actions-cell" v-slot="props">
                <div class="buttons is-right">
                    <button  class="button is-small " :class="props.row.active ? 'is-success' : 'is-danger'" type="button" @click.prevent="toggleActive(props.row)">
                        <b-icon
                            :icon="props.row.active ? 'check' : 'cancel'"
                            size="is-small"
                        />
                    </button>
                    <router-link :to="{name:'album.edit', params: {id: props.row.id}}" class="button is-small is-primary">
                        <b-icon icon="lead-pencil" size="is-small"/>
                    </router-link>
                    <button class="button is-small is-danger" type="button" @click.prevent="trashModal(props.row)">
                        <b-icon icon="trash-can" size="is-small"/>
                    </button>
                </div>
            </b-table-column>

        </b-table>
    </div>
</template>

<script>
import axios from 'axios'
import ModalBox from 'admin/components/ModalBox'

export default {
    name: 'AlbumsTable',
    components: { ModalBox },
    props: {
        dataUrl: {
            type: String,
            default: null
        },
        checkable: {
            type: Boolean,
            default: false
        }
    },
    data () {
        return {
            isModalActive: false,
            trashObject: null,
            albums: [],
            isLoading: false,
            paginated: false,
            perPage: 30,
            checkedRows: []
        }
    },
    computed: {
        trashObjectName () {
            if (this.trashObject) {
                return this.trashObject.name
            }

            return null
        }
    },
    mounted () {
        if (this.dataUrl) {
            this.isLoading = true
            axios
                .get(this.dataUrl)
                .then(r => {
                    this.isLoading = false
                    if (r.data && r.data['hydra:member']) {
                        if (r.data['hydra:member'].length > this.perPage) {
                            this.paginated = true
                        }
                        console.log(r.data['hydra:member'][0])
                        this.albums = r.data['hydra:member']
                    }
                })
                .catch(e => {
                    this.isLoading = false
                    this.$buefy.toast.open({
                        message: `Error: ${e.message}`,
                        type: 'is-danger'
                    })
                })
        }
    },
    methods: {
        trashModal (trashObject) {
            this.trashObject = trashObject
            this.isModalActive = true
        },
        trashConfirm () {
            this.isModalActive = false
            this.$buefy.snackbar.open({
                message: 'Confirmed',
                queue: false
            })
        },
        trashCancel () {
            this.isModalActive = false
        },
        toggleActive (activeObject) {
            axios.put(activeObject['@id'], { active: !activeObject.active })
                .then(this.$buefy.snackbar.open({
                    message: 'Confirmed',
                    queue: false
                }))
        }
    }
}
</script>
