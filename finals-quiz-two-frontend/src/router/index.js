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
    name: 'AddProducts',
    component: AddProducts
  },
  {
    path: '/add-users',
    name: 'AddUsers',
    component: AddUsers
  },
  {
    path: '/delete-products',
    name: 'DeleteProducts',
    component: DeleteProducts
  },
  {
    path: '/delete-users',
    name: 'DeleteUsers',
    component: DeleteUsers
  },
  {
    path: '/edit-product/:id',
    name: 'EditProduct',
    component: EditProduct
  },
  {
    path: '/login',
    name: 'LoginPage',
    component: LoginPage
  },
  {
    path: '/register',
    name: 'RegisterPage',
    component: RegisterPage
  },
  {
    path: '/view-products',
    name: 'ViewProducts',
    component: ViewProducts
  },
  {
    path: '/view-users',
    name: 'ViewUsers',
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