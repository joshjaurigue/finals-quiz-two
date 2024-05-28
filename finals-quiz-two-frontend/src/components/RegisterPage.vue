<template>
  <div>
    <!-- Navigation Bar -->
    <nav class="nav-bar">
      <div class="nav-container">
        <router-link class="nav-brand" to="/">E-Commerce Shop</router-link>
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

    <div class="container mt-5 mx-auto">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <form @submit.prevent="registerUser">
            <h4 class="mb-4">Register</h4>
            <div class="form-group">
              <input type="text" class="form-control" v-model="name" placeholder="Enter your Name" @input="clearErrors">
              <small class="text-danger" v-if="errors?.name">{{ errors.name[0] }}</small>
            </div>
            <div class="form-group">
              <input type="email" class="form-control" v-model="email" placeholder="Enter your Email" @input="clearErrors">
              <small class="text-danger" v-if="errors?.email">{{ errors.email[0] }}</small>
            </div>
            <div class="form-group">
              <input :type="passwordVisible ? 'text' : 'password'" class="form-control" v-model="password" placeholder="Enter your Password" @input="clearErrors">
              <small class="text-danger" v-if="errors?.password">{{ errors.password[0] }}</small>
            </div>
            <div class="form-group form-check">
              <input type="checkbox" id="showPassword" v-model="passwordVisible" class="form-check-input">
              <label for="showPassword" class="form-check-label">Show Password</label>
            </div>
            <button type="submit" class="btn btn-primary w-100">Register</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
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
        console.log('Registering user...');
        const response = await axios.post(`${process.env.VUE_APP_BASE_URL}/register`, {
          name: this.name,
          email: this.email,
          password: this.password,
          password_confirmation: this.password
        });
        console.log('Registration response:', response);
        if (response.status === 201) {
          this.clearForm();
          alert('Registration successful');
          this.$router.push({ name: 'login' }); // Redirect to login page after successful registration
        }
      } catch (error) {
        console.error('Registration error:', error);
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
  padding: 20px;
}

.table-striped {
  width: 100%;
  border-collapse: collapse;
}

.table-striped th, .table-striped td {
  border: 1px solid #ddd;
  padding: 8px;
}

.table-striped tr:nth-child(even) {
  background-color: #f2f2f2;
}

.table-striped th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #4CAF50;
  color: white;
}

.btn-primary {
  background-color: #007bff;
  color: white;
  border: none;
  padding: 10px 20px;
  text-decoration: none;
}

.btn-secondary {
  background-color: #6c757d;
  color: white;
  border: none;
  padding: 10px 20px;
  text-decoration: none;
}

.btn-danger {
  background-color: #dc3545;
  color: white;
  border: none;
  padding: 10px 20px;
  text-decoration: none;
}

.btn-sm {
  font-size: 0.875rem;
  padding: 5px 10px;
}

.mr-2 {
  margin-right: 0.5rem;
}
</style>

