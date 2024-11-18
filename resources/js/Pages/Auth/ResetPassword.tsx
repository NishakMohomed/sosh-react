import { ResetPasswordForm } from '@/components/auth/reset-password-form';
import GuestLayout from '@/Layouts/GuestLayout';
import { Head } from '@inertiajs/react';

export default function ResetPassword({
    token,
    email,
}: {
    token: string;
    email: string;
}) {
    return (
        <GuestLayout>
            <Head title="Reset Password" />

            <ResetPasswordForm token={token} email={email} />
        </GuestLayout>
    );
}
