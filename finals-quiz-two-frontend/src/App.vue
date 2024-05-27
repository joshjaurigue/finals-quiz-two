<template>
  <div id="app">
    <nav>
      <router-link to="/">Home</router-link>
      <router-link to="/login">Login</router-link>
      <router-link to="/register">Register</router-link>
    </nav>
    <router-view/>
  </div>
</template>

<script>
export default {
  name: 'App'
};
</script>

<style>

nav {
  display: flex;
  gap: 1rem;
  background-color: #f8f9fa;
  padding: 1rem;
}
nav a {
  text-decoration: none;
  color: #007bff;
}
nav a:hover {
  text-decoration: underline;
}
</style>