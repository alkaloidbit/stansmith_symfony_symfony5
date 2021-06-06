<template>
    <div>
        <title-bar :title-stack="titleStack"/>
        <hero-bar>
            Albums
            <router-link slot="right" to="/" class="button">
                Dashboard
            </router-link>
        </hero-bar>
        <section class="section is-main-section">
            <card-component class="has-table has-mobile-sort-spaced" title="Albums" icon="album">
                <albums-table data-url="/api/albums" :checkable="true"></albums-table>
            </card-component>
        </section>
    </div>
</template>

<script>
import AlbumsTable from 'admin/components/AlbumsTable'
import CardComponent from 'admin/components/CardComponent'
import TitleBar from 'admin/components/TitleBar'
import HeroBar from 'admin/components/HeroBar'

export default {
    name: 'Tables',
    components: { HeroBar, TitleBar, CardComponent, AlbumsTable },
    computed: {
        titleStack () {
            return [
                'Admin',
                'Albums'
            ]
        }
    }
}
</script>
