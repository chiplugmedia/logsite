import { BarChart3, CreditCard, Headphones, PackageSearch, ShieldCheck, Zap } from 'lucide-react';

const features = [
  {
    icon: PackageSearch,
    title: 'Curated product catalog',
    description: 'Browse organized digital products with stock visibility, categories, and purchase-ready detail views.',
  },
  {
    icon: CreditCard,
    title: 'Wallet-first checkout',
    description: 'Keep payment, funding, and purchase records in one account experience without repeated page reloads.',
  },
  {
    icon: ShieldCheck,
    title: 'Session-based security',
    description: 'Role-aware authentication protects dashboard, admin, assistant, and vendor flows.',
  },
  {
    icon: BarChart3,
    title: 'Business dashboard',
    description: 'Track balances, funding, orders, referrals, and recent activity through a clean dashboard.',
  },
  {
    icon: Headphones,
    title: 'Support workflows',
    description: 'Give buyers clear routes to help, rules, order history, and account management.',
  },
  {
    icon: Zap,
    title: 'Fast React experience',
    description: 'Modern routing and API calls replace slow refresh-heavy pages as modules are migrated.',
  },
];

export default function FeatureSection() {
  return (
    <section id="features" className="bg-slate-50 px-4 py-20 dark:bg-slate-900 sm:px-6 lg:px-8">
      <div className="mx-auto max-w-7xl">
        <div className="max-w-2xl">
          <p className="text-sm font-semibold uppercase tracking-[0.18em] text-emerald-700">Services</p>
          <h2 className="mt-3 text-3xl font-semibold tracking-tight text-slate-950 dark:text-white sm:text-4xl">A cleaner operating system for digital product sales.</h2>
          <p className="mt-4 text-lg text-slate-600 dark:text-slate-300">The new React experience keeps the useful business logic while turning the interface into a polished, scalable product.</p>
        </div>

        <div className="mt-12 grid gap-4 md:grid-cols-2 lg:grid-cols-3">
          {features.map((feature) => (
            <article key={feature.title} className="group rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition duration-300 hover:-translate-y-1 hover:border-emerald-200 hover:shadow-xl hover:shadow-emerald-950/5 dark:border-slate-800 dark:bg-slate-950 dark:hover:border-emerald-800 dark:hover:shadow-black/20">
              <div className="grid h-12 w-12 place-items-center rounded-xl bg-slate-950 text-white transition group-hover:bg-emerald-600 dark:bg-slate-800 dark:group-hover:bg-emerald-600">
                <feature.icon className="h-5 w-5" />
              </div>
              <h3 className="mt-5 text-lg font-semibold text-slate-950 dark:text-white">{feature.title}</h3>
              <p className="mt-3 leading-7 text-slate-600 dark:text-slate-300">{feature.description}</p>
            </article>
          ))}
        </div>
      </div>
    </section>
  );
}
