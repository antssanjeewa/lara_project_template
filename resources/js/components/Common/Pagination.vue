<template>
  <div class="text-xs-center pt-2 grey lighten-2">
    <v-layout>
      <v-flex xs2></v-flex>
      <v-flex xs6>
        <slot />
      </v-flex>
      <v-flex xs4 layout>
        <v-subheader v-if="meta">
          {{ meta.from }}-{{ meta.to }} of
          {{ meta.total }}
        </v-subheader>
        <v-subheader v-if="meta">Rows per page {{ meta.per_page }}</v-subheader>
      </v-flex>
    </v-layout>
  </div>
</template>

<script>
export default {
  name:"pagination",
  props: {
    meta: {
      type: Object
    }
  }
};
</script>