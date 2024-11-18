import { ForgotPasswordForm } from '@/components/auth/forgot-password-form';
import GuestLayout from '@/Layouts/GuestLayout';
import { Head } from '@inertiajs/react';

export default function ForgotPassword({ status }: { status?: string }) {
    return (
        <GuestLayout>
            <Head title="Forgot Password" />

            <ForgotPasswordForm status={status} />
        </GuestLayout>
    );
}
