<template>
  <span>{{ fieldValue }}</span>
</template>

<script>
export default {
  props: ['resourceName', 'field'],

  methods:{
    getFieldValue(field) {
      console.log(field);
    },
  },

  computed: {
    fieldValue() {
      return this.field.displayedAs || this.field.value
    },
  },

  mounted() {
    this.getFieldValue(this.field);
  },
  
}
</script>
