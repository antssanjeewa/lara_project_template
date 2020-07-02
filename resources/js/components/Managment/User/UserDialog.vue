<!-- 
	___________________________________________________________________________________________________________
	
															      STAFF USER DIALOG FORM COMPONENT
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
                - Name -
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
                - Date of Birth -
            -->
            <v-flex xs12 md6>
              <v-menu
                v-model="menu1"
                :close-on-content-click="false"
                :nudge-right="40"
                transition="scale-transition"
                offset-y
                min-width="290px"
              >
                <template v-slot:activator="{ on, attrs }">
                  <v-text-field
                    v-model="item.birth_day"
                    prepend-icon="event"
                    label="DOB"
                    :rules="[rules.required]"
                    readonly
                    v-bind="attrs"
                    v-on="on"
                  ></v-text-field>
                </template>
                <v-date-picker v-model="item.birth_day" @input="menu1 = false" no-title></v-date-picker>
              </v-menu>
            </v-flex>
            <!--
                - Gender -
            -->
            <v-flex xs12 md6>
              <v-text-field
                v-model="item.gender"
                prepend-icon="person"
                label="Gender"
                :rules="[rules.required]"
              ></v-text-field>
            </v-flex>
            <!--
                - NIC -
            -->
            <v-flex xs12 md6>
              <v-text-field
                v-model="item.nic"
                prepend-icon="person"
                label="NIC"
                :rules="[rules.required,rules.min]"
              ></v-text-field>
            </v-flex>
            <!--
                - Mobile -
            -->
            <v-flex xs12 md6>
              <v-text-field
                v-model="item.mobile"
                prepend-icon="person"
                label="Mobile"
                :rules="[rules.required,rules.min]"
              ></v-text-field>
            </v-flex>
            <!--
                - Address -
            -->
            <v-flex xs12>
              <v-text-field v-model="item.address" prepend-icon="person" label="Address"></v-text-field>
            </v-flex>
            <!--
                - Email -
            -->
            <v-flex xs12 md6>
              <v-text-field
                v-model="item.email"
                prepend-icon="person"
                label="Email"
                :rules="[rules.required,rules.email]"
              ></v-text-field>
            </v-flex>
            <!--
                - Register Date -
            -->
            <v-flex xs12 md6>
              <v-menu
                v-model="menu2"
                :close-on-content-click="false"
                :nudge-right="40"
                transition="scale-transition"
                offset-y
                min-width="290px"
              >
                <template v-slot:activator="{ on, attrs }">
                  <v-text-field
                    v-model="item.register_date"
                    prepend-icon="event"
                    label="Register Date"
                    :rules="[rules.required]"
                    readonly
                    v-bind="attrs"
                    v-on="on"
                  ></v-text-field>
                </template>
                <v-date-picker v-model="item.register_date" @input="menu2 = false" no-title></v-date-picker>
              </v-menu>
            </v-flex>
            <!--
                - Roles -
            -->
            <v-flex xs12 md6>
              <v-autocomplete
                v-model="item.roles"
                prepend-icon="account_balance"
                name="role"
                label="Role"
                :items="asserts.roles"
                item-text="index"
                multiple
                :rules="[rules.required]"
              ></v-autocomplete>
            </v-flex>
            <!--
                - Remark Text -
            -->
            <v-flex xs12 md6 v-if="item.id">
              <v-text-field
                v-model="item.remark"
                label="Remark Text"
                type="text"
                :rules="[rules.required,rules.min]"
              ></v-text-field>
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
    width: 900,
    menu1: false,
    menu2: false,
    rules: {
      required: value => !!value || "This field is Required.",
      min: v =>
        (v && v.length >= 6) || "This must be greater than 6 characters",
      email: v => /.+@.+\..+/.test(v) || "E-mail must be valid"
    }
  }),
  watch:{
    dialog(val){
      val && this.getAsserts()
    }
  },
  computed: {
    ...mapGetters({
      dialog: "staff/getDialog",
      item: "staff/getItem",
      asserts: "staff/getAsserts",
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
      setToggleDialog: "staff/set_toggle_form",
      addNewDoner: "staff/add_new_item",
      setEditItem: "staff/set_edit_item",
      updateDoner: "staff/update_exist_item",
      getAsserts: "staff/get_asserts",
    }),

    /**
     *    Action of the SAVE and UPDATE Button
     */
    save() {
      if (this.$refs.form.validate()) {
        if (this.item.id) {
          this.updateDoner(this.item).then(
            res => {
              this.cancel();
            },
            err => {}
          );
        } else {
          this.addNewDoner(this.item).then(
            res => {
              this.cancel();
            },
            err => {}
          );
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
    }
  }
};
</script>