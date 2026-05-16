const stats = [
  { value: '24/7', label: 'Self-service access' },
  { value: '4', label: 'Role-aware portals' },
  { value: '100%', label: 'MySQL compatibility' },
  { value: 'API', label: 'Ready backend migration' },
];

export default function StatsSection() {
  return (
    <section id="results" className="bg-white px-4 py-16 dark:bg-slate-950 sm:px-6 lg:px-8">
      <div className="mx-auto max-w-7xl rounded-3xl bg-slate-950 p-6 text-white shadow-2xl shadow-slate-950/20 dark:border dark:border-slate-800 dark:bg-slate-900 sm:p-10">
        <div className="grid gap-8 lg:grid-cols-[0.9fr_1.1fr] lg:items-center">
          <div>
            <p className="text-sm font-semibold uppercase tracking-[0.18em] text-emerald-300">Achievements</p>
            <h2 className="mt-3 text-3xl font-semibold tracking-tight sm:text-4xl">Built for reliability, clarity, and growth.</h2>
            <p className="mt-4 text-slate-300">The platform is being migrated module by module so core flows stay stable while the experience becomes faster and more professional.</p>
          </div>
          <div className="grid gap-3 sm:grid-cols-2">
            {stats.map((stat) => (
              <div key={stat.label} className="rounded-2xl border border-white/10 bg-white/5 p-5 backdrop-blur transition hover:bg-white/10">
                <p className="text-3xl font-semibold text-white">{stat.value}</p>
                <p className="mt-2 text-sm text-slate-300">{stat.label}</p>
              </div>
            ))}
          </div>
        </div>
      </div>
    </section>
  );
}
