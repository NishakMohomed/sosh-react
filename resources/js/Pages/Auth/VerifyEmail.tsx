import { VerifyEmailForm } from '@/components/auth/verify-email-form';
import GuestLayout from '@/Layouts/GuestLayout';
import { Head } from '@inertiajs/react';

export default function VerifyEmail({ status }: { status?: string }) {
    return (
        <GuestLayout>
            <Head title="Email Verification" />
            <VerifyEmailForm status={status} />
        </GuestLayout>
    );
}
