<template>
    <nav class="nav-bar">
        <div class="nav-container">
            <router-link class="nav-brand" to="/home">Products</router-link>

        </div>
    </nav>
    <div class="container">
      <h1>Edit Users</h1>
      <form @submit.prevent="submitForm" class="post-form">
        <div class="form-group">
          <label for="name">Name:</label>
          <input type="text" class="form-control" id="name" v-model="user.name" required>
        </div>
        <div class="form-group">
          <label for="email">Email:</label>
          <input type="email" class="form-control" id="email" v-model="user.email" required>
        </div>
        <button type="submit" class="btn btn-primary">Save Changes</button>
      </form>
    </div>
</template>

<script>
import { BASE_URL } from '@/config';
import axios from 'axios';

export default {
  name: 'EditUsers',
  data() {
    return {
      user: {
        id: '',
        name: '',
        email: ''
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
      axios.get(`${BASE_URL}/users/${userId}`, {
        headers: {
          Authorization: `Bearer ${token}`
        }
      })
      .then(response => {
        this.user = response.data;
      })
      .catch(error => {
        console.error('Error fetching user data:', error);
      });
    },
    submitForm() {
      const token = localStorage.getItem('token');
      axios.put(`${BASE_URL}/users/${this.user.id}`, this.user, {
        headers: {
          Authorization: `Bearer ${token}`
        }
      })
      .then(() => {
        console.log('User updated successfully');
        // Optionally, you can redirect or perform other actions after updating the user
      })
      .catch(error => {
        console.error('Error updating user:', error);
      });
    }
  }
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
