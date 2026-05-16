import { Mail, MessageCircle } from 'lucide-react';
import logo from '../../assets/Pinatexlogs.png';

export default function HomeFooter() {
  return (
    <footer className="bg-slate-950 px-4 py-12 text-white dark:bg-black sm:px-6 lg:px-8">
      <div className="mx-auto grid max-w-7xl gap-10 lg:grid-cols-[1.2fr_0.8fr_0.8fr]">
        <div>
          <img src={logo} alt="Pinatexlogs" className="w-44 rounded-lg bg-white p-2" />
          <p className="mt-5 max-w-md text-sm leading-7 text-slate-300">
            A modern digital marketplace experience for account management, wallet funding, product access, and order tracking.
          </p>
        </div>

        <div>
          <h3 className="font-semibold">Useful links</h3>
          <div className="mt-4 grid gap-3 text-sm text-slate-300">
            <a className="transition hover:text-white" href="#features">Services</a>
            <a className="transition hover:text-white" href="#business">Business</a>
            <a className="transition hover:text-white" href="#faq">FAQ</a>
            <a className="transition hover:text-white" href="/login">Log in</a>
          </div>
        </div>

        <div>
          <h3 className="font-semibold">Contact</h3>
          <div className="mt-4 grid gap-3 text-sm text-slate-300">
            <a className="flex items-center gap-2 transition hover:text-white" href="mailto:info@pinatexlogs.com">
              <Mail className="h-4 w-4" />
              info@pinatexlogs.com
            </a>
            <a className="flex items-center gap-2 transition hover:text-white" href="https://t.me/YUNGFXi" rel="noreferrer" target="_blank">
              <MessageCircle className="h-4 w-4" />
              Telegram support
            </a>
          </div>
        </div>
      </div>

      <div className="mx-auto mt-10 flex max-w-7xl flex-col gap-3 border-t border-white/10 pt-6 text-sm text-slate-400 sm:flex-row sm:items-center sm:justify-between">
        <p>© {new Date().getFullYear()} Pinatexlogs. All rights reserved.</p>
        <p>Built for secure digital commerce.</p>
      </div>
    </footer>
  );
}
