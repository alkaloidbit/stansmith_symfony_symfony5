<template>
    <section class="hero is-primary">
        <div class="hero-body">
            <p class="title">{{ user.username }}</p>
            <p class="subtitle">{{ user.email }}</p>
            <p class="subtitle">{{ user.validTokenStrings }}</p>
        </div>
    </section>
</template>

<script>
export default {
    name: 'Profile',
    data() {
        return {
            user: {},
        };
    },
    computed: {
    },
    created() {
        this.user = this.$store.getters['security/getUser'];
    },
    methods: {

    },
}
</script>
