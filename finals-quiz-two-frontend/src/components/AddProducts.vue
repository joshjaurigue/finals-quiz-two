<template>
  <div class="container">
    <h2 class="form-heading">Add New Product</h2>
    <form @submit.prevent="submitForm" class="form-container">
      <div class="form-group">
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
</template>

<script>
import { BASE_URL } from '@/config';
import axios from 'axios';

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
        name: this.productName,
        description: this.description,
        price: this.price
      };

      axios.post(`${BASE_URL}/products`, formData, {
        headers: {
          Authorization: `Bearer ${token}`
        }
      })
      .then(response => {
        console.log('Product added successfully:', response.data);
        // Optionally, you can redirect or perform other actions after adding the product
      })
      .catch(error => {
        console.error("Error adding product:", error);
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
  height: 100%;
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
</style>
