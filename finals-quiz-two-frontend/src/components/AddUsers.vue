<template>
  <div>
    <!-- Navigation Bar -->
    <nav class="nav-bar">
    <div class="nav-container">
      <router-link class="nav-brand" to="/view-users">User Management</router-link>
      <ul class="nav-links">
          <li class="nav-item">
            <router-link class="nav-link" to="/view-products">Manage Products</router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/logout">Logout</router-link>
          </li>
        </ul>
    </div>
  </nav>
    <br>
    <br>
    <!-- Add User Form -->
    <div class="container">
      <form @submit.prevent="submitForm" class="form-container">
        <h4 class="mb-4 text-center">Register</h4>
            <div class="form-group">
              <input type="text" class="form-control" v-model="name" placeholder="Enter your Name" @input="clearErrors('name')">
              <br>
              <small class="text-danger" v-if="errors?.name">{{ errors.name[0] }}</small>
            </div>
            <div class="form-group">
              <input type="email" class="form-control" v-model="email" placeholder="Enter your Email" @input="clearErrors('email')">
              <br>
              <small class="text-danger" v-if="errors?.email">{{ errors.email[0] }}</small>
            </div>
            <div class="form-group">
              <input :type="passwordVisible ? 'text' : 'password'" class="form-control" v-model="password" placeholder="Enter your Password" @input="clearErrors('password')">
              <br>
              <small class="text-danger" v-if="errors?.password">{{ errors.password[0] }}</small>
            </div>
            <div class="form-group mb-3">
              <input :type="confirmPasswordVisible ? 'text' : 'password'" class="form-control" v-model="password_confirmation" placeholder="Confirm Password">
              <small class="text-danger" v-if="errors.password_confirmation">{{ errors.password_confirmation[0] }}</small>
            </div>
            <div class="form-group mb-3">
              <input type="checkbox" id="showPassword" v-model="passwordVisible">
              <label for="showPassword">Show Password</label>
            </div>
            <div class="form-group mb-3">
              <input type="checkbox" id="showConfirmPassword" v-model="confirmPasswordVisible">
              <label for="showConfirmPassword">Show Confirm Password</label>
            </div>
            <button type="submit" class="btn btn-primary w-100">Add User</button>
      </form>
    </div>
  </div>
</template>

<script>
import { BASE_URL } from '@/config';
import axios from 'axios';
import Swal from 'sweetalert2';

export default {
  name: 'AddUser',
  data() {
    return {
      name: '',
      email: '',
      password: '',
      password_confirmation: '',
      passwordVisible: false,
      confirmPasswordVisible: false,
      errors: {}
    };
  },
  methods: {
    clearErrors(field) {
      if (this.errors[field]) {
        this.errors[field] = null;
      }
    },
    async submitForm() {
      const token = localStorage.getItem('token');
      const formData = {
        name: this.name,
        email: this.email,
        password: this.password,
        password_confirmation: this.password_confirmation
      };

      axios.post(`${BASE_URL}/admin/users/create`, formData, {
        headers: {
          Authorization: `Bearer ${token}`
        }
      })
      .then(() => {
        Swal.fire({
          icon: 'success',
          title: 'User Added',
          text: 'User has been added successfully',
          confirmButtonText: 'OK'
        }).then(() => {
          // Optionally, clear the form or redirect to another page
          this.clearForm();
          this.$router.push({ name: 'view-users' });
        });
      })
      .catch(error => {
        if (error.response.status === 422) {
          // Validation error
          this.errors = error.response.data.errors;
        } else {
          // Other error
          console.error('Error adding user:', error);
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Failed to add user',
            confirmButtonText: 'OK'
          });
        }
      });
    },
    clearForm() {
      this.name = '';
      this.email = '';
      this.password = '';
      this.password_confirmation = '';
      this.errors = {};
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

.text-danger {
  color:red;
}
</style>
