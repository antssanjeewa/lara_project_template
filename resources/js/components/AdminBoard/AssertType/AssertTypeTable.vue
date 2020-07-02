<template>
  <v-card>
    <table-toolbar :title="title" :total="noData" :add="getItemList"></table-toolbar>
    <v-card-text>
      <v-data-table :headers="headers"></v-data-table>
    </v-card-text>
  </v-card>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
export default {
  data: () => ({
    title:'Assert Table',
    headers: [{ text: "name", value: "name" }]
  }),
  created(){
    this.getItemList(1)
  },
  computed: {
    ...mapGetters({
      itemList: "assert_type/getItems"
    }),
    /*
     *    Check Data is Empty and Return Total Number of Data
     */
    noData() {
      if (this.itemList.meta) {
        if (this.itemList.meta.total < 10)
          return "0" + this.itemList.meta.total;
        else return this.itemList.meta.total;
      } else {
        return "00";
      }
    },
  },
  methods:{
    ...mapActions({
      getItemList : 'assert_type/get_item_list'
    })
  }
};
</script>