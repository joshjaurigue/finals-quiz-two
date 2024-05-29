<template>
    <nav class="nav-bar">
        <div class="nav-container">
            <router-link class="nav-brand" to="/home">Products</router-link>

        </div>
    </nav>
    <div class="container">
      <h1>Delete Users</h1>
      <ul>
        <li v-for="user in users" :key="user.id">
          <span>{{ user.name }}</span>
          <button @click="deleteUser(user.id)" class="btn btn-danger">Delete</button>
        </li>
      </ul>
    </div>
</template>

<script>
import { BASE_URL } from '@/config';
import axios from 'axios';

export default {
  name: 'DeleteUsers',
  data() {
    return {
      users: [] // Store fetched users
    };
  },
  created() {
    this.fetchUsers();
  },
  methods: {
    fetchUsers() {
      const token = localStorage.getItem('token');
      axios.get(`${BASE_URL}/users`, {
        headers: {
          Authorization: `Bearer ${token}`
        }
      })
      .then(response => {
        this.users = response.data;
      })
      .catch(error => {
        console.error('Error fetching users:', error);
      });
    },
    deleteUser(userId) {
      const token = localStorage.getItem('token');
      axios.delete(`${BASE_URL}/users/${userId}`, {
        headers: {
          Authorization: `Bearer ${token}`
        }
      })
      .then(() => {
        // Remove the deleted user from the list
        this.users = this.users.filter(user => user.id !== userId);
        console.log('User deleted successfully');
      })
      .catch(error => {
        console.error('Error deleting user:', error);
      });
    }
  }
};
</script>

<style scoped>
.container {
    margin-top: 20px;
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

.nav-brand:hover {
  text-decoration: underline;
}

.btn-danger {
  background-color: #dc3545;
  color: #fff;
  border: none;
  padding: 6px 12px;
  border-radius: 4px;
  cursor: pointer;
}

.btn-danger:hover {
  background-color: #c82333;
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
