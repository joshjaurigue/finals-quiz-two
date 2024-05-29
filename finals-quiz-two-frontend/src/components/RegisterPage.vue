<template>
  <div>
    <!-- Navigation Bar -->
    <nav class="nav-bar">
      <div class="nav-container">
        <router-link class="nav-brand" to="/">E-Commerce Shop</router-link>
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
              <small class="text-danger" v-if="errors?.name">{{ errors.name[0] }}</small>
            </div>
            <div class="form-group">
              <input type="email" class="form-control" v-model="email" placeholder="Enter your Email" @input="clearErrors('email')">
              <small class="text-danger" v-if="errors?.email">{{ errors.email[0] }}</small>
            </div>
            <div class="form-group">
              <input :type="passwordVisible ? 'text' : 'password'" class="form-control" v-model="password" placeholder="Enter your Password" @input="clearErrors('password')">
              <small class="text-danger" v-if="errors?.password">{{ errors.password[0] }}</small>
            </div>
            <div class="form-group form-check">
              <input type="checkbox" id="showPassword" v-model="passwordVisible" class="form-check-input">
              <label for="showPassword" class="form-check-label">Show Password</label>
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
import axios from 'axios';

export default {
  name: 'RegisterPage',
  data() {
    return {
      name: '',
      email: '',
      password: '',
      passwordVisible: false,
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
        const response = await axios.post(`${process.env.VUE_APP_BASE_URL}/register`, {
          name: this.name,
          email: this.email,
          password: this.password,
          password_confirmation: this.password
        });
        if (response.status === 201) {
          this.clearForm();
          alert('Registration successful');
          this.$router.push({ name: 'login' }); // Redirect to login page after successful registration
        }
      } catch (error) {
        if (error.response && error.response.data && error.response.data.errors) {
          this.errors = error.response.data.errors;
        } else {
          console.error('An unexpected error occurred:', error);
        }
      }
    },
    clearForm() {
      this.name = '';
      this.email = '';
      this.password = '';
      this.errors = {}; // Clear errors after successful registration
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
  padding: 1em 2em;
  border-bottom: 2px solid #212529;
}

.nav-container {
  display: flex;
  justify-content: space-between;
  align-items: center;
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
  gap: 1em;
  margin-left: auto; 
}

.nav-item {

}

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
</style>
