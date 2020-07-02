<!-- 
	___________________________________________________________________________________________________________
	
															        Permission MAIN COMPONENT
	___________________________________________________________________________________________________________
	|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
                        ___________________________________________________________
                                                                                   
                          This is the main component of the Department             
                              Vue Router is directly call This Component,          
                              This imported Department Dialog                      
                                                  & Department Table Components    
                        ___________________________________________________________
		
-->

<template>
  <v-container v-if="user.permissions">
    <div v-if="user.permissions.includes('view management')">
      <permission-table />
      <permission-dialog />
    </div>
    <v-flex v-else class="red--text text-center display-2 d-block" pa-9>
      <h1>Sorry</h1>
      <v-sheet height="100"></v-sheet>
      <p>404 - The page cannot be found</p>
    </v-flex>
  </v-container>
</template>

<script>
import PermissionTable from "./PermissionTable";
import PermissionDialog from "./PermissionDialog";
import { mapGetters } from "vuex";

export default {
  components: {
    PermissionTable,
    PermissionDialog
  },
  computed: {
    ...mapGetters({
      user: "staff/getLoginUser"
    })
  }
};
</script>

<style>
</style>