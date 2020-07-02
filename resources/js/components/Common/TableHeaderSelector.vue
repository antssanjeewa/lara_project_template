<template>
  <v-expansion-panels focusable>
        <v-expansion-panel v-model="panel">
          <v-expansion-panel-header v-slot>
            <h3>Customized Table</h3>
          </v-expansion-panel-header>
          <v-expansion-panel-content>
            <v-layout wrap>
              <template v-for="col in headers">
                <v-flex :key="col.value" v-if="!(col.value == 'id' || col.value == 'actions' || col.value == 'button')">
                  <v-checkbox v-model="col.show" :label="col.text.toLowerCase()" color="primary"></v-checkbox>
                </v-flex>
              </template>
            </v-layout>
          </v-expansion-panel-content>
        </v-expansion-panel>
      </v-expansion-panels>
</template>

<script>
export default {
    props:{
        headers:{
            type:Array,
            required:true
        }
    },
    data:()=>({
        panel:false
    })
}
</script>