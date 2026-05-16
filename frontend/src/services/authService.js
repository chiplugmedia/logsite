import api from './api';

export async function login(payload) {
  const { data } = await api.post('/login.php', payload);
  return data;
}

export async function signup(payload) {
  const { data } = await api.post('/signup.php', payload);
  return data;
}

export async function forgotPassword(payload) {
  const { data } = await api.post('/forgot-password.php', payload);
  return data;
}

export async function validateResetToken(token) {
  const { data } = await api.get('/reset-password.php', { params: { token } });
  return data;
}

export async function resetPassword(payload) {
  const { data } = await api.post('/reset-password.php', payload);
  return data;
}

export async function currentSession() {
  const { data } = await api.get('/session.php');
  return data;
}

export async function logout() {
  const { data } = await api.post('/logout.php');
  return data;
}
