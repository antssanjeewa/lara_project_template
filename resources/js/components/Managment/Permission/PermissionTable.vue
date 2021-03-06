<!-- 
	___________________________________________________________________________________________________________
	
															        PERMISSION TABLE COMPONENT
	___________________________________________________________________________________________________________
	|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
                       
		
	___________________________________________________________________________________________________________
-->

<template>
  <v-card>
    <!--=============================================================================================->
        				    				 	Table Header with Custom Component
    <--=============================================================================================-->
    <table-toolbar title="Permissions Data Table" :total="noData" :add="setToggleDialog">
      <v-flex xs4>
        <v-text-field
          v-model="search"
          append-icon="search"
          label="Search"
          single-line
          hide-details
          @keyup="searchItem"
          class="pb-2 px-4"
        ></v-text-field>
      </v-flex>
    </table-toolbar>
    <v-card-text>
      <v-data-table :headers="headers" :items="permissionList.data" hide-default-footer>
        <!------------------------------------------------------------------------------------------- >
               		 	                  Actions
        <--------------------------------------------------------------------------------------------->
        <template v-slot:item.actions="{ item }">
          <div class="justify-space-around layout">
            <v-tooltip bottom v-for="action in actions" :key="action.text">
              <template v-slot:activator="{ on }">
                <v-hover v-if="action.view">
                  <v-icon
                    @click="actionFunc(item,`${action.text}`)"
                    slot-scope="{hover}"
                    v-on="on"
                    :color="`${ hover ? action.color : themeData.defaltButton }`"
                  >{{ action.icon }}</v-icon>
                </v-hover>
              </template>
              <span>{{ action.text}}</span>
            </v-tooltip>
          </div>
        </template>
      </v-data-table>
      <!--=============================================================================================->
        				    				 	Custom Pagination of the Table
      <--=============================================================================================-->
      <table-pagination :meta="permissionList.meta">
        <v-pagination v-model="page" :length="pages" :total-visible="7" color="grey darken-2"></v-pagination>
      </table-pagination>
    </v-card-text>
  </v-card>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
export default {
  data: () => ({
    page: 1,
    search: "",
    headers: [
      { text: "ID", value: "id", show: true },
      { text: "NAME", value: "name", show: true },
      { text: "ACTIONS", value: "actions", width:'1%', sortable:false, show: true }
    ],
    data: []
  }),
  created() {
    this.searchItem(1);
  },
  watch: {
    /*
     *  Watch the Table Page number and Get Related Data
     */
    page(val) {
      this.searchItem();
    },
    /**
     * When Close Dialog refresh the data table
     */
    dialog(val){
      val || this.searchItem()
    }
  },
  computed: {
    ...mapGetters({
      permissionList: "permission/getItemList",
      dialog: "permission/getDialog",
      loginUser : 'staff/getLoginUser',
      themeData: "getTheme"
    }),

    /**
     *      Actions of the Table Rows (view, edit, delete)
     */
    actions() {
      return this.themeData
        ? [
            {
              text: "View",
              icon: "remove_red_eye",
              color: this.themeData.color.viewButton,
              view: true
            },
            {
              text: "Edit",
              icon: "edit",
              color: this.themeData.color.editButton,
              view: true
            },
            {
              text: "Delete",
              icon: "delete",
              color: this.themeData.color.deleteButton,
              view: this.loginUser.permissions.includes('delete management')
            }
          ]
        : [];
    },
    /*
     *    Check Data is Empty and Return Total Number of Data
     */
    noData() {
      if (this.permissionList.meta) {
        if (this.permissionList.meta.total < 10)
          return "0" + this.permissionList.meta.total;
        else return this.permissionList.meta.total;
      } else {
        return "00";
      }
    },

    /*
     *  Customized Table Column Visibility
     */
    selectHeaders() {
      var tempHeaders = [];
      this.headers.forEach(col => {
        if (col.show) {
          tempHeaders.push(col);
        }
      });
      return tempHeaders;
    },

    /**
     * Set Pagination Page list
     */
    pages() {
      if (this.permissionList.meta)
        return Math.ceil(
          this.permissionList.meta.total / this.permissionList.meta.per_page
        );
    }
  },
  methods: {
    ...mapActions({
      getPermissionList: "permission/get_item_list",
      setToggleDialog: "permission/set_toggle_form",
      setEditItem: "permission/set_edit_item",
      deletePermission: "permission/delete_given_item"
    }),
    
    /**
     * Action Function of the Table Rows
     */
    actionFunc(item, action) {
      switch (action) {
        case "View":
          this.viewItem(item.id);
          break;
        case "Edit":
          this.editItem(item);
          break;
        case "Delete":
          this.deleteItem(item);
          break;
      }
    },

    /**
     * Item View Function
     */
    viewItem(id) {},

    /**
     * Item Edit Function
     */
    editItem(item) {
      this.setEditItem(item);
      this.setToggleDialog();
    },

    /**
     * Item Delete Function
     */
    deleteItem(item) {
      this.$swal({
        icon: "warning",
        title: "Are you sure?",
        text: "you want to delete this item?",
        confirmButtonColor: "#00a805",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, cancel!",
        showCancelButton: true
      }).then(result => {
        if (result.value) {
          this.deletePermission(item.id);
          this.searchItem();
        }
      });
    },

    /**
     * Item Search Function
     */
    searchItem() {
      this.getPermissionList({ page: this.page, query: this.search });
    }
  }
};
</script>