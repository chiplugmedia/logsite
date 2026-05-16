const reviews = [
  {
    quote: 'The new dashboard direction makes the platform feel easier to trust. Balances, orders, and account actions are much clearer.',
    name: 'Marketplace buyer',
    role: 'Repeat customer',
  },
  {
    quote: 'The migration keeps the existing business rules while modernizing the workflow. That is exactly what a live platform needs.',
    name: 'Operations lead',
    role: 'Digital services team',
  },
  {
    quote: 'Clean navigation and responsive sections make it feel like a real product, not a stack of old pages stitched together.',
    name: 'Vendor partner',
    role: 'Product supplier',
  },
];

export default function TestimonialsSection() {
  return (
    <section className="bg-slate-50 px-4 py-20 dark:bg-slate-900 sm:px-6 lg:px-8">
      <div className="mx-auto max-w-7xl">
        <div className="text-center">
          <p className="text-sm font-semibold uppercase tracking-[0.18em] text-emerald-700">Reviews</p>
          <h2 className="mt-3 text-3xl font-semibold tracking-tight text-slate-950 dark:text-white sm:text-4xl">A more trustworthy customer experience.</h2>
        </div>
        <div className="mt-12 grid gap-4 lg:grid-cols-3">
          {reviews.map((review) => (
            <figure key={review.name} className="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-950">
              <blockquote className="leading-7 text-slate-700 dark:text-slate-300">"{review.quote}"</blockquote>
              <figcaption className="mt-6 border-t border-slate-100 pt-4 dark:border-slate-800">
                <p className="font-semibold text-slate-950 dark:text-white">{review.name}</p>
                <p className="text-sm text-slate-500 dark:text-slate-400">{review.role}</p>
              </figcaption>
            </figure>
          ))}
        </div>
      </div>
    </section>
  );
}
