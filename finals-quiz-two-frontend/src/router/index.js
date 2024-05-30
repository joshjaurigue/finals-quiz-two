import { createRouter, createWebHistory } from 'vue-router';
import AddProducts from '../components/AddProducts.vue';
import AddUsers from '../components/AddUsers.vue';
import DeleteProducts from '../components/DeleteProducts.vue';
import DeleteUsers from '../components/DeleteUsers.vue';
import EditProduct from '../components/EditProducts.vue';
import LoginPage from '../components/LoginPage.vue';
import RegisterPage from '../components/RegisterPage.vue';
import ViewProducts from '../components/ViewProducts.vue';
import ViewUsers from '../components/ViewUsers.vue';

const routes = [
  {
    path: '/add-products',
    name: 'add-products',
    component: AddProducts
  },
  {
    path: '/add-users',
    name: 'add-users',
    component: AddUsers
  },
  {
    path: '/delete-products',
    name: 'add-users',
    component: DeleteProducts
  },
  {
    path: '/delete-users',
    name: 'delete-users',
    component: DeleteUsers
  },
  {
    path: '/edit-product/:id',
    name: 'edit-products',
    component: EditProduct
  },
  {
    path: '/login',
    name: 'login',
    component: LoginPage
  },
  {
    path: '/register',
    name: 'register',
    component: RegisterPage
  },
  {
    path: '/view-products',
    name: 'view-products',
    component: ViewProducts
  },
  {
    path: '/view-users',
    name: 'view-users',
    component: ViewUsers
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

export default router;