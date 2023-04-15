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
                :data="media_objects">

                <b-table-column label="id" field="company" sortable v-slot="props">
                    {{ props.row.id }}
                </b-table-column>
                <b-table-column cell-class="has-no-head-mobile is-image-cell" v-slot="props">
                    <div class="image">
                        <img :src="props.row.coverContentUrl" class="">
                    </div>
                </b-table-column>
                <b-table-column label="filename" field="name" sortable v-slot="props">
                    {{ props.row.fileName }}
                </b-table-column>
                <b-table-column label="album" field="city" sortable v-slot="props">
                    {{ props.row.album }}
                </b-table-column>
                <b-table-column label="Created" v-slot="props">
                    <small class="has-text-grey is-abbr-like" :title="props.row.created">{{ props.row.created_date | formatDate }}</small>
                </b-table-column>
                <b-table-column custom-key="actions" cell-class="is-actions-cell" v-slot="props">
                    <div class="buttons is-right">
                        <!-- <router-link :to="{name:'media_object.edit', params: {id: props.row.id}}" class="button is-small is-primary">
                            <b-icon icon="lead-pencil" size="is-small"/>
                        </router-link> -->
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
import find from 'lodash/find'
import ModalBox from 'admin/components/ModalBox'

export default {
    name: 'MediaObjectsTable',
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
            media_objects: [],
            isLoading: false,
            paginated: false,
            perPage: 30,
            checkedRows: []
        }
    },
    computed: {
        trashObjectName () {
            if (this.trashObject) {
                return this.trashObject['@id']
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
                        this.media_objects = r.data['hydra:member']
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
            console.log(this.trashObject)
            // Delete here
            axios.delete(this.trashObject['@id'])
                .then(this.$buefy.snackbar.open({
                    message: 'Confirmed',
                    queue: false
                }))
            const item = find(this.media_objects, item => item.id === this.trashObject.id)
            this.media_objects.splice(this.media_objects.indexOf(item), 1)
        },
        trashCancel () {
            this.isModalActive = false
        }
    }
}
</script>
