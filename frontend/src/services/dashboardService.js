import api from './api';

export async function dashboardSummary() {
  const { data } = await api.get('/dashboard/summary.php');
  return data;
}
