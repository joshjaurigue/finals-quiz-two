<template>
    <nav class="nav-bar">
        <div class="nav-container">
            <router-link class="nav-brand" to="/home">Products</router-link>

        </div>
    </nav>
    <div class="container">
      <h1>Add Users</h1>
      <form @submit.prevent="submitForm" class="form-container">
        <div class="form-group">
          <label for="name">Name:</label>
          <input type="text" class="form-control" id="name" v-model="name" required>
        </div>
        <div class="form-group">
          <label for="email">Email:</label>
          <input type="email" class="form-control" id="email" v-model="email" required>
        </div>
        <div class="form-group">
          <label for="password">Password:</label>
          <input type="password" class="form-control" id="password" v-model="password" required>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Add User</button>
      </form>
    </div>
</template>

<script>
import { BASE_URL } from '@/config';
import axios from 'axios';

export default {
  name: 'AddUsers',
  data() {
    return {
      name: '',
      email: '',
      password: ''
    };
  },
  methods: {
    submitForm() {
      const token = localStorage.getItem('token');
      const formData = {
        name: this.name,
        email: this.email,
        password: this.password
      };

      axios.post(`${BASE_URL}/users`, formData, {
        headers: {
          Authorization: `Bearer ${token}`
        }
      })
      .then(response => {
        console.log('User added successfully:', response.data);
        // Optionally, you can reset the form or redirect the user
        this.name = '';
        this.email = '';
        this.password = '';
      })
      .catch(error => {
        console.error('Error adding user:', error);
      });
    }
  }
};
</script>

<style scoped>
.container {
    margin-top: 20px;
}

.form-container {
  max-width: 400px;
  padding: 30px;
  border-radius: 8px;
  background-color: #f7f7f7;
  box-shadow: 0px 0px 20px 0px rgba(0,0,0,0.1);
  margin: 0 auto;
}

.form-heading {
  text-align: center;
  margin-bottom: 20px;
  color: #333;
}

.form-group {
  margin-bottom: 20px;
}

.form-control {
  width: 100%;
  padding: 10px;
  font-size: 1em;
  border: 1px solid #ccc;
  border-radius: 4px;
}

.btn-primary {
  background-color: #007bff;
  color: #fff;
  border: none;
  padding: 12px;
  border-radius: 4px;
  cursor: pointer;
}

.btn-primary:hover {
  background-color: #0056b3;
}

.btn-block {
  display: block;
  width: 100%;
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
