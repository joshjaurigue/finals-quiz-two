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

    <!-- Login Form -->
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <form @submit.prevent="loginUser">
            <h4 class="mb-4 text-center">Login</h4>
            <div class="form-group">
              <input type="email" class="form-control" v-model="email" placeholder="Enter your Email" @input="clearErrors">
              <br>
              <small class="text-danger" v-if="errors?.email">{{ errors.email[0] }}</small>
            </div>
            <div class="form-group">
              <input :type="passwordVisible ? 'text' : 'password'" class="form-control" v-model="password" placeholder="Enter your Password" @input="clearErrors">
              <br>
              <small class="text-danger" v-if="errors?.password">{{ errors.password[0] }}</small>
            </div>
            <div class="form-group form-check">
              <input type="checkbox" id="showPassword" v-model="passwordVisible" class="form-check-input">
              <label for="showPassword" class="form-check-label">Show Password</label>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
          </form>
          <p class="mt-3">Don't have an account? <router-link to="/register">Register here!</router-link></p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { BASE_URL } from '@/config';
import axios from 'axios'; // Import Axios
import Swal from 'sweetalert2'; // Import SweetAlert2

export default {
  name: 'LoginPage',
  data() {
    return {
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
    async loginUser() {
      try {
        const response = await axios.post(`${BASE_URL}/login`, {
          email: this.email,
          password: this.password
        });
        if (response.status === 201) {
          // Successful login, handle token storage and redirection
          const { token, user } = response.data;
          localStorage.setItem('token', token);
          localStorage.setItem('user', JSON.stringify(user));
          Swal.fire({
            icon: 'success',
            title: 'Login Successful!',
            text: 'You will be redirected shortly.',
            timer: 2000,
            timerProgressBar: true,
            showConfirmButton: false
          });
          setTimeout(() => {
            this.$router.push('/view-products');
          }, 2000);
        }
      } catch (error) {
        // Handle error case here
        console.error('Error logging in:', error);
        // Display error message using SweetAlert2
        Swal.fire({
          icon: 'error',
          title: 'Login Failed!',
          text: 'Please check your credentials and try again.',
          confirmButtonText: 'OK'
        });
      }
    }
  }
};
</script>


<style scoped>
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
.container {
  margin-top: 5em;
  display: flex;
  justify-content: center;
}

.form-group {
  margin-bottom: 1em; /* Add margin between form groups */
}

.form-control {
  border: 1px solid #CED4DA; /* Gray border color */
  font-size: 1.2em; /* Enlarge text field font size */
  padding: 0.5em; /* Adjust padding */
}

.form-control:focus {
  border-color: #6C757D; /* Dark gray border color on focus */
  box-shadow: none;
}

.btn-primary {
  background-color: #007BFF; /* Blue color for buttons */
  border-color: #007BFF;
  font-size: 1.2em; /* Enlarge button font size */
  padding: 0.5em 2em; /* Adjust button padding */
}

.btn-primary:hover {
  background-color: #0056b3; /* Darker blue color on hover */
}

.text-danger {
  color: red;
}
</style>

