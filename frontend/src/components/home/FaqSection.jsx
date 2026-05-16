const faqs = [
  {
    question: 'Is this replacing the old PHP application?',
    answer: 'Yes, incrementally. React handles the frontend while PHP remains the backend API layer, preserving existing MySQL data and business rules.',
  },
  {
    question: 'Will existing user accounts still work?',
    answer: 'Yes. The migration keeps the legacy password compatibility and PHP session behavior while modernizing the interface.',
  },
  {
    question: 'How do payments and wallet features fit in?',
    answer: 'Wallet and payment flows stay on the PHP backend and are migrated into REST endpoints one module at a time to avoid breaking financial logic.',
  },
  {
    question: 'Is the page responsive?',
    answer: 'The layout is designed for desktop, tablet, and mobile with responsive grids, accessible navigation, and touch-friendly controls.',
  },
];

export default function FaqSection() {
  return (
    <section id="faq" className="bg-slate-50 px-4 py-20 dark:bg-slate-900 sm:px-6 lg:px-8">
      <div className="mx-auto max-w-4xl">
        <div className="text-center">
          <p className="text-sm font-semibold uppercase tracking-[0.18em] text-emerald-700">FAQ</p>
          <h2 className="mt-3 text-3xl font-semibold tracking-tight text-slate-950 dark:text-white sm:text-4xl">Questions before you get started.</h2>
        </div>
        <div className="mt-10 space-y-3">
          {faqs.map((faq) => (
            <details key={faq.question} className="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-950">
              <summary className="cursor-pointer list-none text-base font-semibold text-slate-950 dark:text-white">
                <span className="flex items-center justify-between gap-4">
                  {faq.question}
                  <span className="grid h-7 w-7 flex-none place-items-center rounded-full bg-slate-100 text-slate-500 transition group-open:rotate-45 dark:bg-slate-800 dark:text-slate-300">+</span>
                </span>
              </summary>
              <p className="mt-4 leading-7 text-slate-600 dark:text-slate-300">{faq.answer}</p>
            </details>
          ))}
        </div>
      </div>
    </section>
  );
}
