<!-- 
	___________________________________________________________________________________________________________
	
															        SETTING OF THE APPLICATION
	___________________________________________________________________________________________________________
	|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
                         ___________________________________________________________
                        |                                                           |
                        |      This is the Setting component of the application     |
                        |          This use for the change application color        |
                        |             theme and other setting for the user          |
                        |___________________________________________________________|
		
-->


<template>
  <div>
    <v-flex pa-3>
      <v-card>
        <v-toolbar flat :color="themeData.tableHeader" dark>
          <!--=============================================================================================->
                                       Title of the Table		 	 				 																 
          <--=============================================================================================-->
          <v-toolbar-title>Remarks History</v-toolbar-title>

          <v-divider class="mx-4 grey darken-3" inset vertical></v-divider>

          <!--=============================================================================================->
                                       Total number of Banks
          <--=============================================================================================-->
          <span>
            Total:
            <b :class="themeData.totalnumber">{{ noData }}</b>
          </span>
          <v-spacer></v-spacer>

          <!--=============================================================================================->
                                       Search Field
          <--=============================================================================================-->
          <v-flex xs4>
            <v-text-field
              v-model="search"
              append-icon="search"
              label="Search"
              single-line
              hide-details
              :color="themeData.search"
              class="pb-2 px-4"
              @keyup="recordSearch"
            ></v-text-field>
          </v-flex>
        </v-toolbar>

        <!--===============================================================================================->
                                       Remark Data Table
        <--===============================================================================================-->
        <v-data-table
          :headers="headers"
          :items="remarks.data"
          :page.sync="page"
          hide-default-footer
          :items-per-page="15"
          class="elevation-1"
          show-expand
        >
          <template v-slot:expanded-item="{ headers, item }">
            <td></td>
            <td>
              <h5>Changed :</h5>
            </td>
          <td colspan="2">
              <div v-for="(key,value) in changeArr(item.body)" :key="value">
                <div>{{key}}</div>
              </div>
            </td>
            <td colspan="3">
              <v-simple-table dense>
                <template v-slot:default>
                  <tbody>
                    <template v-for="(key,value) in item.obj">
                    <tr  :key="value" v-if="!removeArr.includes(value)">
                      <td>{{ value }}</td>
                      <td>{{ key }}</td>
                    </tr>
                    </template>
                  </tbody>
                </template>
              </v-simple-table>
            </td>
          </template>
          <template v-slot:item.body="{ headers, item }">
            <td>{{ description(item.body) }}</td>
          </template>
          <!-- <template v-slot:item.action="{ item }">
            <div class="justify-space-around layout">
              <v-tooltip bottom v-for="action in actions" :key="action.text">
                <template v-slot:activator="{ on }">
                  <v-hover v-if="action.show">
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
          </template>-->
          <!-- =============================================================================================->
                                       When data is Empty or Loading Data
          <--=============================================================================================-->
          <template v-slot:no-data>
            <v-progress-linear v-if="!noData" :indeterminate="true"></v-progress-linear>
            <v-alert v-else :value="true" type="warning" class="text-xs-center title">No results</v-alert>
          </template>
        </v-data-table>
        <!--===============================================================================================->
                                       Custom Pagination of Data Table
        <--===============================================================================================-->
        <div class="text-xs-center pt-2 grey lighten-2">
          <v-layout>
            <v-flex xs2></v-flex>
            <v-flex xs6>
              <v-pagination v-model="page" :length="pages" :total-visible="7" color="grey darken-2"></v-pagination>
            </v-flex>
            <v-flex xs4 layout>
              <v-subheader
                v-if="remarks.meta"
              >{{ remarks.meta.from }}-{{ remarks.meta.to }} of {{ remarks.meta.total }}</v-subheader>
              <v-subheader v-if="remarks.meta">Rows per page {{ remarks.meta.per_page }}</v-subheader>
            </v-flex>
          </v-layout>
        </div>
      </v-card>
    </v-flex>
  </div>
</template>


<!--::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::-->
  
  
<script>
import { mapGetters, mapActions } from "vuex";
export default {
  data: () => ({
    search: "",
    mainCategory: "common",
    subCategory: "All",
    model: true,
    page: 1,
    removeArr:['id','deleted_at','updated_at','created_at'],
    //table headers
    headers: [
      { text: "ID", value: "id", groupable: false },
      { text: "TABLE", value: "remarkable_type", groupable: false },
      { text: "ITEM ID", value: "remarkable_id" },
      { text: "DESCRIPTION", value: "body" },
      { text: "USER", value: "user_name" },
      { text: "DATE", value: "created_at" },
      { text: "MORE", value: "data-table-expand", groupable: false }
    ],
    department: ["common"],
    common: [
      "All",
      "users",
      "navigation",
      "department",
      "user_name_prefix",
      "countries",
      "districts",
      "how_to_interacts",
      "interact_withSMNs",
      "smn_broadcastings"
    ],
    office: [
      "All",
      "users",
      "banks",
      "bill_inventory",
      "donation_methods",
      "donation_places",
      "donation_place_names",
      "donation_programs",
      "donation_records",
      "inform_types",
      "states",
      "subscriptions",
      "standing_order",
      "bill_book_project"
    ],
    ddeshana: [
      "All",
      "dd_telecast_time",
      "dd_record_time",
      "dd_deshana_category",
      "darma_deshana",
      "swaminwahansa",
      "dd_request_type",
      "sutta",
      "dd_state",
      "dd_record_location"
    ],
    charity:["All"],
    callcenter:["All"],
  }),
  created() {
    this.loader();
    this.department = this.department.concat(this.loginUser.departments)
    this.setRemarks(this.page).then(
      response => {
        this.loader();
      },
      error => {
        this.loader();
      }
    );
  },
  watch: {
    page(val) {
      this.searchRemarks({
        page: this.page,
        query: this.search,
        main: this.mainCategory,
        sub: this.subCategory
      }).then(result => {});
    }
  },
  computed: {
    ...mapGetters({
      remarks: "dashboard/getRemarks",
      loginUser: "staff/getLoginUser",
      themeData: "getTheme"
    }),
    pages() {
      if (this.remarks.meta)
        return Math.ceil(this.remarks.meta.total / this.remarks.meta.per_page);
    },
    noData() {
      if (this.remarks.meta) {
        if (this.remarks.meta.total < 10) return "0" + this.remarks.meta.total;
        else return this.remarks.meta.total;
      } else {
        return 0;
      }
    },
    filterSubCategory() {
      return this[this.mainCategory]
    }
  },
  methods: {
    ...mapActions({
      setRemarks: "dashboard/get_remarks",
      searchRemarks: "dashboard/get_search_remarks",
      loader: "set_loader"
    }),

    description(body) {
      // return body.includes("Create");
      if (body.includes("-")) {
        var arr = body.split("-");
        return arr[0];
      } else {
        return body;
      }
    },
    changeArr(body) {
      if (body.includes("-")) {
        var text = body.split("-")[1];
        var arr = text.split(",");
        return arr;
      }
      return null;
    },
    recordSearch() {
      if (this.model) {
        this.model = false;
        setTimeout(
          () =>
            this.searchRemarks({
              page: this.page,
              query: this.search,
              main: this.mainCategory,
              sub: this.subCategory
            }).then(
              response => {
                this.model = true;
              },
              error => {}
            ),
          200
        );
      }
    }
  }
};
</script>