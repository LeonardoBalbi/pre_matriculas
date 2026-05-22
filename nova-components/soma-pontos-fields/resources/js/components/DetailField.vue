<template>
  <PanelItem :index="index" :field="field" />
  {{ resourceId }}
</template>

<script>
export default {
  props: ['index', 'resource', 'resourceName', 'resourceId', 'field'],
}
</script>
