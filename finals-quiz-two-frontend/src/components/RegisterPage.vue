<template>
  <div>
     <!-- Navigation Bar -->
     <nav class="nav-bar">
  <div class="nav-container">
    <router-link class="nav-brand" to="/">E-Commerce Shop</router-link>
  </div>
  <div class="nav-container">
    <ul class="nav-links">
      <li class="nav-item">
        <router-link class="nav-link" to="/">Login</router-link>
      </li>
      <li class="nav-item">
        <router-link class="nav-link" to="/register">Register</router-link>
      </li>
    </ul>
  </div>
</nav>
    <!-- Registration Form -->
    <div class="container mt-5 mx-auto">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <form @submit.prevent="registerUser" class="registration-form p-4 shadow">
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
            <button type="submit" class="btn btn-primary w-100">Register</button>
          </form>
          <p class="mt-3">Already have an account? <router-link to="/">Login here!</router-link></p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { BASE_URL } from '@/config';
import axios from 'axios';
import Swal from 'sweetalert2';

export default {
  name: 'RegisterPage',
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
    async registerUser() {
      try {
        const response = await axios.post(`${BASE_URL}/register`, {
          name: this.name,
          email: this.email,
          password: this.password,
          password_confirmation: this.password_confirmation
        });
        if (response.status === 201) {
          this.clearForm();
          Swal.fire({
            icon: 'success',
            title: 'Registration Successful!',
            text: 'You have successfully registered.',
            confirmButtonText: 'OK'
          }).then(() => {
            this.$router.push({ name: 'login' });
          });
        }
      } catch (error) {
        if (error.response && error.response.data && error.response.data.errors) {
          this.errors = error.response.data.errors;
          Swal.fire({
            icon: 'error',
            title: 'Registration Failed',
            text: 'Please check your input and try again.',
            confirmButtonText: 'OK'
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Registration Failed',
            text: 'Please check your credentials and try again.',
            confirmButtonText: 'OK'
          });
          console.error('An unexpected error occurred:', error);
        }
      }
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
  margin-top: 5em;
  display: flex;
  justify-content: center;
}

/* Navigation bar styling */
.nav-bar {
  background-color: #343a40;
  padding-top: 1em;
  padding-bottom: 1em;
  border-bottom: 2px solid #212529;
  display: flex;
  justify-content: space-between; /* Align items to the start and end of the nav-bar */
}

.nav-container {
  display: flex;
  align-items: center; /* Align items vertically */
}

.nav-brand {
  font-size: 1.5em;
  font-weight: bold;
  color: #fff;
}

.nav-links {
  list-style: none;
  padding: 0;
  margin: 0;
  display: flex;
  gap: 2em;
}

.nav-item {}

.nav-link {
  text-decoration: none;
  color: #fff;
  padding: 0.5em 1em;
  border-radius: 5px;
}

.nav-link:hover {
  background-color: #495057;
}
/* Form Styles */
.registration-form {
  background-color: #fff;
  border-radius: 5px;
  padding: 2em;
}

.form-group {
  margin-bottom: 1em; 
}

.form-control {
  border: 1px solid #CED4DA; 
  font-size: 1.2em; 
  padding: 0.5em; 
}

.form-control:focus {
  border-color: #6C757D; 
  box-shadow: none;
}

.btn-primary {
  background-color: #007BFF; 
  border-color: #007BFF;
  font-size: 1.2em;
  padding: 0.5em 2em;
}

.btn-primary:hover {
  background-color: #0056b3; 
}

.mt-5 {
  margin-top: 5em;
}

.mx-auto {
  margin-left: auto;
  margin-right: auto;
}

.text-center {
  text-align: center;
}
.text-danger {
  color:red;
}
</style>
