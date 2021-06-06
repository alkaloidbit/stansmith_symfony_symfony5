<template>
    <nav :class="[$style.component, 'p-3', 'mb-5']">
        <div
            v-show="!collapsed"
        >
            <h5 class="text-center">
                Artists
            </h5>
            <loading v-show="loading" />
            <ul class="">
                <router-link
                    :class="{
                        'is-current': currentArtistId === null,
                    }"
                    tag="li"
                    to="/player"
                >
                    <a
                        :class="{
                            'nav-link': true,
                            'selected': currentArtistId === null,
                        }"
                        href="/player"
                    >All Artists</a>
                </router-link>
                <router-link
                    v-for="artist in artists"
                    :key="artist['@id']"
                    tag="li"
                    :to="`/artist/${artist.id}`"
                >
                    <a
                        :class="{
                            'nav-link': true,
                            'selected': artist['@id'] === currentArtistId
                        }"
                    >
                        {{ artist.name }}
                    </a>
                </router-link>
            </ul>
            <hr>
        </div>
        <div class="d-flex justify-content-end">
            <button
                class="button is-primary"
                @click="$emit('toggle-collapsed')"
                v-text="collapsed ? '>>' : '<< Collapse'"
            />
        </div>
    </nav>
</template>

<script>

import Loading from '@/components/loading';

export default {
    name: 'Sidebar',
    components: {
        Loading,
    },
    props: {
        collapsed: {
            type: Boolean,
            required: true,
        },
        currentArtistId: {
            type: String,
            default: null,
        },
        artists: {
            type: Array,
            required: true,
        },
    },
    computed: {
        loading() {
            return this.artists.length === 0;
        },
    },
};
</script>

<style lang="scss" module>
</style>
