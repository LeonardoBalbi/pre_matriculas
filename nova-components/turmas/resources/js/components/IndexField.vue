<template>
  <span>{{ turma }}</span>
</template>

<script>
import axios from 'axios'
export default {
  props: ['resourceName', 'field'],

  data() {
    return {
      turma: null,
    }
  },

  mounted() {
    this.getTurmas()
  },

  methods: {
    getTurmas() {
      this.turma = this.field.displayedAs || this.field.value
      // console.log('Turma:', this.turma);

      axios.get(`${Nova.appConfig.url}/api/turma/${this.turma}`)  
        .then(response => {
          this.turma = response.data.data[0]?.tipo_descricao || "NÃO INFORMADO";
        })
        .catch(error => {
          console.error(error);
        });
    }
  }
}
</script>
