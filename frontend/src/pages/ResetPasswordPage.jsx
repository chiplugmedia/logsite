import { Link, useSearchParams } from 'react-router-dom';
import { useEffect, useState } from 'react';
import Alert from '../components/Alert.jsx';
import PasswordInput from '../components/PasswordInput.jsx';
import SubmitButton from '../components/SubmitButton.jsx';
import AuthLayout from '../layouts/AuthLayout.jsx';
import { resetPassword, validateResetToken } from '../services/authService.js';
import { useForm } from '../hooks/useForm.js';

export default function ResetPasswordPage() {
  const [searchParams] = useSearchParams();
  const token = searchParams.get('tkn') || searchParams.get('token') || '';
  const { values, handleChange } = useForm({ password: '', confirmPsw: '' });
  const [email, setEmail] = useState('');
  const [notice, setNotice] = useState(null);
  const [loading, setLoading] = useState(false);
  const [checking, setChecking] = useState(true);

  useEffect(() => {
    if (!token) {
      setNotice({ status: 'error', message: 'Invalid password reset link' });
      setChecking(false);
      return;
    }

    validateResetToken(token)
      .then((response) => {
        setEmail(response.email);
      })
      .catch((error) => {
        setNotice(error.response?.data || { status: 'error', message: 'Invalid password reset link' });
      })
      .finally(() => setChecking(false));
  }, [token]);

  async function handleSubmit(event) {
    event.preventDefault();
    setLoading(true);
    setNotice(null);

    try {
      const response = await resetPassword({ token, ...values });
      setNotice({ status: response.status, message: response.message });
      window.setTimeout(() => {
        window.location.href = '/login';
      }, 1000);
    } catch (error) {
      setNotice(error.response?.data || { status: 'error', message: 'Unable to reset password right now' });
    } finally {
      setLoading(false);
    }
  }

  return (
    <AuthLayout>
      <form onSubmit={handleSubmit}>
        <h1 className="mb-2 text-xl font-semibold">Reset Password</h1>
        <p className="mb-4 text-sm text-slate-600 dark:text-slate-300">for <span className="font-semibold">{email || 'your account'}</span></p>
        <Alert status={notice?.status} message={notice?.message} />

        {!checking && email && (
          <div className="space-y-3">
            <PasswordInput id="new-password" label="New Password" name="password" value={values.password} onChange={handleChange} />
            <PasswordInput id="confirm-password" label="Confirm Password" name="confirmPsw" value={values.confirmPsw} onChange={handleChange} />
            <SubmitButton loading={loading}>Set new password</SubmitButton>
          </div>
        )}

        <div className="mt-4 text-center text-sm">
          <Link className="font-medium text-[#28bf62]" to="/login">
            Back to login
          </Link>
        </div>
      </form>
    </AuthLayout>
  );
}
