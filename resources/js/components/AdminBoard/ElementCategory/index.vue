<!-- 
	___________________________________________________________________________________________________________
	
															        ElementCategory MAIN COMPONENT
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
    <div v-if="user.permissions.includes('view adminboard')">
      <element-category-table />
      <element-category-dialog />
    </div>
    <v-flex v-else class="red--text text-center display-2 d-block" pa-9>
      <h1>Sorry</h1>
      <v-sheet height="100"></v-sheet>
      <p>404 - The page cannot be found</p>
    </v-flex>
  </v-container>
</template>

<script>
import ElementCategoryTable from "./ElementCategoryTable";
import ElementCategoryDialog from "./ElementCategoryDialog";
import { mapGetters } from "vuex";
export default {
  components: {
    ElementCategoryTable,
    ElementCategoryDialog
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