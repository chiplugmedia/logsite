import { Send } from 'lucide-react';
import { useState } from 'react';
import Alert from '../components/Alert.jsx';
import SubmitButton from '../components/SubmitButton.jsx';
import AuthLayout from '../layouts/AuthLayout.jsx';
import { forgotPassword } from '../services/authService.js';
import { useForm } from '../hooks/useForm.js';

export default function ForgotPasswordPage() {
  const { values, handleChange } = useForm({ email: '' });
  const [notice, setNotice] = useState(null);
  const [loading, setLoading] = useState(false);

  async function handleSubmit(event) {
    event.preventDefault();
    setLoading(true);
    setNotice(null);

    try {
      const response = await forgotPassword(values);
      setNotice({ status: response.status, message: response.message });
    } catch (error) {
      setNotice(error.response?.data || { status: 'error', message: 'Unable to send reset link right now' });
    } finally {
      setLoading(false);
    }
  }

  return (
    <AuthLayout>
      <form className="text-center" onSubmit={handleSubmit}>
        <h1 className="mb-3 text-xl font-semibold">Forgot Password?</h1>
        <p className="mb-4 text-sm text-slate-600 dark:text-slate-300">Enter your email and we'll send you instructions to reset your password</p>
        <Alert status={notice?.status} message={notice?.message} />

        <input className="auth-input" type="email" name="email" value={values.email} onChange={handleChange} placeholder="Enter your email" autoFocus />

        <SubmitButton loading={loading}>
          <Send className="h-5 w-5" />
          Send Reset Link
        </SubmitButton>
      </form>
    </AuthLayout>
  );
}
