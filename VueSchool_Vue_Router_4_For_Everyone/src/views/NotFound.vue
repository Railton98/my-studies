<template>
  <div>
    <h1>Not Found</h1>
    <p>Oops, we couldn't find that page. Try going</p>
    <RouterLink :to="{ name: 'home' }">home</RouterLink>
  </div>
</template>
