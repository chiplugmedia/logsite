import { UserPlus } from 'lucide-react';
import { Link, useSearchParams } from 'react-router-dom';
import { useState } from 'react';
import Alert from '../components/Alert.jsx';
import PasswordInput from '../components/PasswordInput.jsx';
import SubmitButton from '../components/SubmitButton.jsx';
import AuthLayout from '../layouts/AuthLayout.jsx';
import { signup } from '../services/authService.js';
import { useForm } from '../hooks/useForm.js';

export default function SignupPage() {
  const [searchParams] = useSearchParams();
  const refUsername = searchParams.get('ref') || '';
  const { values, handleChange } = useForm({
    fullname: '',
    username: '',
    email: '',
    phoneNumber: '',
    password: '',
    refUsername,
    agree: false,
  });
  const [notice, setNotice] = useState(null);
  const [loading, setLoading] = useState(false);

  async function handleSubmit(event) {
    event.preventDefault();
    setLoading(true);
    setNotice(null);

    try {
      const response = await signup(values);
      setNotice({ status: response.status, message: response.message });
      window.setTimeout(() => {
        window.location.href = '/login';
      }, 1200);
    } catch (error) {
      setNotice(error.response?.data || { status: 'error', message: 'Unable to create account right now' });
    } finally {
      setLoading(false);
    }
  }

  return (
    <AuthLayout>
      <form className="text-center" onSubmit={handleSubmit}>
        <h1 className="my-3 text-lg font-semibold">Sign up your account for Pinatexlogs</h1>
        <Alert status={notice?.status} message={notice?.message} />

        <div className="space-y-3">
          <input className="auth-input" type="text" name="fullname" value={values.fullname} onChange={handleChange} placeholder="Enter your full name" required autoFocus />
          <input className="auth-input" type="text" name="username" value={values.username} onChange={handleChange} placeholder="Enter your username" required />
          <input className="auth-input" type="email" name="email" value={values.email} onChange={handleChange} placeholder="Enter your email" required />
          <input className="auth-input" type="text" name="phoneNumber" value={values.phoneNumber} onChange={handleChange} placeholder="Enter your phone number" required />
          {refUsername && <input className="auth-input bg-slate-50 dark:bg-slate-800" type="text" name="refUsername" value={values.refUsername} readOnly />}
          <PasswordInput id="signup-password" name="password" value={values.password} onChange={handleChange} required />
        </div>

        <label className="mt-3 flex items-start gap-2 text-left text-sm text-slate-600 dark:text-slate-300">
          <input className="mt-1 h-4 w-4 accent-[#28bf62]" name="agree" type="checkbox" checked={values.agree} onChange={handleChange} required />
          <span>I agree to all the Terms & Conditions</span>
        </label>

        <SubmitButton loading={loading}>
          <UserPlus className="h-5 w-5" />
          Register
        </SubmitButton>
      </form>

      <div className="mt-5 flex items-end justify-between gap-3 text-sm">
        <p className="font-medium text-slate-700 dark:text-slate-300">Already have an Account?</p>
        <Link className="font-medium text-[#28bf62]" to="/login">
          Login here
        </Link>
      </div>
    </AuthLayout>
  );
}
