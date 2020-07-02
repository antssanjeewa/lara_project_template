<template>
  <v-toolbar flat :color="themeData.color.tableHeader" dark>
    <!--=============================================================================================->
                                  Title of the Table
    <--=============================================================================================-->
    <v-toolbar-title>{{title}}</v-toolbar-title>
    <v-divider class="mx-4 grey darken-3" inset vertical></v-divider>

    <!--=============================================================================================->
                                  Total number of Childrens
    <--=============================================================================================-->
    <span>
      Total:
      <b :class="themeData.color.totalnumber">{{ total }}</b>
    </span>
    <v-spacer></v-spacer>

    <!--=============================================================================================->
                                  Childs Search Field
    <--=============================================================================================-->
    <slot/>

    <!--=============================================================================================->
                                  Add new Button in Childrens
    <--=============================================================================================-->
    <template>
      <v-btn :color="themeData.color.addNewButton" dark @click="add()">
        <v-icon>add</v-icon>
        <v-divider class="ml-2 my-1 blue darken-3" inset vertical></v-divider>
        <v-divider class="mr-2 my-1 blue darken-3" inset vertical></v-divider>
        <span>Add New</span>
      </v-btn>
    </template>
  </v-toolbar>
</template>

<script>
import { mapGetters } from "vuex";
export default {
    props:{
        title:{
            type:String,
            default:"NO Title"
        },
        total:{
            type:[String,Number],
            default:"00"
        },
        add:Function

    },
  computed: {
    ...mapGetters({
      themeData: "getTheme"
    })
  }
};
</script>