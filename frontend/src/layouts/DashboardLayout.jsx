import { Home, LogOut, Package, PlusCircle, ReceiptText, ShieldCheck, UserRound } from 'lucide-react';
import { NavLink } from 'react-router-dom';
import logo from '../assets/Pinatexlogs.png';
import { useAuth } from '../context/AuthContext.jsx';
import ThemeToggle from '../components/ThemeToggle.jsx';

const navItems = [
  { to: '/dashboard', label: 'Home', icon: Home },
  { to: '/dashboard/orders', label: 'My Orders', icon: Package },
  { to: '/dashboard/deposit', label: 'Add Fund', icon: PlusCircle },
  { to: '/dashboard/profile', label: 'Profile', icon: UserRound },
  { to: '/dashboard/rules', label: 'Rules', icon: ShieldCheck },
];

export default function DashboardLayout({ children }) {
  const { user, logout } = useAuth();

  async function handleLogout() {
    await logout();
    window.location.href = '/login';
  }

  return (
    <div className="min-h-screen bg-slate-50 text-slate-900 dark:bg-slate-950 dark:text-slate-100">
      <aside className="fixed inset-y-0 left-0 hidden w-64 border-r border-slate-200 bg-white p-4 lg:block dark:border-slate-800 dark:bg-slate-950">
        <span className="mb-8 block rounded-lg bg-white p-2 dark:bg-slate-100">
          <img src={logo} alt="Pinatexlogs" className="w-44" />
        </span>
        <div className="mb-6 rounded-lg bg-slate-50 p-3 dark:bg-slate-900">
          <p className="text-sm font-semibold">{user?.username}</p>
          <p className="text-xs text-slate-500 dark:text-slate-400">{user?.role}</p>
        </div>
        <nav className="space-y-1">
          {navItems.map((item) => (
            <NavLink
              key={item.to}
              to={item.to}
              className={({ isActive }) =>
                `flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium ${
                  isActive ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-950 dark:text-slate-300 dark:hover:bg-slate-900 dark:hover:text-white'
                }`
              }
            >
              <item.icon className="h-5 w-5" />
              {item.label}
            </NavLink>
          ))}
        </nav>
      </aside>

      <div className="lg:pl-64">
        <header className="sticky top-0 z-20 border-b border-slate-200 bg-white/95 px-4 py-3 backdrop-blur dark:border-slate-800 dark:bg-slate-950/90">
          <div className="mx-auto flex max-w-6xl items-center justify-between gap-4">
            <div className="flex items-center gap-3">
              <span className="rounded-lg bg-white p-1 dark:bg-slate-100 lg:hidden">
                <img src={logo} alt="Pinatexlogs" className="w-36" />
              </span>
              <ReceiptText className="hidden h-5 w-5 text-emerald-600 lg:block" />
              <span className="hidden text-sm font-medium text-slate-600 dark:text-slate-300 lg:inline">Dashboard</span>
            </div>
            <div className="flex items-center gap-2">
              <ThemeToggle />
              <button className="rounded-lg border border-slate-200 px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50 dark:border-slate-700 dark:text-slate-200 dark:hover:bg-slate-900" onClick={handleLogout}>
                <LogOut className="mr-2 inline h-4 w-4" />
                Log Out
              </button>
            </div>
          </div>
        </header>
        <main className="mx-auto max-w-6xl px-4 py-6">{children}</main>
      </div>
    </div>
  );
}
