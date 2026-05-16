import { Eye, EyeOff } from 'lucide-react';
import { useState } from 'react';

export default function PasswordInput({ id, label, name, value, onChange, placeholder = '............', required = false }) {
  const [visible, setVisible] = useState(false);

  return (
    <label className="block text-left text-sm font-medium text-slate-700 dark:text-slate-200" htmlFor={id}>
      {label && <span className="mb-1 block">{label}</span>}
      <span className="relative block">
        <input
          id={id}
          className="auth-input pr-11"
          type={visible ? 'text' : 'password'}
          name={name}
          value={value}
          onChange={onChange}
          placeholder={placeholder}
          required={required}
        />
        <button
          type="button"
          className="absolute right-2 top-1/2 grid h-8 w-8 -translate-y-1/2 place-items-center rounded-md text-slate-600 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800"
          onClick={() => setVisible((current) => !current)}
          aria-label={visible ? 'Hide password' : 'Show password'}
        >
          {visible ? <EyeOff className="h-5 w-5" /> : <Eye className="h-5 w-5" />}
        </button>
      </span>
    </label>
  );
}
