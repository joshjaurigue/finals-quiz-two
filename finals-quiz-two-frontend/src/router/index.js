// src/router/index.js
import { createRouter, createWebHistory } from 'vue-router';
import AddProducts from '../components/AddProducts.vue';
import AddUsers from '../components/AddUsers.vue';
import DeleteProducts from '../components/DeleteProducts.vue';
import EditProduct from '../components/EditProducts.vue';
import LoginPage from '../components/LoginPage.vue';
import RegisterPage from '../components/RegisterPage.vue';
import ViewProducts from '../components/ViewProducts.vue';
import ViewUsers from '../components/ViewUsers.vue';
import { isAuthenticated, isAdmin } from '../utils/auth';
import { BASE_URL } from '@/config';
import axios from 'axios';
import Swal from 'sweetalert2';
import EditUsers from '../components/EditUsers.vue';

const routes = [
  {
    path: '/add-products',
    name: 'add-products',
    component: AddProducts,
    meta: { requiresAuth: true, requiresAdmin: false }
  },
  {
    path: '/add-users',
    name: 'add-users',
    component: AddUsers,
    meta: { requiresAuth: true, requiresAdmin: true }
  },
  {
    path: '/delete-products',
    name: 'delete-products',
    component: DeleteProducts,
    meta: { requiresAuth: true, requiresAdmin: false }
  },
  {
    path: '/edit-users/:id',
    name: 'edit-users',
    component: EditUsers,
    meta: { requiresAuth: true, requiresAdmin: true }
  },
  {
    path: '/edit-product/:id',
    name: 'edit-product',
    component: EditProduct,
    meta: { requiresAuth: true, requiresAdmin: false }
  },
  {
    path: '/login',
    name: 'login',
    component: LoginPage,
    beforeEnter: (to, from, next) => {
      // If user is logged in, redirect to home
      if (localStorage.getItem('token')) {
        next('/view-products');
      } else {
        next();
      }
    }
  },
  {
    path: '/register',
    name: 'register',
    component: RegisterPage,
    beforeEnter: (to, from, next) => {
      // If user is logged in, redirect to home
      if (localStorage.getItem('token')) {
        next('/view-products');
      } else {
        next();
      }
    }
  },
  {
    path: '/view-products',
    name: 'view-products',
    component: ViewProducts,
    meta: { requiresAuth: true, requiresAdmin: false }
  },
  {
    path: '/view-users',
    name: 'view-users',
    component: ViewUsers,
    meta: { requiresAuth: true, requiresAdmin: true }
  },
  {
    path: '/logout',
    name: 'logout',
    beforeEnter: async (to, from, next) => {
      try {
        // Call the API to invalidate the token
        const response = await axios.post(`${BASE_URL}/logout`, {}, {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`
          }
        });

        if (response.status === 200) {
          // Clear the token from local storage
          localStorage.removeItem('token');
        }
      } catch (error) {
        console.error('An error occurred during logout:', error);
      } finally {
        next('/login'); // Ensure navigation to the login page
      }
    }
  },
  {
    path: '/',
    redirect: '/login'
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.requiresAuth)) {
    if (!isAuthenticated()) {
      Swal.fire({
        icon: 'error',
        title: 'Unauthorized',
        text: 'You need to be logged in to access this page.',
        confirmButtonText: 'OK'
      }).then(() => {
        next({
          path: '/login',
        });
      });
    } else if (to.matched.some(record => record.meta.requiresAdmin) && !isAdmin()) {
      Swal.fire({
        icon: 'error',
        title: 'Unauthorized',
        text: 'You do not have permission to access this page.',
        confirmButtonText: 'OK'
      }).then(() => {
        next(false);  // Prevent navigation
      });
    } else {
      next();
    }
  } else {
    next();
  }
});

export default router;
