import logo from '../assets/Pinatexlogs.png';
import ThemeToggle from '../components/ThemeToggle.jsx';

export default function AuthLayout({ children }) {
  return (
    <main className="min-h-screen bg-[#f7f8ec] px-4 py-8 text-slate-900 dark:bg-slate-950 dark:text-slate-100">
      <div className="fixed right-4 top-4 z-20">
        <ThemeToggle />
      </div>
      <section className="mx-auto flex min-h-[calc(100vh-4rem)] w-full max-w-md items-center justify-center">
        <div className="w-full rounded-lg border border-black/5 bg-[#fefff0] p-5 shadow-xl shadow-lime-950/10 dark:border-slate-800 dark:bg-slate-900 dark:shadow-black/30">
          <a className="mb-6 flex justify-center" href="/">
            <span className="rounded-lg bg-white p-2 dark:bg-slate-100">
              <img src={logo} alt="Pinatexlogs" className="h-auto w-40" />
            </span>
          </a>
          {children}
        </div>
      </section>
    </main>
  );
}
