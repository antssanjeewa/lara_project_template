<template>
   <v-app-bar
      :clipped-left="$vuetify.breakpoint.lgAndUp"
      app
      color="grey darken-3"
      dark
    >
      <v-app-bar-nav-icon @click.stop="setDrawer"></v-app-bar-nav-icon>
      <v-toolbar-title
        style="width: 300px"
        class="ml-0 pl-4"
      >
        <span class="hidden-sm-and-down">{{name}}</span>
      </v-toolbar-title>
      <v-text-field
        flat
        solo-inverted
        hide-details
        prepend-inner-icon="mdi-magnify"
        label="Search"
        class="hidden-sm-and-down"
      ></v-text-field>
      <v-spacer></v-spacer>
      <v-btn icon>
        <v-icon>mdi-apps</v-icon>
      </v-btn>
      <v-btn icon>
        <v-icon>mdi-bell</v-icon>
      </v-btn>
      <v-btn
        icon
        x-large
      >
       <v-icon x-large>person</v-icon>
      </v-btn>
    </v-app-bar>
</template>

<script>
import {mapActions} from 'vuex';

export default {
    data:()=>({
        name:"Assert Management System",
    }),
    methods:{
        ...mapActions({
            setDrawer : 'dashboard/set_toggle_navbar'
        })
    }
}
</script>

<style>

</style>