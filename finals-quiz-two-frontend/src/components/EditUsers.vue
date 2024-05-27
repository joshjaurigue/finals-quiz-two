<template>
    <nav class="nav-bar">
        <div class="nav-container">
            <router-link class="nav-brand" to="/home">Products</router-link>

        </div>
    </nav>
    <br>
    <br>
    <div class="container">
        <h1>Edit Users</h1>
        
    </div>
</template>

<script>
export default {
  name: 'EditUsers'
};
</script>

<style scoped>
.container {
    margin-top: 20px;
}

.post-form {
    max-width: 500px;
    margin: 0 auto;
}

.form-group {
    margin-bottom: 20px;
}

label {
    font-weight: bold;
}

.btn-primary {
    background-color: #007bff;
    color: #fff;
    border: none;
}

.btn-primary:hover {
    background-color: #0056b3;
}

.nav-brand {
    font-size: 1.2em;
    color: #007bff;
    text-decoration: none;
}

.nav-brand:hover {
    text-decoration: underline;
}

.nav-bar {
    background-color: #4c4d4e;
    /* Changed to a blue color */
    padding: 1em 2em;
    border-bottom: 2px solid #141414;
    border-top: 2px solid #141414;
}

.nav-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.nav-brand {
    font-size: 1.5em;
    font-weight: bold;
    color: #ffffff;
    text-decoration: none;
}

.nav-links {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    gap: 1em;
}

.nav-link {
    text-decoration: none;
    color: #ffffff;
}

.nav-link:hover {
    text-decoration: underline;
}
</style>
