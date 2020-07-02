<!-- 
	___________________________________________________________________________________________________________
	
															      DONER DIALOG FORM COMPONENT
	___________________________________________________________________________________________________________
	|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
                       
		
	___________________________________________________________________________________________________________
-->

<template>
  <v-dialog v-model="dialog" persistent scrollable :width="width">
    <v-card>
      <!--=============================================================================================->
        				    				 	Dialog Form Title
      <--=============================================================================================-->
      <v-card-title :class="titleColor">
        {{title}}
        <v-spacer />
        <!--=============================================================================================->
        				    				 	Form Close Button
        <--=============================================================================================-->
        <v-btn @click="cancel" icon>
          <v-icon color="white">close</v-icon>
        </v-btn>
      </v-card-title>
      <v-card-text>
        <!--=============================================================================================->
        				    				 	Dialog Form Fields
        <--=============================================================================================-->
        <v-form ref="form" lazy-validation>
          <v-layout wrap mt-3>
            <!-- 
                  - permission name -
            -->
            <v-flex xs12>
              <v-text-field
                v-model="item.name"
                prepend-icon="person"
                type="text"
                label="Name"
                :rules="[rules.required]"
              ></v-text-field>
            </v-flex>
            <!-- 
                  - Role Permissions List -
            -->
            <v-flex xs12>
              <v-autocomplete
                v-model="item.permissions"
                prepend-icon="person"
                :search-input.sync="search"
                type="text"
                label="Name"
                :items="permissionList.data"
                item-text="name"
                item-value="id"
                multiple
                :rules="[rules.required]"
                @keyup="getPermissions()"
              ></v-autocomplete>
            </v-flex>
            <!-- 
                  - permission state -
            -->
            <v-layout v-if="item.id">
              <v-flex xs4 md2 pt-6>
                State
              </v-flex>
              <v-flex xs8>
                <v-radio-group v-model="item.state" row>
                  <v-radio label="Active" value="active"></v-radio>
                  <v-radio label="Inactive" value="inactive"></v-radio>
                </v-radio-group>
              </v-flex>
            </v-layout>
            <!-- 
                  - remark text -
            -->
             <v-flex xs12 v-if="item.id">
              <v-text-field v-model="item.remark" label="Remark Text" :rules="[rules.required]"></v-text-field>
            </v-flex>
          </v-layout>
        </v-form>
      </v-card-text>
      <!--=============================================================================================->
        				    				 	Form Action Buttons
      <--=============================================================================================-->
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn text color="warning">cancel</v-btn>
        <v-btn text color="success" @click="save">{{ item.id ? "update" : "save" }}</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
import { mapGetters, mapActions } from "vuex";

export default {
  data: () => ({
    width: 500,
    search:'',
    rules: {
      required: value => !!value || "This field is Required.",
      min: v => (v && v.length >= 6) || "This must be greater than 6 characters"
    }
  }),
  mounted(){
    this.getPermissions()
  },
  computed: {
    ...mapGetters({
      dialog: "role/getDialog",
      permissionList: "permission/getItemList",
      item: "role/getItem"
    }),
    /**
     *    Title of the Dialog
     */
    title() {
      return this.item.id ? "Update Item" : "Add New Item";
    },

    /**
     *    Title Color of the Dialog
     */
    titleColor() {
      return this.item.id ? "grey white--text" : "primary white--text";
    }
  },
  methods: {
    ...mapActions({
      setToggleDialog: "role/set_toggle_form",
      addNewRole: "role/add_new_item",
      setEditItem: "role/set_edit_item",
      updateRole: "role/update_exist_item",
      getPermissionList: "permission/get_item_list",
    }),

    /**
     *    Action of the SAVE and UPDATE Button
     */
    save() {
      if (this.$refs.form.validate()) {
        if (this.item.id) {
          this.updateRole(this.item).then(res=>{
            this.cancel()
          },err =>{

          });
        } else {
          this.addNewRole(this.item).then(res=>{
            this.cancel()
          },err =>{

          });
        }
      } else {
        this.$swal({
          toast: true,
          position: "top",
          icon: "warning",
          title: "Please Check Required Fields",
          timer: 8000,
          showConfirmButton: false
        });
      }
    },

    /**
     *    Close the Dialog
     */
    cancel() {
      this.setToggleDialog();
      setTimeout(() => this.clear(), 500);
    },

    /**
     *    Clear the Dialog Form Value
     */
    clear() {
      this.setEditItem(null);
      this.$refs.form.resetValidation();
    },
    getPermissions(){
      this.getPermissionList({page:1, query:this.search})
    }
  }
};
</script>