<template>
  <div class="container">
    <nav class="nav-bar">
  <div class="nav-container">
    <router-link class="nav-brand" to="/view-products">Product Management</router-link>
  </div>
  <div class="nav-container">
    <ul class="nav-links">
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
    <router-link to="/add-products" class="btn btn-primary">Add New Product</router-link>
    <br>
    <br>
    <table class="table-striped">
      <thead>
        <tr>
          <th width="30%">Product Name</th>
          <th width="30%">Description</th>
          <th width="20%">Price</th>
          <th width="20%">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="product in products" :key="product.id">
          <td>{{ product.product_name }}</td>
          <td>{{ product.product_description }}</td>
          <td>{{ product.product_price }}</td>
          <td>
            <router-link :to="{ name: 'edit-product', params: { id:product.id } }" class="btn btn-secondary mr-2 btn-sm">Edit</router-link>
            <button @click="confirmDeleteProduct(product.id)" class="btn btn-danger btn-sm">Delete</button>
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
  name: 'ViewProduct',
  data() {
    return {
      products: [],
    };
  },
  created() {
    this.fetchProducts();
  },
  methods: {
    fetchProducts() {
      const token = localStorage.getItem('token');
      if (!token) {
        // Handle case where token is not available
        return;
      }

      axios.get(`${BASE_URL}/products`, {
        headers: {
          Authorization: `Bearer ${token}`
        }
      })
      .then(response => {
        console.log('API Response:', response.data.products);
        this.products = response.data.products;
        console.log('Assigned Products:', this.products);
      })
      .catch(error => {
        console.error("There was an error fetching the products:", error);
      });
    },
    confirmDeleteProduct(productId) {
      Swal.fire({
        title: 'Are you sure ?',
        text: "You will not be able to recover this product!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          this.deleteProduct(productId);
        }
      });
    },
    deleteProduct(productId) {
      const token = localStorage.getItem('token');
      axios.delete(`${BASE_URL}/products/delete/${productId}`, {
        headers: {
          Authorization: `Bearer ${token}`
        }
      })
      .then(() => {
        this.products = this.products.filter(product => product.id !== productId);
        Swal.fire('Deleted!', 'Your product has been deleted.', 'success');
      })
      .catch(error => {
        console.error("There was an error deleting the product:", error);
        Swal.fire('Error', 'Failed to delete the product', 'error');
      });
    },
  },
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
  margin-bottom: 10px;
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
