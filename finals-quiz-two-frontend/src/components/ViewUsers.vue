<template>
    <nav class="nav-bar">
  <div class="nav-container">
    <router-link class="nav-brand" to="/view-users">User Management</router-link>
  </div>
  <div class="nav-container">
    <ul class="nav-links">
      <li class="nav-item">
        <router-link class="nav-link" to="/view-products">Manage Product</router-link>
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
    <router-link to="/add-users" class="btn btn-primary">Add New User</router-link>
    <br>
    <br>
  <div class="container">
    <h1>View Users</h1>
    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="user in users" :key="user.id">
          <td>{{ user.id }}</td>
          <td>{{ user.name }}</td>
          <td>{{ user.email }}</td>
          <td>
        
            <router-link :to="{ name: 'edit-users', params: { id: user.id } }"
                class="btn btn-secondary mr-2">
                <button class="btn btn-warning">Edit</button></router-link>
            <button @click="deleteUser(user.id)" class="btn btn-danger">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import { BASE_URL } from '@/config';
import axios from 'axios';
import Swal from 'sweetalert2';

export default {
  name: 'ViewUsers',
  data() {
    return {
      users: []  // Store users data
    };
  },
  created() {
    this.fetchUsers();
  },
  methods: {
    fetchUsers() {
      const token = localStorage.getItem('token');
      axios.get(`${BASE_URL}/admin/users`, {
        headers: {
          Authorization: `Bearer ${token}`
        }
      })
      .then(response => {
        this.users = response.data.users;
      
      })
      .catch(error => {
        console.error('Error fetching users:', error);
      });
    },
    editUser(userId) {
      this.$router.push({ name: 'EditUser', params: { id: userId } });
    },
    deleteUser(userId) {
      const token = localStorage.getItem('token');
      // Display a confirmation dialog using SweetAlert2
      Swal.fire({
        title: 'Are you sure?',
        text: 'You will not be able to recover the user!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          axios.delete(`${BASE_URL}/admin/users/delete/${userId}`, {
            headers: {
              Authorization: `Bearer ${token}`
            }
          })
          .then(response => {
            console.log('User deleted successfully:', response.data);
            Swal.fire('Deleted!', 'Selected user has been deleted.', 'success');
            this.fetchUsers();
          })
          .catch(error => {
            console.error('Error deleting user:', error);
            Swal.fire('Error!', 'Failed to delete user.', 'error');
          });
        }
      });
     
    }
  }
};
</script>

<style scoped>
.container {
  margin-top: 20px;
}

.table {
  width: 100%;
  border-collapse: collapse;
  margin: 20px 0;
  font-size: 18px;
  text-align: left;
}

.table th, .table td {
  padding: 12px 15px;
  border: 1px solid #ddd;
}

.table th {
  background-color: #f2f2f2;
}

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

.btn {
  padding: 5px 10px;
  font-size: 14px;
  cursor: pointer;
  border: none;
  border-radius: 3px;
}

.btn-primary {
  background-color: #007bff;
  color: white;
  border: none;
  padding: 10px 20px;
  text-decoration: none;
}

.btn-warning {
  background-color: #ffc107;
  color: #fff;
}

.btn-warning:hover {
  background-color: #e0a800;
}

.btn-danger {
  background-color: #dc3545;
  color: #fff;
}

.btn-danger:hover {
  background-color: #c82333;
}
</style>
