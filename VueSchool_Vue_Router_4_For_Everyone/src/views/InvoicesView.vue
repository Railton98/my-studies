<script setup>
import { onBeforeRouteLeave } from 'vue-router'

onBeforeRouteLeave(() => {
  const answer = window.confirm('Are you sure you want to leave? Invoices are super awesome!')

  if (!answer) return false
})
</script>

<template>
  <div>
    <h1>Invoices</h1>
  </div>
</template>
