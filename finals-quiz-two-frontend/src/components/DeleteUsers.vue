<template>
  <nav class="nav-bar">
    <div class="nav-container">
      <router-link class="nav-brand" to="/view-users">Users</router-link>
    </div>
  </nav>
  <div class="container">
    <form @submit.prevent="submitForm" class="form-container">
      <div class="form-group">
        <h2 class="form-heading">Delete User</h2>
        <label for="userId">User ID:</label>
        <input type="text" class="form-control" id="userId" v-model="userId" required>
      </div>
      <button type="submit" class="btn btn-primary btn-block">Delete User</button>
    </form>
  </div>
</template>

<script>
import { BASE_URL } from '@/config';
import axios from 'axios';
import Swal from 'sweetalert2';

export default {
  name: 'DeleteUser',
  data() {
    return {
      userId: ''  // Field to capture the user ID to be deleted
    };
  },
  methods: {
    submitForm() {
      const token = localStorage.getItem('token');

      // Display a confirmation dialog using SweetAlert2
      Swal.fire({
        title: 'Are you sure?',
        text: 'You will not be able to recover this user!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          axios.delete(`${BASE_URL}/users/${this.userId}`, {
            headers: {
              Authorization: `Bearer ${token}`
            }
          })
          .then(response => {
            console.log('User deleted successfully:', response.data);
            Swal.fire('Deleted!', 'The user has been deleted.', 'success');
            // Optionally, you can clear the form or redirect to another page
            this.userId = '';
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
