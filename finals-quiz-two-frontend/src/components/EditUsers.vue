<template>
  <!-- Navigation Bar -->
  <nav class="nav-bar">
    <div class="nav-container">
      <router-link class="nav-brand" to="/view-users">User Management</router-link>
      <ul class="nav-links">
          <li class="nav-item">
            <router-link class="nav-link" to="/view-products">Manage Products</router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/view-users">Manage User</router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/logout">Logout</router-link>
          </li>
        </ul>
    </div>
  </nav>
    <br>
    <br>
    <div class="container">
      <form @submit.prevent="submitForm" class="post-form">
        <div class="form-group">
          <h1>Edit Users</h1>
          <label for="name">Name:</label>
          <input type="text" class="form-control" id="name" v-model="user.name" >
        </div>
        <div class="form-group">
          <label for="email">Email:</label>
          <input type="email" class="form-control" id="email" v-model="user.email">
        </div>
        <div class="form-group">
          <label for="isAdmin">Admin:</label>
          <input type="checkbox" id="isAdmin" v-model="user.is_admin">
        </div>
        <button type="submit" class="btn btn-primary">Save Changes</button>
      </form>
    </div>
</template>

<script>
import { BASE_URL } from '@/config';
import axios from 'axios';
import Swal from 'sweetalert2';

export default {
  name: 'EditUsers',
  data() {
    return {
      user: {
        id: '',
        name: '',
        email: '',
        is_admin: ''
      }
    };
  },
  created() {
    const userId = this.$route.params.id; // Get the user ID from the route params
    this.fetchUserData(userId);
  },
  methods: {
    fetchUserData(userId) {
      const token = localStorage.getItem('token');
      axios.get(`${BASE_URL}/admin/users/details/${userId}`, {
        headers: {
          Authorization: `Bearer ${token}`
        }
      })
      .then(response => {
        this.user = response.data;
        this.user.is_admin = response.data.is_admin;
      })
      .catch(error => {
        console.error('Error fetching user data:', error);
      });
    },
    submitForm() {
      const userId = this.$route.params.id; 
      const token = localStorage.getItem('token');
      axios.put(`${BASE_URL}/admin/users/edit/${userId}`, {
        name: this.user.name,
        email: this.user.email,
        is_admin: this.user.is_admin 
      }, {
        headers: {
          Authorization: `Bearer ${token}`
        }
      })
      .then(() => {
        Swal.fire({
          icon: 'success',
          title: 'User Updated',
          text: 'User information has been updated successfully.',
          confirmButtonText: 'OK'
        }).then(() => {
          this.$router.push({ name: 'view-users' });
        });
      })
      .catch(error => {
        console.error('Error updating user:', error);
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Failed to update user information. Please try again.',
          confirmButtonText: 'OK'
        });
      });
    }

  }
};
</script>

<style scoped>
.container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: calc(100vh - 120px); /* Adjust the height to ensure it fits within the viewport minus the navbar */
  margin-top: 20px;
}

.form-container {
  max-width: 400px;
  padding: 30px;
  border-radius: 8px;
  background-color: #f7f7f7;
  box-shadow: 0px 0px 20px 0px rgba(0,0,0,0.1);
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

.input-group {
  width: 100%;
}

.input-group-text {
  background-color: #007bff;
  color: #fff;
  border: none;
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
