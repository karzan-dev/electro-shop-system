import Checkbox from '@/Components/Checkbox';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import GuestLayout from '@/Layouts/GuestLayout';
import ApplicationLogo from '@/Components/ApplicationLogo';
import { Head, Link, useForm } from '@inertiajs/react';
import { useState } from 'react';

export default function Login({ status, canResetPassword }) {
  const { data, setData, post, processing, errors, reset } = useForm({
    email: '',
    password: '',
    remember: false,
  });

  const [showPassword, setShowPassword] = useState(false);

  const submit = (e) => {
    e.preventDefault();
    post(route('login'), {
      onFinish: () => reset('password'),
    });
  };

  return (
    <GuestLayout>
      <Head title="Log in" />

      <div className="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-50 via-white to-gray-100 p-4">
        {/* Minimal background pattern */}
        <div className="fixed inset-0 bg-[linear-gradient(45deg,#f5f5f5_25%,transparent_25%),linear-gradient(-45deg,#f5f5f5_25%,transparent_25%),linear-gradient(45deg,transparent_75%,#f5f5f5_75%),linear-gradient(-45deg,transparent_75%,#f5f5f5_75%)] bg-[size:20px_20px] opacity-20"></div>

        {/* Geometric shapes */}
        <div className="fixed inset-0 overflow-hidden pointer-events-none">
          <div className="absolute top-20 right-20 w-64 h-64 border border-gray-200 rounded-full mix-blend-overlay opacity-10"></div>
          <div className="absolute bottom-20 left-20 w-48 h-48 border border-gray-300 rounded-full mix-blend-overlay opacity-10"></div>
          <div className="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 border border-gray-200 rounded-full mix-blend-overlay opacity-5"></div>
        </div>

        <div className="relative w-full max-w-md">
          {/* Main Card - Clean White with Black Accents */}
          <div className="bg-white rounded-2xl shadow-2xl shadow-gray-200/50 overflow-hidden border border-gray-100">
            {/* Top accent line */}
            <div className="h-1 bg-gradient-to-r from-gray-900 via-gray-700 to-gray-900"></div>

            <div className="p-8">
              {/* Logo and header */}
              <div className="flex flex-col items-center mb-8">
                <div className="mb-4 p-3 bg-gray-900 rounded-full">
                  <ApplicationLogo className="w-12 h-12 text-white" />
                </div>
                <h1 className="text-3xl font-bold text-gray-900 mb-2 tracking-tight">
                  Welcome Back
                </h1>
                <p className="text-gray-600 text-sm">
                  Sign in to continue to your account
                </p>
              </div>

              {/* Status message */}
              {status && (
                <div className="mb-6 p-4 rounded-lg bg-gray-900 border border-gray-800">
                  <p className="text-white text-sm font-medium">{status}</p>
                </div>
              )}

              {/* Login form */}
              <form onSubmit={submit} className="space-y-6">
                {/* Email field */}
                <div className="space-y-2">
                  <InputLabel
                    htmlFor="email"
                    value="Email"
                    className="text-gray-800 font-medium"
                  />
                  <div className="relative">
                    <div className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                      <svg className="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={1.5} d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                      </svg>
                    </div>
                    <TextInput
                      id="email"
                      type="email"
                      name="email"
                      value={data.email}
                      className="pl-10 w-full bg-gray-50 border-gray-200 text-gray-900 placeholder-gray-400 focus:border-gray-900 focus:ring-gray-900/20"
                      placeholder="you@example.com"
                      autoComplete="username"
                      isFocused={true}
                      onChange={(e) => setData('email', e.target.value)}
                    />
                  </div>
                  <InputError message={errors.email} className="mt-1" />
                </div>

                {/* Password field */}
                <div className="space-y-2">
                  <div className="flex items-center justify-between">
                    <InputLabel
                      htmlFor="password"
                      value="Password"
                      className="text-gray-800 font-medium"
                    />
                    {canResetPassword && (
                      <Link
                        href={route('password.request')}
                        className="text-sm text-gray-600 hover:text-gray-900 transition-colors font-medium"
                      >
                        Forgot password?
                      </Link>
                    )}
                  </div>
                  <div className="relative">
                    <div className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                      <svg className="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={1.5} d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                      </svg>
                    </div>
                    <TextInput
                      id="password"
                      type={showPassword ? "text" : "password"}
                      name="password"
                      value={data.password}
                      className="pl-10 pr-10 w-full bg-gray-50 border-gray-200 text-gray-900 placeholder-gray-400 focus:border-gray-900 focus:ring-gray-900/20"
                      placeholder="••••••••"
                      autoComplete="current-password"
                      onChange={(e) => setData('password', e.target.value)}
                    />
                    <button
                      type="button"
                      className="absolute inset-y-0 right-0 pr-3 flex items-center"
                      onClick={() => setShowPassword(!showPassword)}
                    >
                      {showPassword ? (
                        <svg className="h-5 w-5 text-gray-400 hover:text-gray-600 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={1.5} d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                          <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={1.5} d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                      ) : (
                        <svg className="h-5 w-5 text-gray-400 hover:text-gray-600 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={1.5} d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L6.59 6.59m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                        </svg>
                      )}
                    </button>
                  </div>
                  <InputError message={errors.password} className="mt-1" />
                </div>

                {/* Remember me checkbox */}
                <div className="flex items-center">
                  <label className="flex items-center space-x-3 cursor-pointer group">
                    <Checkbox
                      name="remember"
                      checked={data.remember}
                      onChange={(e) => setData('remember', e.target.checked)}
                      className="border-gray-300 group-hover:border-gray-900 text-gray-900"
                    />
                    <span className="text-gray-700 group-hover:text-gray-900 transition-colors">
                      Remember me
                    </span>
                  </label>
                </div>

                {/* Submit button */}
                <div>
                  <PrimaryButton
                    className="w-full py-3 px-4 rounded-lg bg-gray-900 hover:bg-gray-800 text-white font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none"
                    disabled={processing}
                  >
                    <div className="flex items-center justify-center space-x-2">
                      {processing ? (
                        <>
                          <svg className="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                            <circle className="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" strokeWidth="4" />
                            <path className="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" />
                          </svg>
                          <span>Signing in...</span>
                        </>
                      ) : (
                        <>
                          <span>Sign in</span>
                          <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M13 7l5 5m0 0l-5 5m5-5H6" />
                          </svg>
                        </>
                      )}
                    </div>
                  </PrimaryButton>
                </div>

          
              </form>


            </div>
          </div>

          {/* Footer */}
          <div className="mt-6 text-center">
            <p className="text-gray-600 text-sm">
              By signing in, you agree to our{' '}
              <Link href="#" className="text-gray-900 hover:text-gray-700 font-medium">
                Terms
              </Link>{' '}
              and{' '}
              <Link href="#" className="text-gray-900 hover:text-gray-700 font-medium">
                Privacy Policy
              </Link>
            </p>
          </div>
        </div>
      </div>
    </GuestLayout>
  );
}
