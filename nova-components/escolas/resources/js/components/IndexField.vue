<template>
  <span>{{ escola }}</span>
</template>

<script>
import axios from 'axios'
export default {
  props: ['resourceName', 'field'],

  data() {
    return {
      escola: null,
    }
  },


  mounted() {
    this.getEscolas()
  },
    
  methods: {
    getEscolas() {
      this.escola = this.field.displayedAs || this.field.value

      axios.get(`${Nova.appConfig.url}/api/escola/${this.escola}`)  
        .then(response => {
          this.escola = response.data.data.escola_nome;
        })
        .catch(error => {
          console.error(error);
        });
    }
  }    
}
</script>
