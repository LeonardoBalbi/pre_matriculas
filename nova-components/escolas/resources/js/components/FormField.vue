<template>
  <DefaultField
    :field="field"
    :errors="errors"
    :show-help-text="showHelpText"
    :full-width-content="fullWidthContent"
  >
    <template #field>

    <select
      :id="field.attribute"
      class="w-full form-control form-input form-input-bordered"
      :class="errorClasses"
      v-model="value"
    >
      <option value="">Selecione</option>
      <option v-for="escola in escolas" :key="escola.id" :value="escola.id" >{{ escola.escola_nome }}</option>
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

  data() {
    return {
      escolas: null,
    }
  },


  mounted() {
    this.setInitialValue()
    this.getEscolas()   
  },

  watch: {

    value(newValue) {
      Nova.$emit('escola-changed', newValue, true);
      console.log('Emitindo evento escola-changed com valor:', newValue);
    }
  },

  methods: {

    setInitialValue() {
      this.value = this.field.value || '';
    },

    fill(formData) {
      formData.append(this.field.attribute, this.value || '')
    },

    getEscolas() {
      axios.get(`${Nova.appConfig.url}/api/escolas`)  
        .then(response => {
          this.escolas = response.data.data;
        })
        .catch(error => {
          console.error(error);
        });
    },
  
  },
}
</script>

  



