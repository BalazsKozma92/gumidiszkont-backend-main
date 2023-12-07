import { RouteRecordRaw, NavigationGuardNext } from 'vue-router';

function isAuthenticated() {
  const storedItem = localStorage.getItem('TOKEN');
  console.log(storedItem)
  if (!storedItem) {
    return false;
  }

  const { value, expirationTime } = JSON.parse(storedItem);
  const currentTime = new Date().getTime();

  if (currentTime > expirationTime) {
    localStorage.removeItem('TOKEN');
    return false;
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
