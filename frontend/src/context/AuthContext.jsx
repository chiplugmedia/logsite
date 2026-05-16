import { createContext, useContext, useEffect, useMemo, useState } from 'react';
import { currentSession, login as loginRequest, logout as logoutRequest } from '../services/authService';

const AuthContext = createContext(null);

export function AuthProvider({ children }) {
  const [user, setUser] = useState(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    let mounted = true;

    currentSession()
      .then((response) => {
        if (mounted && response.authenticated) {
          setUser(response.user);
        }
      })
      .finally(() => {
        if (mounted) {
          setLoading(false);
        }
      });

    return () => {
      mounted = false;
    };
  }, []);

  const value = useMemo(
    () => ({
      user,
      loading,
      async login(credentials) {
        const response = await loginRequest(credentials);
        setUser(response.user);
        return response;
      },
      async logout() {
        const response = await logoutRequest();
        setUser(null);
        return response;
      },
    }),
    [loading, user],
  );

  return <AuthContext.Provider value={value}>{children}</AuthContext.Provider>;
}

export function useAuth() {
  const value = useContext(AuthContext);
  if (!value) {
    throw new Error('useAuth must be used inside AuthProvider');
  }
  return value;
}
