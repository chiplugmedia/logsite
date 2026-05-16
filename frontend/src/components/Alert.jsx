import { CheckCircle2, Info, TriangleAlert, XCircle } from 'lucide-react';

const variants = {
  success: {
    icon: CheckCircle2,
    className: 'border-emerald-500 bg-emerald-50 text-emerald-900 dark:bg-emerald-950/40 dark:text-emerald-100',
  },
  error: {
    icon: XCircle,
    className: 'border-red-500 bg-red-50 text-red-900 dark:bg-red-950/40 dark:text-red-100',
  },
  warning: {
    icon: TriangleAlert,
    className: 'border-amber-500 bg-amber-50 text-amber-900 dark:bg-amber-950/40 dark:text-amber-100',
  },
  info: {
    icon: Info,
    className: 'border-blue-500 bg-blue-50 text-blue-900 dark:bg-blue-950/40 dark:text-blue-100',
  },
};

export default function Alert({ status = 'info', message }) {
  if (!message) {
    return null;
  }

  const config = variants[status] || variants.info;
  const Icon = config.icon;

  return (
    <div className={`mb-4 flex gap-3 rounded-md border p-3 text-sm ${config.className}`}>
      <Icon className="mt-0.5 h-5 w-5 flex-none" aria-hidden="true" />
      <div>
        <p className="font-semibold capitalize">{status}</p>
        <p>{message}</p>
      </div>
    </div>
  );
}
