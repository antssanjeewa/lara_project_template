<!-- 
	___________________________________________________________________________________________________________
	
                                    REMARK HISTORY COMPONENT
	___________________________________________________________________________________________________________
	|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||

                         ___________________________________________________________
                        |                                                           |
                        |          This Component Use for the preview the           |
                        |            Recent Update of each component                |
                        |                                                           |
                        |     Show the List of Updates with,                        |
                        |                                   *  Remark               |
                        |                                   *  Updated User Name    |
                        |                                   *  Updated Date         |
                        |___________________________________________________________|
	
-->


<template>
  <v-layout row wrap>
    
    <!--===================================================================================================->
                                       Title of the Component
    <--===================================================================================================-->
    <v-flex xs12>
      <v-subheader class="title">Recent Updates</v-subheader>
      <v-divider></v-divider>
    </v-flex>

    <!--===================================================================================================->
                                       Show when Data Length is Zero (0)
    <--===================================================================================================-->
    <v-flex v-if="remarks.length == 0">
      <v-alert :value="true" type="warning">There has No Recent Updates</v-alert>
    </v-flex>

    <!--===================================================================================================->
                                       Show Remark Details
    <--===================================================================================================-->
    <v-flex v-else>
      <v-list two-line>
        <template v-for="(item, index) in remarks">
          <v-list-item :key="item.created_at">
             <v-list-item-avatar
              color="indigo"
              class="headline font-weight-light white--text"
            >{{ index+1 }}</v-list-item-avatar>
            <v-list-item-content>
              <v-list-item-title>{{ item.body }}</v-list-item-title>
            </v-list-item-content>

            <v-list-item-action>
              <v-list-item-subtitle class="text--primary">{{ item.created_at }}</v-list-item-subtitle>
              <v-list-item-subtitle class="text--primary">{{ item.user_name }}</v-list-item-subtitle>
            </v-list-item-action>
          </v-list-item>
          <v-divider v-if="index + 1 < remarks.length"  :key="index"></v-divider>
        </template>
      </v-list>
    </v-flex>
  </v-layout>
</template>


<!--::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::-->


<script>
export default {
  data() {
    return {};
  },
  props: ['remarks']
};
</script>
