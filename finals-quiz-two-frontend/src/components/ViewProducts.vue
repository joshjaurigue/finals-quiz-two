<template>
  <div class="container">
    <nav class="nav-bar">
      <div class="nav-container">
        <router-link class="nav-brand" to="/view-products">Product Management</router-link>
        <ul class="nav-links">
          <li class="nav-item">
            <router-link class="nav-link" to="/view-users">Manage Users</router-link>
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
          <td>{{ product.name }}</td>
          <td>{{ product.description }}</td>
          <td>{{ product.price }}</td>
          <td>
            <router-link :to="{ name: 'viewProduct', params: { id: product.id } }" class="btn btn-primary mr-2 btn-sm">View</router-link>
            <router-link :to="{ name: 'editProduct', params: { id: product.id } }" class="btn btn-secondary mr-2 btn-sm">Edit</router-link>
            <button @click="deleteProduct(product.id)" class="btn btn-danger btn-sm">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import { BASE_URL } from '@/config';
import axios from 'axios';

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
    deleteProduct(productId) {
      if (confirm('Are you sure you want to delete this product?')) {
        const token = localStorage.getItem('token');
        axios.delete(`${BASE_URL}/products/${productId}`, {
          headers: {
            Authorization: `Bearer ${token}`
          }
        })
        .then(() => {
          this.products = this.products.filter(product => product.id !== productId);
        })
        .catch(error => {
          console.error("There was an error deleting the product:", error);
        });
      }
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
  padding: 100;
  margin: 0;
  display: flex;
}

.nav-item {
}

.nav-link {
  text-decoration: none;
  color: #fff;
  padding: 0.5em 3em;
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
