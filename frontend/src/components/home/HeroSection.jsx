import { ArrowRight, CheckCircle2, ShieldCheck, Sparkles } from 'lucide-react';
import { Link } from 'react-router-dom';
import heroOne from '../../assets/hero-banner-1.png';
import heroTwo from '../../assets/hero-banner-2.png';
import heroThree from '../../assets/hero-banner-3.png';

const trustSignals = ['Fast wallet checkout', 'Verified delivery records', 'Secure account dashboard'];

export default function HeroSection() {
  return (
    <section className="relative overflow-hidden bg-white dark:bg-slate-950">
      <div className="absolute inset-x-0 top-0 h-64 bg-[radial-gradient(circle_at_top_left,rgba(16,185,129,0.16),transparent_32%),radial-gradient(circle_at_top_right,rgba(245,158,11,0.18),transparent_34%)] dark:bg-[radial-gradient(circle_at_top_left,rgba(16,185,129,0.18),transparent_32%),radial-gradient(circle_at_top_right,rgba(245,158,11,0.14),transparent_34%)]" />
      <div className="relative mx-auto grid max-w-7xl gap-12 px-4 py-16 sm:px-6 sm:py-20 lg:grid-cols-[1fr_0.9fr] lg:px-8 lg:py-24">
        <div className="flex flex-col justify-center">
          <div className="mb-5 inline-flex w-fit items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 text-sm font-semibold text-emerald-800">
            <Sparkles className="h-4 w-4" />
            Premium digital marketplace platform
          </div>
          <h1 className="max-w-4xl text-4xl font-semibold tracking-tight text-slate-950 dark:text-white sm:text-5xl lg:text-6xl">
            Buy, manage, and track digital services with confidence.
          </h1>
          <p className="mt-6 max-w-2xl text-lg leading-8 text-slate-600 dark:text-slate-300">
            Pinatexlogs brings product discovery, wallet payments, order history, and support workflows into one polished dashboard built for repeat buyers and growing digital businesses.
          </p>

          <div className="mt-8 flex flex-col gap-3 sm:flex-row">
            <Link className="inline-flex items-center justify-center gap-2 rounded-xl bg-slate-950 px-6 py-4 text-sm font-semibold text-white shadow-xl shadow-slate-950/10 transition hover:-translate-y-0.5 hover:bg-slate-800 dark:bg-emerald-600 dark:shadow-emerald-950/20 dark:hover:bg-emerald-500" to="/signup">
              Create account
              <ArrowRight className="h-4 w-4" />
            </Link>
            <Link className="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-6 py-4 text-sm font-semibold text-slate-800 shadow-sm transition hover:-translate-y-0.5 hover:border-emerald-200 hover:bg-emerald-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100 dark:hover:border-emerald-700 dark:hover:bg-emerald-950/30" to="/login">
              Access dashboard
            </Link>
          </div>

          <div className="mt-8 grid gap-3 text-sm text-slate-600 dark:text-slate-300 sm:grid-cols-3">
            {trustSignals.map((item) => (
              <div key={item} className="flex items-center gap-2">
                <CheckCircle2 className="h-5 w-5 flex-none text-emerald-600" />
                <span>{item}</span>
              </div>
            ))}
          </div>
        </div>

        <div className="relative">
          <div className="absolute -inset-4 rounded-[2rem] bg-gradient-to-br from-emerald-100 via-amber-100 to-white blur-2xl dark:from-emerald-950 dark:via-amber-950/40 dark:to-slate-950" />
          <div className="relative overflow-hidden rounded-3xl border border-slate-200 bg-slate-950 p-3 shadow-2xl shadow-slate-950/20">
            <div className="rounded-2xl bg-white p-4 dark:bg-slate-900">
              <div className="mb-4 flex items-center justify-between">
                <div>
                  <p className="text-sm font-semibold text-slate-950 dark:text-white">Marketplace overview</p>
                  <p className="text-xs text-slate-500 dark:text-slate-400">Live product and wallet snapshot</p>
                </div>
                <div className="rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">Active</div>
              </div>

              <div className="grid gap-3">
                {[heroOne, heroTwo, heroThree].map((image, index) => (
                  <div key={image} className="group overflow-hidden rounded-2xl border border-slate-100 bg-slate-50 dark:border-slate-800 dark:bg-slate-950">
                    <img src={image} alt={`Pinatexlogs service preview ${index + 1}`} className="h-32 w-full object-cover transition duration-500 group-hover:scale-[1.03] sm:h-40" />
                  </div>
                ))}
              </div>

              <div className="mt-4 grid grid-cols-3 gap-3">
                <div className="rounded-2xl bg-slate-50 p-3 dark:bg-slate-950">
                  <p className="text-xs text-slate-500 dark:text-slate-400">Orders</p>
                  <p className="text-lg font-semibold text-slate-950 dark:text-white">24/7</p>
                </div>
                <div className="rounded-2xl bg-emerald-50 p-3">
                  <p className="text-xs text-emerald-700">Wallet</p>
                  <p className="text-lg font-semibold text-emerald-900">Secure</p>
                </div>
                <div className="rounded-2xl bg-amber-50 p-3">
                  <p className="text-xs text-amber-700">Support</p>
                  <p className="text-lg font-semibold text-amber-900">Ready</p>
                </div>
              </div>
            </div>
          </div>

          <div className="absolute -bottom-5 -left-4 hidden rounded-2xl border border-slate-200 bg-white p-4 shadow-xl shadow-slate-950/10 dark:border-slate-800 dark:bg-slate-900 dark:shadow-black/30 sm:block">
            <div className="flex items-center gap-3">
              <div className="grid h-11 w-11 place-items-center rounded-xl bg-emerald-50 text-emerald-700">
                <ShieldCheck className="h-5 w-5" />
              </div>
              <div>
                <p className="text-sm font-semibold text-slate-950 dark:text-white">Protected sessions</p>
                <p className="text-xs text-slate-500 dark:text-slate-400">Role-aware account access</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  );
}
