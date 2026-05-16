export default function SubmitButton({ children, loading }) {
  return (
    <button className="buy-btn mt-4 w-full justify-center disabled:cursor-not-allowed disabled:opacity-70" type="submit" disabled={loading}>
      {loading ? 'Please wait...' : children}
    </button>
  );
}
