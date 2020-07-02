<template>
  <v-app id="inspire">
    <navigation-bar></navigation-bar>
    <tool-bar></tool-bar> 
    <v-main>
      <router-view/>
    </v-main>
    <v-btn bottom color="green" dark fab fixed right @click="setDialog">
      <v-icon>help</v-icon>
    </v-btn>
   <help-dialog></help-dialog>
   <loader/>
  </v-app>
</template>

<script>
import NavigationBar from "./_Sub/NavigationBar";
import ToolBar from "./_Sub/TopToolBar";
import HelpDialog from './_Sub/HelpDialog';
import Loader from './Common/Loader';

import { mapActions } from 'vuex';
export default {
  data: () => ({
    dialog: false
  }),
  components: {
    NavigationBar,
    ToolBar,
    HelpDialog,
    Loader
  },
  created(){
    this.setLoginUser()
  },
  methods:{
    ...mapActions({
      setDialog : 'dashboard/set_toggle_help_dialog',
      setLoginUser: "staff/get_login_user",
    })
  }
};
</script>