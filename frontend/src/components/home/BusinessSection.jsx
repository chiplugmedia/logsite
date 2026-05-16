import { ArrowRight, BadgeCheck, LineChart, LockKeyhole, WalletCards } from 'lucide-react';
import { Link } from 'react-router-dom';

const points = [
  { icon: WalletCards, title: 'Wallet economy', text: 'Support repeat purchases with funded balances, history, and transparent order records.' },
  { icon: LineChart, title: 'Scalable operations', text: 'Separate React UI from PHP APIs so new services, admin tools, and analytics can grow cleanly.' },
  { icon: LockKeyhole, title: 'Security roadmap', text: 'Move sensitive credentials into environment config and keep access role-aware.' },
  { icon: BadgeCheck, title: 'Production discipline', text: 'Incremental migration protects payments, authentication, and database compatibility.' },
];

export default function BusinessSection() {
  return (
    <section id="business" className="bg-white px-4 py-20 dark:bg-slate-950 sm:px-6 lg:px-8">
      <div className="mx-auto grid max-w-7xl gap-10 lg:grid-cols-[0.9fr_1.1fr] lg:items-center">
        <div>
          <p className="text-sm font-semibold uppercase tracking-[0.18em] text-emerald-700">Business information</p>
          <h2 className="mt-3 text-3xl font-semibold tracking-tight text-slate-950 dark:text-white sm:text-4xl">Designed as a serious digital commerce platform.</h2>
          <p className="mt-5 text-lg leading-8 text-slate-600 dark:text-slate-300">
            Pinatexlogs is being shaped into a clean, API-driven product with durable infrastructure: React for the customer experience, PHP for backend logic, and MySQL for the existing data model.
          </p>
          <Link className="mt-8 inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-6 py-4 text-sm font-semibold text-white shadow-lg shadow-emerald-700/20 transition hover:-translate-y-0.5 hover:bg-emerald-700" to="/signup">
            Start your account
            <ArrowRight className="h-4 w-4" />
          </Link>
        </div>

        <div className="grid gap-4 sm:grid-cols-2">
          {points.map((point) => (
            <div key={point.title} className="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:shadow-xl hover:shadow-slate-950/5 dark:border-slate-800 dark:bg-slate-900 dark:hover:shadow-black/20">
              <div className="grid h-11 w-11 place-items-center rounded-xl bg-emerald-50 text-emerald-700">
                <point.icon className="h-5 w-5" />
              </div>
              <h3 className="mt-4 font-semibold text-slate-950 dark:text-white">{point.title}</h3>
              <p className="mt-2 text-sm leading-6 text-slate-600 dark:text-slate-300">{point.text}</p>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}
