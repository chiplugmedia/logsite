import { Menu, X } from 'lucide-react';
import { useState } from 'react';
import { Link } from 'react-router-dom';
import logo from '../../assets/Pinatexlogs.png';
import ThemeToggle from '../ThemeToggle.jsx';

const links = [
  { href: '#features', label: 'Services' },
  { href: '#results', label: 'Results' },
  { href: '#business', label: 'Business' },
  { href: '#faq', label: 'FAQ' },
];

export default function HomeNavbar() {
  const [open, setOpen] = useState(false);

  return (
    <header className="sticky top-0 z-50 border-b border-slate-200/70 bg-white/90 backdrop-blur-xl dark:border-slate-800 dark:bg-slate-950/90">
      <nav className="mx-auto flex h-20 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8" aria-label="Main navigation">
        <a href="/" className="flex items-center gap-3 rounded-lg bg-white p-2 dark:bg-slate-100">
          <img src={logo} alt="Pinatexlogs" className="h-auto w-40" />
        </a>

        <div className="hidden items-center gap-8 lg:flex">
          {links.map((link) => (
            <a key={link.href} className="text-sm font-medium text-slate-600 transition hover:text-emerald-700 dark:text-slate-300 dark:hover:text-emerald-300" href={link.href}>
              {link.label}
            </a>
          ))}
        </div>

        <div className="hidden items-center gap-3 lg:flex">
          <ThemeToggle />
          <Link className="rounded-lg px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-100 dark:text-slate-200 dark:hover:bg-slate-900" to="/login">
            Log in
          </Link>
          <Link className="rounded-lg bg-slate-950 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:-translate-y-0.5 hover:bg-slate-800 dark:bg-emerald-600 dark:hover:bg-emerald-500" to="/signup">
            Get started
          </Link>
        </div>

        <button
          className="grid h-10 w-10 place-items-center rounded-lg border border-slate-200 text-slate-700 dark:border-slate-700 dark:text-slate-100 lg:hidden"
          type="button"
          onClick={() => setOpen((current) => !current)}
          aria-expanded={open}
          aria-controls="mobile-menu"
          aria-label="Toggle navigation menu"
        >
          {open ? <X className="h-5 w-5" /> : <Menu className="h-5 w-5" />}
        </button>
      </nav>

      {open && (
        <div id="mobile-menu" className="border-t border-slate-200 bg-white px-4 py-4 dark:border-slate-800 dark:bg-slate-950 lg:hidden">
          <div className="mx-auto flex max-w-7xl flex-col gap-2">
            {links.map((link) => (
              <a key={link.href} className="rounded-lg px-3 py-3 text-sm font-medium text-slate-700 hover:bg-slate-50 dark:text-slate-200 dark:hover:bg-slate-900" href={link.href} onClick={() => setOpen(false)}>
                {link.label}
              </a>
            ))}
            <div className="mt-2 flex justify-end">
              <ThemeToggle />
            </div>
            <div className="mt-2 grid grid-cols-2 gap-3">
              <Link className="rounded-lg border border-slate-200 px-4 py-3 text-center text-sm font-semibold text-slate-700 dark:border-slate-700 dark:text-slate-200" to="/login">
                Log in
              </Link>
              <Link className="rounded-lg bg-slate-950 px-4 py-3 text-center text-sm font-semibold text-white dark:bg-emerald-600" to="/signup">
                Get started
              </Link>
            </div>
          </div>
        </div>
      )}
    </header>
  );
}
