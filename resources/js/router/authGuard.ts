import { RouteRecordRaw, NavigationGuardNext } from 'vue-router';

function isAuthenticated() {
  const storedToken = localStorage.getItem('TOKEN');
  const storedUserData = localStorage.getItem('userData');

  if (storedUserData && storedToken) {
    try {
      const userObject = JSON.parse(storedUserData);
      const { value, expirationTime } = JSON.parse(storedToken);
      const currentTime = new Date().getTime();

      if (userObject.is_admin === 0 || currentTime > expirationTime) {  
        localStorage.removeItem('TOKEN');
        return false;
      }
    } catch (error) {
      return false
    }
  } else {
    return false
  }

  return true;
}

export const authGuard = (to: any, from: any, next: NavigationGuardNext) => {
  if (to.matched.some((record: RouteRecordRaw) => record.meta?.requiresAuth)) {
    if (!isAuthenticated()) {
      next({ path: '/login'});
    } else {
      next();
    }
  } else {
    next();
  }
};
