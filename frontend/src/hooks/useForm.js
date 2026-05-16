import { useState } from 'react';

export function useForm(initialValues) {
  const [values, setValues] = useState(initialValues);

  function handleChange(event) {
    const { name, type, checked, value } = event.target;
    setValues((current) => ({
      ...current,
      [name]: type === 'checkbox' ? checked : value,
    }));
  }

  function reset(nextValues = initialValues) {
    setValues(nextValues);
  }

  return { values, setValues, handleChange, reset };
}
