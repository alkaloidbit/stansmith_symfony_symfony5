<template>
  <div>
    <title-bar :title-stack="titleStack"/>
    <hero-bar>
      Profile
      <router-link slot="right" to="/" class="button">
        Dashboard
      </router-link>
    </hero-bar>
    <section class="section is-main-section">
      <tiles>
        <profile-update-form class="tile is-child"/>
        <card-component title="Profile" icon="account" class="tile is-child">
          <user-avatar class="image has-max-width is-aligned-center"/>
          <hr>
          <b-field label="Name">
            <b-input :value="userName" custom-class="is-static" readonly/>
          </b-field>
          <hr>
          <b-field label="E-mail">
            <b-input :value="userEmail" custom-class="is-static" readonly/>
          </b-field>
        </card-component>
      </tiles>
      <password-update-form/>
    </section>
  </div>
</template>

<script>
import { mapState } from 'vuex'
import CardComponent from 'admin/components/CardComponent'
import TitleBar from 'admin/components/TitleBar'
import HeroBar from 'admin/components/HeroBar'
import ProfileUpdateForm from 'admin/components/ProfileUpdateForm'
import PasswordUpdateForm from 'admin/components/PasswordUpdateForm'
import Tiles from 'admin/components/Tiles'
import UserAvatar from 'admin/components/UserAvatar'

export default {
  name: 'Profile',
  components: { UserAvatar, Tiles, PasswordUpdateForm, ProfileUpdateForm, HeroBar, TitleBar, CardComponent },
  computed: {
    titleStack () {
      return [
        'Admin',
        'Profile'
      ]
    },
    ...mapState([
      'userName',
      'userEmail'
    ])
  }
}
</script>
