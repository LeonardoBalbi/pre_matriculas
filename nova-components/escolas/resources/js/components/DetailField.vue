<template>
  <PanelItem :index="index" :field="field" />
</template>

<script>
import axios from 'axios'
export default {
  props: ['index', 'resource', 'resourceName', 'resourceId', 'field'],

  mounted() {
    this.getEscolas()
  },

  methods: {
    getEscolas() {
      axios.get(`${Nova.appConfig.url}/api/escola/${this.field.value}`)  
        .then(response => {
          this.field.value = response.data.data.escola_nome;
        })
        .catch(error => {
          console.error(error);
        });
    }
  }

  
}
</script>
