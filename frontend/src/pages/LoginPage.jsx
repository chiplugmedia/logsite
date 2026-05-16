import { LogIn } from 'lucide-react';
import { Link } from 'react-router-dom';
import Alert from '../components/Alert.jsx';
import PasswordInput from '../components/PasswordInput.jsx';
import SubmitButton from '../components/SubmitButton.jsx';
import AuthLayout from '../layouts/AuthLayout.jsx';
import { useAuth } from '../context/AuthContext.jsx';
import { useForm } from '../hooks/useForm.js';
import { useState } from 'react';

export default function LoginPage() {
  const { login } = useAuth();
  const { values, handleChange } = useForm({ username: '', password: '', remember_me: true });
  const [notice, setNotice] = useState(null);
  const [loading, setLoading] = useState(false);

  async function handleSubmit(event) {
    event.preventDefault();
    setLoading(true);
    setNotice(null);

    try {
      const response = await login(values);
      setNotice({ status: response.status, message: response.message });
      window.setTimeout(() => {
        window.location.href = response.redirect;
      }, 800);
    } catch (error) {
      setNotice(error.response?.data || { status: 'error', message: 'Unable to login right now' });
    } finally {
      setLoading(false);
    }
  }

  return (
    <AuthLayout>
      <form className="text-center" onSubmit={handleSubmit}>
        <h1 className="my-3 text-lg font-semibold">Welcome back to Pinatexlogs</h1>
        <Alert status={notice?.status} message={notice?.message} />

        <div className="space-y-3">
          <input className="auth-input" type="text" name="username" value={values.username} onChange={handleChange} placeholder="Enter your username" autoFocus />
          <PasswordInput id="password" name="password" value={values.password} onChange={handleChange} />
        </div>

        <div className="mt-3 flex items-center justify-between gap-3 text-sm">
          <label className="inline-flex items-center gap-2 text-slate-600 dark:text-slate-300">
            <input className="h-4 w-4 accent-[#28bf62]" type="checkbox" name="remember_me" checked={values.remember_me} onChange={handleChange} />
            Remember me?
          </label>
          <Link className="font-medium text-[#28bf62]" to="/forgot-password">
            Forgot Password?
          </Link>
        </div>

        <SubmitButton loading={loading}>
          <LogIn className="h-5 w-5" />
          Login
        </SubmitButton>
      </form>

      <div className="mt-5 flex items-end justify-between gap-3 text-sm">
        <p className="font-medium text-slate-700 dark:text-slate-300">Don't have an Account?</p>
        <Link className="font-medium text-[#28bf62]" to="/signup">
          Create Account
        </Link>
      </div>
    </AuthLayout>
  );
}
