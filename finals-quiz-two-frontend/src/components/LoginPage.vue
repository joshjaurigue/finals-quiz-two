<template>
  <div>
    <!-- Navigation Bar -->
    <nav class="nav-bar">
      <div class="nav-container">
        <router-link class="nav-brand" to="/">E-Commerce Shop</router-link>
      </div>
    </nav>

    <!-- Login Form -->
    <div class="container mt-5 mx-auto">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <form @submit.prevent="loginUser">
            <h4 class="mb-4 text-center">Login</h4>
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
            <button type="submit" class="btn btn-primary w-100">Login</button>
          </form>
          <p class="mt-3">Don't have an account? <router-link to="/register">Register here!</router-link></p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
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
        const response = await axios.post('/login', {
          email: this.email,
          password: this.password
        });
        // Use response variable here
        console.log(response.data); // For example, log the response data

        // Display success message using SweetAlert2
        Swal.fire({
          icon: 'success',
          title: 'Login Successful!',
          text: 'Welcome to E-Commerce Shop!',
          confirmButtonText: 'OK'
        }).then(() => {
          // Redirect to ViewProducts.vue
          this.$router.push('/view-products');
        });
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
  margin-left: auto; 
  gap: 2em; 
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
</style>

