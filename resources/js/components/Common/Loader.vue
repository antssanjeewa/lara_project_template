<!-- 
	___________________________________________________________________________________________________________
	
															              LOADING COMPONENT
	___________________________________________________________________________________________________________
	|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||

                         ___________________________________________________________
                        |                                                           |
                        |          This component use in loading bar while          |
                        |                 some data loading                         |
                        |                                                           |
                        |___________________________________________________________|
	
-->

<template>
  <!--=====================================================================================================->
                                       Dialog loading Bar
  <--=====================================================================================================-->
  <div class="text-xs-center">
    <v-dialog v-model="dialog" hide-overlay persistent width="300">
      <v-card dark>
        <v-card-text>
          Loading ...
          <v-progress-linear indeterminate color="white" class="mb-0"></v-progress-linear>
        </v-card-text>
      </v-card>
    </v-dialog>
    <v-overlay :value="dialog" :opacity="0.9">
      <!-- <v-progress-circular indeterminate size="80" width="10"></v-progress-circular> -->
    </v-overlay>
  </div>
</template>


<!--::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::-->


<script>
import { mapGetters } from "vuex";

export default {
  data: () => ({
    message: ""
  }),
  watch: {
    messageData(val) {
      val && this.snakBarMessage(val);
    }
  },
  computed: {
    ...mapGetters({
      dialog: "getLoader",
      messageData: "getMessage"
    }),
    timer() {
      return this.messageData.type == "success" ? 1000 : 5000;
    }
  },
  methods: {
    snakBarMessage(val) {
      // Set Sweet Alert Message
      if (val.message.errors) {
        this.message = Object.values(this.messageData.message.errors)[0][0];
      } else if(val.message.message){
        this.message = val.message.message;
      } else {
        this.message = this.messageData.message;
      }
      // Sweet Alert Popup
      if (this.message && val.type) {
        this.$swal({
          icon: val.type,
          title: this.message,
          timer: this.timer
        });
      }
    }
  }
};
</script>
