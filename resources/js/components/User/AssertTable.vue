<template>
  <v-card>
    <v-card-title>Assert Table</v-card-title>
    <v-card-text>
      <v-data-table :headers="headers"></v-data-table>
    </v-card-text>
  </v-card>
</template>

<script>
export default {
    data:()=>({
        headers:[
            {text:'name', value:'name'}
        ]
})
}
</script>

<style>
</style>