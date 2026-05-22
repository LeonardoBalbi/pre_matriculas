<template>
  <DefaultField :field="field" :errors="errors" :show-help-text="showHelpText" :full-width-content="fullWidthContent">
    <template #field>

      <select :id="field.attribute" class="w-full form-control form-input form-input-bordered" :class="errorClasses"
        v-model="value">
        <option value="">Selecione uma turma</option>
        <option v-for="turma in turmas" :key="turma.id" :value="turma.id">{{ turma.tipo_descricao }}</option>
      </select>

    </template>
  </DefaultField>
</template>

<script>
import { FormField, HandlesValidationErrors } from 'laravel-nova'
import axios from 'axios'

export default {
  mixins: [FormField, HandlesValidationErrors],

  props: ['resourceName', 'resourceId', 'field'],

  emits: [],

  data() {
    return {
      turmas: null,
      escolaId: null,
    }
  },

  mounted() {
    Nova.$on('escola-changed', this.atualizarTurmas);
    this.setInitialValue()
    this.getTurmas()
  },

  methods: {
    atualizarTurmas(id, tipo = false) {
      //Se o tipo false, então é escola, se true, então é tipo de turma
      this.escolaId = id;
      console.log('Evento Escola Alterada Recebido:', id);
      console.log('Tipo:', tipo)
      

      if(tipo == false) {
        axios.get(`${Nova.appConfig.url}/api/turma/${this.turma}`)  
        .then(response => {
          this.turmas= response.data.data[0]?.tipo_descricao || "NÃO INFORMADO";
        })
        .catch(error => {
          console.error(error);
        });
      }else{
        axios.get(`${Nova.appConfig.url}/api/turmas/${id}`)  
        .then(response => {
          this.turmas= response.data.data;
        })
        .catch(error => {
          console.error(error);
        });
      }
    },

    /*
     * Set the initial, internal value for the field.
     */
    setInitialValue() {
      this.value = this.field.value || ''
    },

    /**
     * Fill the given FormData object with the field's internal value.
     */
    fill(formData) {
      formData.append(this.field.attribute, this.value || '')
    },

    getTurmas() {
      axios.get(`${Nova.appConfig.url}/api/turma_form/${this.value}`)  
        .then(response => {
          this.turmas = response.data.data;
          console.log('Turmas:', this.turmas);
        })
        .catch(error => {
          console.error(error);
        });
    }
  },

  destroyed() {
    Nova.$off('escola-changed', this.atualizarTurmas);
  },
}
</script>
