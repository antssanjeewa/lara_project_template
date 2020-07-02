<template>
  <v-navigation-drawer :value="drawer" :clipped="$vuetify.breakpoint.lgAndUp" app>
    <v-list dense>
      <template v-for="item in items">
        <v-row v-if="item.heading" :key="item.heading" align="center">
          <v-col cols="6">
            <v-subheader v-if="item.heading">{{ item.heading }}</v-subheader>
          </v-col>
          <v-col cols="6" class="text-center">
            <a href="#!" class="body-2 black--text">EDIT</a>
          </v-col>
        </v-row>
        
        <v-list-group
          v-else-if="item.children"
          :key="item.text"
          v-model="item.model"
          :prepend-icon="item.model ? item.icon : item['icon-alt']"
          append-icon
          active-class="grey lighten-3 black--text"
        >
          <template v-slot:activator>
            <v-list-item-content>
              <v-list-item-title>{{ item.text }}</v-list-item-title>
            </v-list-item-content>
          </template>
          <v-list-item v-for="(child, i) in item.children" :key="i" :to="child.to" link class="pl-10" active-class="grey lighten-3 black--text">
            <v-list-item-action v-if="child.icon">
              <v-icon>{{ child.icon }}</v-icon>
            </v-list-item-action>
            <v-list-item-content>
              <v-list-item-title>{{ child.text }}</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list-group>

        <v-list-item v-else :key="item.text" :to="item.to" link active-class="grey lighten-3 black--text">
          <v-list-item-action>
            <v-icon>{{ item.icon }}</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>{{ item.text }}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </template>
    </v-list>
  </v-navigation-drawer>
</template>

<script>
import { mapGetters,mapActions } from 'vuex';
export default {
  data: () => ({
    items: [
      { icon: "dashboard", text: "DashBoard", to:'/' },
      { icon: "mdi-history", text: "Asserts", to:'/asserts' },
      { icon: "mdi-content-copy", text: "Elements", to:"/elements" },
      {
        icon: "mdi-chevron-up",
        "icon-alt": "mdi-chevron-down",
        text: "Admin Board",
        model: false,
        children: [
          { icon: "folder", text: "Assert Type", to:'/assert_type' },
          { icon: "folder", text: "Element Category", to:'/element_category' }
          ]
      },
      {
        icon: "mdi-chevron-up",
        "icon-alt": "mdi-chevron-down",
        text: "Managment",
        model: false,
        children: [
          { icon: "folder", text: "User Managment", to:'/user_manage' },
          { icon: "folder", text: "Role Managment", to:'/role_manage' },
          { icon: "folder", text: "Permission Managment", to:'/permission_manage' },
        ]
      },
      { icon: "folder", text: "Remark history", to:"/remarks" },
    ]
  }),
  computed:{
      ...mapGetters({
          drawer:'dashboard/getNavbar'
      })
  },
   methods:{
        ...mapActions({
            setDrawer : 'dashboard/set_toggle_navbar'
        })
    }
};
</script>
<style>
</style>