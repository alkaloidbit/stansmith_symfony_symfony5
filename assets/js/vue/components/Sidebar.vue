<template>
    <div class="sidebar-page">
        <section class="sidebar-layout">
            <b-sidebar
                position="fixed"
                :mobile="mobile"
                :expand-on-hover="expandOnHover"
                :reduce="reduce"
                fullheight
                type="is-white"
                open
            >
                <div class="p-1">
                    <div class="block">
                        <a href="/player">
                            <img
                                src="https://avatars.dicebear.com/api/male/stansmithmusic.svg"
                                alt="Lightweight UI components for Vue.js based on Bulma."
                            >
                        </a>
                    </div>
                    <b-menu class="is-custom-mobile">
                        <b-menu-list label="Menu">
                            <b-menu-item
                                icon="album"
                                label="Albums"
                            />
                            <b-menu-item
                                active
                                icon="account"
                                label="Artists"
                            >
                                <b-menu-item
                                    tag="router-link"
                                    to="/player"
                                    label="All artists"
                                    :active="currentArtistId === null"
                                />

                                <b-menu-item
                                    v-for="artist in artists"
                                    :key="artist['@id']"
                                    tag="router-link"
                                    :active="currentArtistId === `/api/artists/${artist.id}`"
                                    :to="`/artist/${artist.id}`"
                                    :label="artist.name"
                                />
                            </b-menu-item>
                            <!-- <b-menu-item -->
                            <!--     icon="account" -->
                            <!--     label="Users" -->
                            <!-- /> -->
                            <!-- <b-menu-item -->
                            <!--     icon="cellphone-link" -->
                            <!--     label="Devices" -->
                            <!-- /> -->
                            <!-- <b-menu-item -->
                            <!--     icon="cash-multiple" -->
                            <!--     label="Payments" -->
                            <!--     disabled -->
                            <!-- /> -->
                            <!-- <b-menu-item -->
                            <!--     icon="account" -->
                            <!--     label="My account" -->
                            <!-- > -->
                            <!--     <b-menu-item -->
                            <!--         icon="account-box" -->
                            <!--         label="Account data" -->
                            <!--     /> -->
                            <!--     <b-menu-item -->
                            <!--         icon="home-account" -->
                            <!--         label="Addresses" -->
                            <!--     /> -->
                            <!-- </b-menu-item> -->
                        </b-menu-list>
                        <b-menu-list label="Actions">
                            <b-menu-item
                                icon="logout"
                                label="Logout"
                                activable="false"
                                tag="a"
                                href="/api/security/logout"
                            />
                        </b-menu-list>
                    </b-menu>
                </div>
            </b-sidebar>
            <!-- <div class="p-1">
                <b-field>
                    <b-switch v-model="reduce">
                        Reduced
                    </b-switch>
                </b-field>
                <b-field>
                    <b-switch v-model="expandOnHover">
                        Expand on hover
                    </b-switch>
                </b-field>
                <b-field label="Mobile Layout">
                    <b-select v-model="mobile">
                        <option :value="null" />
                        <option value="reduce">
                            Reduced
                        </option>
                        <option value="hide">
                            Hidden
                        </option>
                        <option value="fullwidth">
                            Fullwidth
                        </option>
                    </b-select>
                </b-field>
            </div> -->
        </section>
    </div>
</template>

<script>
export default {
    props: {
        currentArtistId: {
            type: String,
            default: null,
        },
        artists: {
            type: Array,
            required: true,
        },
    },
    data() {
        return {
            expandOnHover: false,
            mobile: 'reduce',
            reduce: false,
        };
    },
};
</script>

<style lang="scss" >
.p-1 {
  padding: 1em;
}
.sidebar-page {
    display: flex;
    flex-direction: column;
    width: 100%;
    min-height: 100%;
    .sidebar-layout {
        display: flex;
        flex-direction: row;
        min-height: 100%;
    }
}

@media screen and (max-width: 1023px) {
    .b-sidebar {
        .sidebar-content {
            &.is-mini-mobile {
                &:not(.is-mini-expand),
                &.is-mini-expand:not(:hover) {
                    .menu-list {
                        li {
                            a {
                                span:nth-child(2) {
                                    display: none;
                                }
                            }
                            ul {
                                padding-left: 0;
                                li {
                                    a {
                                        display: inline-block;
                                    }
                                }
                            }
                        }
                    }
                    .menu-label:not(:last-child) {
                        margin-bottom: 0;
                    }
                }
            }
        }
    }
}

@media screen and (min-width: 1024px) {
    .b-sidebar {
        .sidebar-content {
            display: none;
            &.is-mini {
                &:not(.is-mini-expand),
                &.is-mini-expand:not(:hover) {
                    .menu-list {
                        li {
                            a {
                                span:nth-child(2) {
                                    display: none;
                                }
                            }
                            ul {
                                padding-left: 0;
                                li {
                                    a {
                                        display: inline-block;
                                    }
                                }
                            }
                        }
                    }
                    .menu-label:not(:last-child) {
                        margin-bottom: 0;
                    }
                }
            }
        }
    }
}

.is-mini-expand {
    .menu-list a {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
}
</style>
