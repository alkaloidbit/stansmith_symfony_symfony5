<template>
    <div>
        <title-bar :title-stack="titleStack"/>
        <hero-bar>
            Media Objects
            <router-link slot="right" to="/" class="button">
                Dashboard
            </router-link>
        </hero-bar>
        <section class="section is-main-section">
            <card-component class="has-table has-mobile-sort-spaced" title="MediaObjects" icon="image">
                <media-objects-table data-url="/api/media_objects" :checkable="true" />
            </card-component>
        </section>
    </div>

</template>

<script>
import MediaObjectsTable from 'admin/components/MediaObjectsTable'
import CardComponent from 'admin/components/CardComponent'
import TitleBar from 'admin/components/TitleBar'
import HeroBar from 'admin/components/HeroBar'

export default {
    name: 'Tables',
    components: { HeroBar, TitleBar, CardComponent, MediaObjectsTable },
    computed: {
        titleStack () {
            return [
                'Admin',
                'Media Objects'
            ]
        }
    }
}
</script>
