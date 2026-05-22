<template>
  <PanelItem :index="index" :field="field" />
</template>

<script>
import axios from 'axios'
export default {
  props: ['index', 'resource', 'resourceName', 'resourceId', 'field'],

  mounted() {
    this.getTurmas()
  },

  methods: {
    getTurmas() {
      this.turma = this.field.displayedAs || this.field.value

      axios.get(`${Nova.appConfig.url}/api/turma/${this.turma}`)  
        .then(response => {
          this.field.value = response.data.data[0]?.tipo_descricao || "NÃO INFORMADO";
        })
        .catch(error => {
          console.error(error);
        });
    }
  }
}
</script>
