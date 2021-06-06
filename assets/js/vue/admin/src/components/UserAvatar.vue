<template>
    <div class="is-user-avatar">
        <img :src="newUserAvatar" :alt="userName">
    </div>
</template>

<script>
import { mapState } from 'vuex'

export default {
    name: 'UserAvatar',
    props: {
        avatar: {
            type: String,
            default: null
        }
    },
    computed: {
        newUserAvatar () {
            // if a avatar prop is passed on instantiating
            if (this.avatar) {
                return this.avatar
            }
            // if userAvatar computekkg
            if (this.userAvatar) {
                return this.userAvatar
            }

            let name = 'somename'

            if (this.userName) {
                name = this.userName.replace(/[^a-z0-9]+/i, '')
            }

            // https://avatars.dicebear.com/api/avataaars/example.svg?options[top][]=shortHair&options[accessoriesChance]=93
            return `https://avatars.dicebear.com/api/avataaars/${name}.svg?options[top][]=shortHair&options[accessoriesChance]=93`
        },
        ...mapState([
            'userAvatar',
            'userName'
        ])
    }
}
</script>
