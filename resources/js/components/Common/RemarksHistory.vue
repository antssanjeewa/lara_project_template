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
  <v-flex py-3 xs12>
    <v-card>
      <!--===============================================================================================->
                                Component Title
      <--===============================================================================================-->
      <v-card-title>
        Remark History
        <v-spacer></v-spacer>
        <v-btn @click="hide = !hide" text color="primary" x-small>{{ hide ? 'hide': 'show' }}</v-btn>
        <v-icon @click="hide = !hide">{{ hide ? 'expand_less': 'expand_more' }}</v-icon>
      </v-card-title>
      <v-card-text :hidden="!hide">
        <!--===================================================================================================->
                                       Show when Data Length is Zero (0)
        <--===================================================================================================-->
        <v-flex v-if="remarks.length == 0">
          <v-alert :value="true" type="warning">There has No Recent Updates</v-alert>
        </v-flex>
        <v-flex v-else>
          <!--=============================================================================================->
                                      Child Family Details
          <--=============================================================================================-->
            <v-list two-line max-height="300" style="overflow:auto">
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
                <v-divider v-if="index + 1 < remarks.length" :key="index"></v-divider>
              </template>
            </v-list>
          </v-flex>
      </v-card-text>
    </v-card>
  </v-flex>
</template>


<!--::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::-->


<script>
export default {
  data: () => ({
    hide: false
  }),
  props: ["remarks"]
};
</script>
