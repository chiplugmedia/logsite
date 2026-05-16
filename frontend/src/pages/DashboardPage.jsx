import { Banknote, PackageCheck, ReceiptText, UsersRound, Wallet } from 'lucide-react';
import { useEffect, useState } from 'react';
import Alert from '../components/Alert.jsx';
import StatCard from '../components/StatCard.jsx';
import DashboardLayout from '../layouts/DashboardLayout.jsx';
import { dashboardSummary } from '../services/dashboardService.js';

const currency = new Intl.NumberFormat('en-NG', {
  style: 'currency',
  currency: 'NGN',
});

function money(value) {
  return currency.format(Number(value || 0));
}

export default function DashboardPage() {
  const [summary, setSummary] = useState(null);
  const [notice, setNotice] = useState(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    dashboardSummary()
      .then((response) => setSummary(response))
      .catch((error) => setNotice(error.response?.data || { status: 'error', message: 'Unable to load dashboard summary' }))
      .finally(() => setLoading(false));
  }, []);

  return (
    <DashboardLayout>
      <div className="mb-6">
        <p className="text-sm text-slate-500 dark:text-slate-400">Welcome back</p>
        <h1 className="text-2xl font-semibold text-slate-950 dark:text-white">{summary?.user?.fullname || summary?.user?.username || 'Dashboard'}</h1>
      </div>

      <Alert status={notice?.status} message={notice?.message} />

      {loading && <div className="rounded-lg border border-slate-200 bg-white p-6 text-sm text-slate-500 dark:border-slate-800 dark:bg-slate-900 dark:text-slate-400">Loading dashboard...</div>}

      {summary && (
        <>
          <section className="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            <StatCard label="Main Balance" value={money(summary.balances.main)} icon={Wallet} />
            <StatCard label="Referral Balance" value={money(summary.balances.referral)} icon={UsersRound} />
            <StatCard label="Total Funded" value={money(summary.stats.totalFunded)} icon={Banknote} />
            <StatCard label="Orders" value={summary.stats.totalOrders} icon={PackageCheck} />
          </section>

          <section className="mt-6 grid gap-4 lg:grid-cols-3">
            <div className="rounded-lg border border-slate-200 bg-white p-4 lg:col-span-2 dark:border-slate-800 dark:bg-slate-900">
              <div className="mb-4 flex items-center justify-between">
                <h2 className="font-semibold text-slate-950 dark:text-white">Recent Orders</h2>
                <span className="text-sm text-slate-500 dark:text-slate-400">{money(summary.stats.totalCompletedPurchases)} spent</span>
              </div>
              <div className="overflow-x-auto">
                <table className="w-full min-w-[520px] text-left text-sm">
                  <thead className="border-b border-slate-200 text-xs uppercase text-slate-500 dark:border-slate-800 dark:text-slate-400">
                    <tr>
                      <th className="py-2">Title</th>
                      <th className="py-2">Amount</th>
                      <th className="py-2">Status</th>
                      <th className="py-2">Reference</th>
                    </tr>
                  </thead>
                  <tbody>
                    {summary.recentOrders.length === 0 && (
                      <tr>
                        <td className="py-4 text-slate-500 dark:text-slate-400" colSpan="4">No orders yet.</td>
                      </tr>
                    )}
                    {summary.recentOrders.map((order) => (
                      <tr className="border-b border-slate-100 dark:border-slate-800" key={order.reference}>
                        <td className="py-3 font-medium text-slate-800 dark:text-slate-100">{order.title}</td>
                        <td className="py-3">{money(order.amount)}</td>
                        <td className="py-3">{order.status}</td>
                        <td className="py-3 text-slate-500 dark:text-slate-400">{order.reference}</td>
                      </tr>
                    ))}
                  </tbody>
                </table>
              </div>
            </div>

            <div className="rounded-lg border border-slate-200 bg-white p-4 dark:border-slate-800 dark:bg-slate-900">
              <h2 className="mb-4 font-semibold text-slate-950 dark:text-white">Account Snapshot</h2>
              <dl className="space-y-3 text-sm">
                <div className="flex justify-between gap-3">
                  <dt className="text-slate-500 dark:text-slate-400">Transactions</dt>
                  <dd className="font-medium">{summary.stats.totalTransactions}</dd>
                </div>
                <div className="flex justify-between gap-3">
                  <dt className="text-slate-500 dark:text-slate-400">Referrals</dt>
                  <dd className="font-medium">{summary.stats.totalReferrals}</dd>
                </div>
                <div className="flex justify-between gap-3">
                  <dt className="text-slate-500 dark:text-slate-400">Withdrawn</dt>
                  <dd className="font-medium">{money(summary.stats.totalWithdrawn)}</dd>
                </div>
                <div className="flex justify-between gap-3">
                  <dt className="text-slate-500 dark:text-slate-400">VTU Balance</dt>
                  <dd className="font-medium">{money(summary.balances.vtu)}</dd>
                </div>
                <div className="border-t border-slate-100 pt-3 dark:border-slate-800">
                  <dt className="text-slate-500 dark:text-slate-400">Bank</dt>
                  <dd className="mt-1 font-medium">{summary.bank ? `${summary.bank.bankname} - ${summary.bank.acctnum}` : 'No bank account saved'}</dd>
                </div>
              </dl>
            </div>
          </section>

          <section className="mt-6 rounded-lg border border-slate-200 bg-white p-4 dark:border-slate-800 dark:bg-slate-900">
            <div className="mb-4 flex items-center gap-2">
              <ReceiptText className="h-5 w-5 text-emerald-600" />
              <h2 className="font-semibold text-slate-950 dark:text-white">Recent Funding</h2>
            </div>
            <div className="grid gap-3 md:grid-cols-2">
              {summary.recentFunding.length === 0 && <p className="text-sm text-slate-500 dark:text-slate-400">No funding records yet.</p>}
              {summary.recentFunding.map((item) => (
                <div className="rounded-lg border border-slate-100 p-3 dark:border-slate-800 dark:bg-slate-950/40" key={`${item.trxid}-${item.date}`}>
                  <div className="flex justify-between gap-3">
                    <p className="font-medium">{money(item.amount)}</p>
                    <span className="text-sm text-slate-500 dark:text-slate-400">{item.status}</span>
                  </div>
                  <p className="mt-1 text-xs text-slate-500 dark:text-slate-400">{item.message || item.trxid || item.date}</p>
                </div>
              ))}
            </div>
          </section>
        </>
      )}
    </DashboardLayout>
  );
}
