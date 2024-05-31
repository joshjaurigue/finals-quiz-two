<template>
  <div>
    <!-- Navigation Bar -->
    <nav class="nav-bar">
      <div class="nav-container">
        <router-link class="nav-brand" to="/view-products">Products</router-link>
      </div>
    </nav>
    
    <!-- Add Product Form -->
    <div class="container">
      <form @submit.prevent="submitForm" class="form-container">
        <div class="form-group">
          <h2 class="form-heading">Add Product</h2>
          <label for="productName">Product Name:</label>
          <input type="text" class="form-control" id="productName" v-model="productName" required>
        </div>
        <div class="form-group">
          <label for="description">Description:</label>
          <textarea class="form-control" id="description" v-model="description" required></textarea>
        </div>
        <div class="form-group">
          <label for="price">Price:</label>
          <input type="number" class="form-control" id="price" v-model="price" required>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Add Product</button>
      </form>
    </div>
  </div>
</template>

<script>
import { BASE_URL } from '@/config';
import axios from 'axios';
import Swal from 'sweetalert2';

export default {
  name: 'AddProduct',
  data() {
    return {
      productName: '',
      description: '',
      price: ''
    };
  },
  methods: {
    submitForm() {
      const token = localStorage.getItem('token');
      const formData = {
        product_name: this.productName,
        product_description: this.description,
        product_price: this.price
      };

      axios.post(`${BASE_URL}/products/create`, formData, {
        headers: {
          Authorization: `Bearer ${token}`
        }
      })
      .then(() => {
        Swal.fire({
          icon: 'success',
          title: 'Product Added',
          text: 'Product has been added successfully',
          confirmButtonText: 'OK'
        }).then(() => {
          // Redirect to view-products page
          this.$router.push({ name: 'view-products' });
        });
      })
      .catch(error => {
        console.error('Error adding product:', error);
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Failed to add product',
          confirmButtonText: 'OK'
        });
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
