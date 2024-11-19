import { MultiStepForm } from '@/components/multi-step-form/multi-step-form';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';

export default function CraftPost() {
    return (
        <AuthenticatedLayout>
            <Head title="Craft Post" />

            <div className="flex flex-1 flex-col gap-4 px-4 py-10">
                <MultiStepForm />
            </div>
        </AuthenticatedLayout>
    );
}
