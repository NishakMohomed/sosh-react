import { ConfirmPasswordForm } from '@/components/auth/confirm-password-form';
import GuestLayout from '@/Layouts/GuestLayout';
import { Head } from '@inertiajs/react';

export default function ConfirmPassword() {
    return (
        <GuestLayout>
            <Head title="Confirm Password" />

            <ConfirmPasswordForm />
        </GuestLayout>
    );
}
