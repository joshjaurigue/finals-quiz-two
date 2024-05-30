// src/utils/auth.js
export function isAuthenticated() {
    const token = localStorage.getItem('token');
    return !!token;
  }
  
  export function isAdmin() {
    const user = JSON.parse(localStorage.getItem('user'));
    return user && user.is_admin;
  }
  